<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopBranch extends Controller_Sladushka_Manager_File
{
    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopbranch';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'branch';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/manager/shopbranch/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/index',
            )
        );

        // тип объекта
        $type = $this->_getType();
        // список объектов
        $this->_requestTableObjects($type);
        $this->_requestShopOperation();

        // получаем список
        View_View::find('DB_Shop', $this->_sitePageData->shopID, "_shop/branch/list/index", "_shop/branch/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 15, 'sort_by' => array('value' => array('name' => 'asc')),
                'shop_operation_id' => $this->_sitePageData->operationID));

        $this->_putInMain('/main/_shop/branch/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/manager/shopbranch/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/new',
            )
        );

        // тип объекта
        $type = $this->_getType();

        $this->_requestTableObjects($type);
        $this->_requestShopCity();

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id', $type);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/branch/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop(),
            '_shop/branch/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/branch/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/manager/shopbranch/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/edit',
            )
        );

        // id записи
        $shopBranchID = Request_RequestParams::getParamInt('id');
        if ($shopBranchID === NULL) {
            throw new HTTP_Exception_404('Branch not is found!');
        }else {
            $model = new Model_Shop();
            if (! $this->dublicateObjectLanguage($model, $shopBranchID)) {
                throw new HTTP_Exception_404('Branch not is found!');
            }
        }

        // тип объекта
        $type = $this->_getType();

        $this->_requestShopTableObjectToFilter($type, $model);
        $this->_requestTableObjects($type, $model);
        $this->_requestShopCity($model->getCityID());
        $this->_requestShopOperation($model->getShopOperationID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopBranchID,
                    'type' => $type['id'],
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop', $this->_sitePageData->shopID, "_shop/branch/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopBranchID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/branch/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/manager/shopbranch/save';
        $result = Api_Shop_Branch::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Удаление
     */
    public function action_del() {
        $this->_sitePageData->url = '/manager/shopbranch/del';

        Api_Shop_Branch::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }

    /**
     * Загружаем данные из другого сайта
     * Параметры:
     * url - откуда загружать файл
     * auth[email] - данные для авторизации логин
     * auth[password] - данные для авторизации пароль
     * request_params - array параметры для получения списка из БД
     * add_params - array параметры добавляемые к записи при создании
     * @throws HTTP_Exception_500
     */
    public function action_load_xml_in_url() {
        set_time_limit(3600000);
        $this->_sitePageData->url = '/manager/shopbranch/load_xml_in_url';

        $url = Request_RequestParams::getParamStr('url');
        if(empty($url)){
            throw new HTTP_Exception_500('URL empty.');
        }

        $data = array (
            'auth' => array(
                'email' => Request_RequestParams::getParamStr('email'),
                'password' => Request_RequestParams::getParamStr('password'),
            )
        );
        $data = http_build_query($data);

        $context_options = array (
            'http' => array (
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data
            )
        );
        $context = stream_context_create($context_options);

        $xml = file_get_contents($url, NULL, $context);
        if($xml === FALSE) {
            throw new HTTP_Exception_500('Load URL error.');
        }

        $xml = simplexml_load_string($xml);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        $records = Arr::path($array, 'record', array());

        // параметры запроса в базу данных
        $params = Request_RequestParams::getParamArray('request_params', array(), array());
        $params = array_merge($params, array('is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получение списка филиалов
        $shopBranchs = Request_Shop::findShopBranchIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE);

        // параметры для добавления нового филиала
        $addParams = Request_RequestParams::getParamArray('add_params', array(), array());

        $model = new Model_Shop();
        foreach($records as $record){
            $id = intval(Arr::path($record, 'id', 0));
            if($id < 1){
                continue;
            }

            // проверяем если ли уже данная запись
            $isNew = TRUE;
            foreach($shopBranchs->childs as $index => $shopBranch){
                if($shopBranch->values['old_id'] == $id){

                    if(intval(Arr::path($record, 'is_delete', 0)) === 1){
                        $model->clear();
                        $model->id = $shopBranch->id;
                        $model->globalID = $shopBranch->values['global_id'];
                        $this->deleteDBObject($model);
                    }else {
                        $model->clear();
                        $model->id = $shopBranch->id;
                        $model->globalID = $shopBranch->values['global_id'];
                        if (intval(Arr::path($record, 'is_public', 1)) === 0) {
                            $model->setIsPublic(FALSE);
                        }

                       /* $tmp =  Arr::path($record, 'files', '');
                        if(is_array($tmp)) {
                            $model->setFilesArray($tmp);
                        }*/

                        $model->setIsDelete(FALSE);
                        $this->saveDBObject($model);
                    }

                    unset($shopBranchs->childs[$index]);
                    $isNew = FALSE;
                    continue;
                }
            }
            if($isNew === FALSE){
                continue;
            }

            // загружаем данные из xml
            $model->clear();
            foreach($record as $name => $value){
                switch($name) {
                    case 'is_public': $model->setIsPublic($value); break;
                    case 'city_id': $model->setCityID($value); break;
                    case 'name': $model->setName($value); break;
                    case 'official_name': $model->setOfficialName($value); break;
                    case 'text': $model->setText($value); break;
                    case 'info_delivery': $model->setInfoDelivery($value); break;
                    case 'info_paid': $model->setInfoPaid($value); break;
                    case 'image_path': $model->setFileLogotype($value); break;
                    case 'work_time': $model->setWorkTime($value); break;
                    case 'delivery_work_time': $model->setDeliveryWorkTime($value); break;
                    case 'is_delete': $model->setIsDelete($value); break;
                    case 'created_at': break;
                    case 'delivery_options': $model->setDeliveryOptions($value); break;
                    case 'shop_branch_catalog_id': $model->setShopBranchCatalogID(intval($value)); break;
                    case 'is_active': $model->setIsActive($value); break;
                    case 'order': $model->setOrder($value); break;
                    case 'id': $model->setOldID($value); break;
                    case 'files':
                        if(is_array($value)) {
                            $model->setFilesArray($value);
                        }
                        break;
                }
            }

            // загружаем данные по умолчанию, которые надо задать
            foreach($addParams as $name => $value){
                switch($name) {
                    case 'is_public': $model->setIsPublic($value); break;
                    case 'city_id': $model->setCityID($value); break;
                    case 'name': $model->setName($value); break;
                    case 'official_name': $model->setOfficialName($value); break;
                    case 'text': $model->setText($value); break;
                    case 'info_delivery': $model->setInfoDelivery($value); break;
                    case 'info_paid': $model->setInfoPaid($value); break;
                    case 'image_path': $model->setFileLogotype($value); break;
                    case 'work_time': $model->setWorkTime($value); break;
                    case 'delivery_work_time': $model->setDeliveryWorkTime($value); break;
                    case 'is_delete': $model->setIsDelete($value); break;
                    case 'created_at': break;
                    case 'delivery_options': $model->setDeliveryOptions($value); break;
                    case 'shop_branch_catalog_id': $model->setShopBranchCatalogID(intval($value)); break;
                    case 'shop_branch_type_id': $model->setShopTableCatalogID(intval($value)); break;
                    case 'is_active': $model->setIsActive($value); break;
                    case 'order': $model->setOrder($value); break;
                    case 'id': $model->setOldID($value); break;
                    case 'files':
                        if(is_array($value)) {
                            $model->setFilesArray($value);
                        }
                        break;
                }
            }
            $model->setMainShopID($this->_sitePageData->shopID);
            $this->saveDBObject($model, 0);
        }

        // удаляем магазины, которые не были найдены
        foreach($shopBranchs->childs as $index => $shopBranch){
            $model->clear();
            $model->id = $shopBranch->id;
            $model->globalID = $shopBranch->values['global_id'];
            $this->deleteDBObject($model);
        }

        $this->response->body('Finished');
    }


    /**
     * Делаем запрос на список городов
     * @param $landID
     * @param null|integer|array $currentID
     */
    protected function _requestShopCity($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::city/list/list',
            )
        );

        $data = View_View::findAll('DB_City', $this->_sitePageData->shopID, "city/list/list", "city/one/list",
            $this->_sitePageData, $this->_driverDB);

        if($currentID !== NULL){
            if(is_array($currentID)) {
                foreach($currentID as $value) {
                    $s = 'data-id="' . $value . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
                $this->_sitePageData->replaceDatas['view::city/list/list'] = $data;
            }else{
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
                $this->_sitePageData->replaceDatas['view::city/list/list'] = $data;
            }
        }
    }

    /**
     * Делаем запрос на список операторов
     * @param array $type
     * @return string
     */
    protected function _requestShopOperation($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
            "_shop/operation/list/list", "_shop/operation/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
        }

        return $data;
    }
}
