<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopAddress extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Address';
        $this->controllerName = 'shopaddress';
        $this->tableID = Model_Shop_Address::TABLE_ID;
        $this->tableName = Model_Shop_Address::TABLE_NAME;
        $this->objectName = 'address';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_editmain(){
        $this->_sitePageData->url = '/cabinet/shopaddress/editmain';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/one/edit',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop('', FALSE);

        // id записи
        $shopAddressID = Request_Shop_Address::getMainAddressID($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);
        if($shopAddressID < 1){
            $tmp = $this->_sitePageData->dataLanguageID;
            $this->_sitePageData->dataLanguageID = $this->_sitePageData->shop->getDefaultLanguageID();
            $shopAddressID = Request_Shop_Address::getMainAddressID($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);
            $this->_sitePageData->dataLanguageID = $tmp;
        }

        $model = new Model_Shop_Address();
        $model->setDBDriver($this->_driverDB);
        if($shopAddressID > 0) {
            if (!$this->getDBObject($model, $shopAddressID)) {
                throw new HTTP_Exception_404('Address not is found!');
            }
        }else{
            $model->setIsMainShop(TRUE);
        }

        $this->_requestShopTableRubric($model->getShopTableRubricID());
        $this->_requestLand($model->getLandID());
        $this->_requestCity($model->getLandID(), $model->getCityID());

        $dataID = new MyArray();
        $dataID->id = $shopAddressID;
        $dataID->values = $model->getValues(TRUE, TRUE);
        $dataID->isFindDB = TRUE;

        $data = Helpers_View::getViewObject($dataID, $model, '_shop/address/one/edit', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/address/one/edit'] = $data;

        $this->_putInMain('/main/_shop/address/edit');
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopaddress/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/list/index',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();
        $this->_requestTranslateTr();
        $this->_requestTranslateDataLanguages();

        // получаем список
        View_View::find('DB_Shop_Address', $this->_sitePageData->shopID, "_shop/address/list/index", "_shop/address/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/address/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopaddress/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/list/index',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();
        $this->_requestTranslateDataLanguages();

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/address/list/index'] = View_View::find('DB_Shop_Address', $this->_sitePageData->shopID,
            "_shop/address/list/sort", "_shop/address/one/sort", $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)));

        $this->_putInMain('/main/_shop/address/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopaddress/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/list/index',
                'view::editfields/list',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();
        $this->_requestTranslateDataLanguages();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Название</option>'
            .'<option data-id="text" value="info">Описание</option>'
            .'<option data-id="is_public" value="is_public">Опубликован</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/address/list/index'] = View_View::find('DB_Shop_Address', $this->_sitePageData->shopID,
            "_shop/address/list/index-edit", "_shop/address/one/index-edit",
            $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/address/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopaddress/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/one/new',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/address/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Address(),
            '_shop/address/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/address/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopaddress/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/one/edit',
            )
        );

        // id записи
        $shopAddressID = Request_RequestParams::getParamInt('id');
        if ($shopAddressID === NULL) {
            throw new HTTP_Exception_404('Address not is found!');
        }else {
            $model = new Model_Shop_Address();
            if (! $this->dublicateObjectLanguage($model, $shopAddressID)) {
                throw new HTTP_Exception_404('Address not is found!');
            }
        }

        $this->_requestShopTableRubric($model->getShopTableRubricID());
        $this->_requestLand($model->getLandID());
        $this->_requestCity($model->getLandID(), $model->getCityID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopAddressID,
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_Address', $this->_sitePageData->shopID, "_shop/address/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopAddressID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/address/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopaddress/save';
        $result = Api_Shop_Address::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
