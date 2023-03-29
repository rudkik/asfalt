<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Shop_LoadFile extends Controller_Cabinet_BasicCabinet
{

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shoploadfile/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shoploadfiles/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop_LoadFile', $this->_sitePageData->shopID,
            "shoploadfiles/index", "shoploadfile/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/shoploadfile/index');
    }

    public function action_new(){
        $this->_sitePageData->url = '/cabinet/shoploadfile/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shoploadfile/new',
                'view::shoploadfiles/field-list',
            )
        );

        $tableID = Request_RequestParams::getParamInt('table_id');
        $typeID = Request_RequestParams::getParamInt('type');

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $typeID,
                    'table_id' => $tableID,
                ), FALSE
            ),
            FALSE
        );

        // список полей
        $this->_getFields($tableID, $typeID);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_LoadFile();
        $datas = Helpers_View::getViewObject($dataID, $model,
            'shoploadfile/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::shoploadfile/new'] = $datas;

        $this->_putInMain('/main/shoploadfile/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shoploadfile/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('LoadFiles not is found!');
        }else {
            $model = new Model_Shop_LoadFile();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Load files not is found!');
            }
        }

        $typeID = $model->getType();
        $tableID = $model->getTableID();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shoploadfile/edit',
                'view::shoploadfiles/field-list',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                ), FALSE
            ),
            FALSE
        );

        // список полей
        $this->_getFields($tableID, $typeID);

        // получаем данные
        View_View::findOne('DB_Shop_LoadFile', $this->_sitePageData->shopID, "shoploadfile/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/shoploadfile/edit');
    }

    /**
     * Получение списка полей
     * @param $tableID
     * @param $typeID
     */
    private function _getFields($tableID, $typeID){
        $fields = '<option data-id="collations" value="collations">Сопоставление</option>';
        switch($tableID){
            case Model_Shop_Good::TABLE_ID:

                $fields = $fields
                    .'<option data-id="old_id" value="old_id">ID</option>'
                    .'<option data-id="name" value="name">Название</option>'
                    .'<option data-id="price" value="price">Цена</option>'
                    .'<option data-id="info" value="info">Описание</option>'
                    .'<option data-id="image_path" value="image_path">Файл</option>'
                    .'<option data-id="article" value="article">Артикул</option>';

                $model = new Model_Shop_Table_Catalog();
                $model->setDBDriver($this->_driverDB);
                if($this->getDBObject($model, $typeID, $this->_sitePageData->shopMainID)){
                    foreach($model->getOptionsArray() as $key => $value){
                        $s = 'options.'.htmlspecialchars(Arr::path($value, 'field', Arr::path($value, 'name', '')), ENT_QUOTES);
                        $fields = $fields .'<option data-id="'.$s.'" value="'.$s.'">'.$value['title'].'</option>';
                    }
                }

                $fields = $fields
                    .'<option data-id="price_old" value="price_old">Старая цена</option>'
                    .'<option data-id="is_public" value="is_public">Опубликован</option>'
                    .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>'
                    .'<option data-id="shop_good_unit_type_id" value="shop_good_unit_type_id">Единица измерения</option>';

                break;
        }
        $this->_sitePageData->replaceDatas['view::shoploadfiles/field-list'] = $fields;
    }


    /**
     * сохранение статьи
     */
    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shoploadfile/save';

        set_time_limit(36000);

        $model = new Model_Shop_LoadFile();

        $id = Request_RequestParams::getParamInt('id');
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_500('Load files not found.');
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt('first_row', $model);

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->setOptionsArray($options);
        }

        if ($model->id < 1) {
            $type = Request_RequestParams::getParamInt('type');
            $model->setType($type);

            $tableID = Request_RequestParams::getParamInt('table_id');
            $model->setTableID($tableID);
        }else{
            $type = $model->getType();
            $tableID = $model->getTableID();
        }

        if(key_exists('file', $_FILES)) {
            $data = Helpers_Excel::loadFileInData($_FILES['file']['tmp_name'], $model->getFirstRow(), $model->getOptionsArray());

            if(Request_RequestParams::getParamBoolean('is_add_data') === TRUE){
                $model->addDataArray($data);
            }else {
                $model->setDataArray($data);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            $model->setEditUserID($this->_sitePageData->userID);
            $this->saveDBObject($model);
            $result['values'] = $model->getValues();
        }

        if (Request_RequestParams::getParamBoolean('json') || $result['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }
            if((key_exists('file', $_FILES)) && (!empty(file_exists($_FILES['file']['tmp_name'])))){
                $this->redirect('/cabinet/shoploadfile/index_data?id='.$model->id.$branchID);
            }else{
                $this->redirect('/cabinet/shoploadfile/index?type='.$type.'&table_id='.$tableID.'&shop_load_file_id='.$model->id.$branchID);
            }
        }
    }

    public function action_index_data()
    {
        $this->_sitePageData->url = '/cabinet/shoploadfile/index_data';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('LoadFiles not is found!');
        }else {
            $model = new Model_Shop_LoadFile();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Load files not is found!');
            }
        }

        $typeID = $model->getType();
        $tableID = $model->getTableID();

        if($typeID > 0) {
            switch ($tableID) {
                case Model_Shop_Good::TABLE_ID:
                    $modelTableCatalogID = new Model_Shop_Table_Catalog();
                    $modelTableCatalogID->setDBDriver($this->_driverDB);
                    $model->dbGetElement($typeID, 'shop_table_catalog_id', $modelTableCatalogID, $this->_sitePageData->shopMainID);
                    break;
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shoploadfile/index-data',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                ), FALSE
            ),
            FALSE
        );

        // список полей
        $this->_getFields($tableID, $typeID);

        // получаем данные
        $dataID = new MyArray();
        $dataID->id = $model->id;
        $dataID->values = $model->getValues(TRUE, TRUE);
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::shoploadfile/index-data'] = Helpers_View::getViewObject($dataID, $model,
            "shoploadfile/index-data", $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID);

        $this->_putInMain('/main/shoploadfile/index-data');
    }

    /**
     * Сопоставление данных с БД
     * @throws HTTP_Exception_404
     */
    public function action_runfind()
    {
        $this->_sitePageData->url = '/cabinet/shoploadfile/runfind';

        set_time_limit(36000);

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('LoadFiles not is found!');
        }else {
            $model = new Model_Shop_LoadFile();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Load files not is found!');
            }
        }

        $typeID = $model->getType();
        $tableID = $model->getTableID();

        $model->setDataArray(Api_ShopLoadFile::findCollations($model->getDataArray(), $typeID, $tableID, $this->_sitePageData, $this->_driverDB));
        $this->saveDBObject($model);

        $branchID = '';
        if($this->_sitePageData->branchID > 0){
            $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
        }
        $this->redirect('/cabinet/shoploadfile/index_data?id='.$model->id.$branchID);
    }

    /**
     * Сохранение список изменений
     */
    public function action_savelist() {
        $this->_sitePageData->url = '/cabinet/shoploadfile/savelist';

        set_time_limit(36000);

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('LoadFiles not is found!');
        }else {
            $model = new Model_Shop_LoadFile();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Load files not is found!');
            }
        }

        $typeID = $model->getType();
        $tableID = $model->getTableID();

        switch($tableID){
            case Model_Shop_Good::TABLE_ID:
                $model->setDataArray(Api_Shop_Good::saveListShopGoodsCollations($typeID, $this->_sitePageData, $this->_driverDB));
                break;

        }

        $this->saveDBObject($model);

        $branchID = '';
        if($this->_sitePageData->branchID > 0){
            $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
        }
        $this->redirect('/cabinet/shoploadfile/index_data?id='.$model->id.$branchID);
    }

    // загрузка отчета для ab1
    public function action_ab1_report()
    {
        $this->_sitePageData->url = '/cabinet/shoploadfile/ab1_report';

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                ), FALSE
            ),
            FALSE
        );

        $this->_putInMain('/main/shoploadfile/ab1-report');
    }

    public function action_ab1_save()
    {
        $this->_sitePageData->url = '/cabinet/shoploadfile/ab1_save';

        set_time_limit(3600);

        $sss = '';
        if((key_exists('file', $_FILES)) && (file_exists($_FILES['file']['tmp_name']))) {
            $data = array();

            // считываем данные с файла в массив и группирует по компаниям
            $file = file($_FILES['file']['tmp_name']);
            foreach ($file as $s) {
                $s = iconv('CP1251','UTF-8',$s);
                $s = str_replace(';;', ';', str_replace(';;', ';', $s));
                $arr = explode(';', $s);
                if(count($arr) != 7){
                    continue;
                }

                $too = $arr[5];
                if(!key_exists($too, $data)){
                    $data[$too] = array();
                }
                $data[$too][] = $arr;
            }

            $modelUser = new Model_User();
            $userIDs = Request_User::findShopUserIDs(
                $this->_sitePageData,
                $this->_driverDB,
                array(
                    'is_public_ignore' => TRUE, 'is_delete_ignore' => TRUE,
                    'type' => 15870, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
                ), 0, TRUE
            );
            $userIDs->runIndex();

            $modelNew = new Model_Shop_New();

            // пробигаемся по компаниям находим пользователя
            foreach ($data as $too => $arr) {
                $userID = $userIDs->findChildValue('name', $too);

                if($userID === FALSE){
                    $modelUser->clear();
                    $modelUser->setName($too);
                    $too = Func::get_in_translate_to_en($too);
                    $modelUser->setEmail($too.'@ab1.kz');
                    $modelUser->setPassword(Auth::instance()->hashPassword($too));
                    $modelUser->setShopUserCatalogID(15870, $this->_sitePageData->shopID);

                    $userID = $this->saveDBObject($modelUser);
                }else{
                    $userID = $userID->id;
                }

                // сохранение данных об отгрузки
                foreach ($arr as $value) {
                    $date1 = date('Y-m-d H:i:s', strtotime($value[0]));
                    $date = date('Y-m-d H:i:s', strtotime($value[1]));
                    if($date == '1970-01-01 06:00:00'){
                        continue;
                    }
                    if($date1 > $date){
                        $date = $date1;
                    }

                    $newIDs = Request_Request::find('DB_Shop_New', $this->_sitePageData->shopID, $this->_sitePageData,
                        $this->_driverDB, array('is_public_ignore' => TRUE, 'name_full' => $value[2], 'created_at' => $date, 'create_user_id' => $userID,
                            'type' => 16142, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, NULL, TRUE);

                    $modelNew->clear();
                    if(count($newIDs->childs) > 0){
                        $modelNew->__setArray(array('values' => $newIDs->childs[0]->values));
                     }

                    $modelNew->setShopNewCatalogID(16142);
                    $modelNew->setCreatedAt($date);
                    $modelNew->setName($value[2]);
                    $modelNew->setOptionsArray(
                        array(
                            'product' => $value[3],
                            'weight' => $value[4],
                        )
                    );
                    $modelNew->setCreateUserID($userID);

                    $this->saveDBObject($modelNew);
                }
            }

            // запоминаем время
            $newIDs = Request_Request::find('DB_Shop_New', $this->_sitePageData->shopID, $this->_sitePageData,
                $this->_driverDB, array('type' => 16143, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1);

            if(count($newIDs->childs) > 0){
                $this->getDBObject($modelNew, $newIDs->childs[0]->id);
            }else{
                $modelNew->clear();
            }

            $modelNew->setShopNewCatalogID(16143);
            $modelNew->setName(Request_RequestParams::getParamDateTime('report_at'));
            $this->saveDBObject($modelNew);

        }

        $this->redirect('/cabinet/shopuser/index?is_public_ignore=1&type=15870');
    }
}