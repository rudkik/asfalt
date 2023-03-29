<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopAddressContact extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_AddressContact';
        $this->controllerName = 'shopaddresscontact';
        $this->tableID = Model_Shop_AddressContact::TABLE_ID;
        $this->tableName = Model_Shop_AddressContact::TABLE_NAME;
        $this->objectName = 'addresscontact';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopaddresscontact/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/contact/list/index',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();
        $this->_requestTranslateDataLanguages();

        // получаем список
        View_View::find('DB_Shop_AddressContact', $this->_sitePageData->shopID, "_shop/address/contact/list/index", "_shop/address/contact/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), 
            array('city_id' => array('name'), 'land_id' => array('name'), 'contact_type_id' => array('name'), 'shop_table_rubric_id' => array('name')));

        $this->_putInMain('/main/_shop/address/contact/index');
    }

    public function action_sort(){
        $this->_sitePageData->url = '/cabinet/shopaddresscontact/sort';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/contact/list/index',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();
        $this->_requestTranslateDataLanguages();

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/address/contact/list/index'] = View_View::find('DB_Shop_AddressContact', $this->_sitePageData->shopID,
            "_shop/address/contact/list/sort", "_shop/address/contact/one/sort", $this->_sitePageData, $this->_driverDB,
            array_merge($_GET, $_POST, array('sort_by'=>array('order' => 'asc', 'id' => 'desc'), 'limit_page' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)),
            array('city_id' => array('name'), 'land_id' => array('name'), 'contact_type_id' => array('name'), 'shop_table_rubric_id' => array('name')));

        $this->_putInMain('/main/_shop/address/contact/index');
    }

    public function action_index_edit() {
        $this->_sitePageData->url = '/cabinet/shopaddresscontact/index_edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/contact/list/index',
                'view::editfields/list',
            )
        );

        $this->_requestShopTableRubric(0);
        $this->_requestLand();
        $this->_requestTranslateDataLanguages();

        $fields =
            '<option data-id="old_id" value="old_id">ID</option>'
            .'<option data-id="name" value="name">Контакт</option>'
            .'<option data-id="text" value="text">Примечание</option>'
            .'<option data-id="shop_table_rubric_id" value="shop_table_rubric_id">Рубрика</option>';
        $this->_sitePageData->replaceDatas['view::editfields/list'] = $fields;

        // получаем список
        $this->_sitePageData->replaceDatas['view::_shop/address/contact/list/index'] = View_View::find('DB_Shop_AddressContact', $this->_sitePageData->shopID,
            "_shop/address/contact/list/index-edit", "_shop/address/contact/one/index-edit", $this->_sitePageData, $this->_driverDB,
            array_merge(array('sort_by'=>array('name' => 'asc', 'id' => 'desc', 'limit_page' => 25)), $_GET, $_POST, array('type' => $type['id'], 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE)));

        $this->_putInMain('/main/_shop/address/contact/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cabinet/shopaddresscontact/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/contact/one/new',
            )
        );

        $this->_requestLand();
        $this->_requestShopTableRubric(0);
        $this->_requestContactType();

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

        $this->_sitePageData->replaceDatas['view::_shop/address/contact/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_AddressContact(),
            '_shop/address/contact/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/address/contact/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopaddresscontact/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/address/contact/one/edit',
            )
        );

        // id записи
        $shopAddressContactID = Request_RequestParams::getParamInt('id');
        if ($shopAddressContactID === NULL) {
            throw new HTTP_Exception_404('Contact not is found!');
        }else {
            $model = new Model_Shop_AddressContact();
            if (! $this->dublicateObjectLanguage($model, $shopAddressContactID)) {
                throw new HTTP_Exception_404('Contact not is found!');
            }
        }

        $this->_requestLand($model->getLandID());
        $this->_requestCity($model->getLandID(), $model->getCityID());
        $this->_requestShopTableRubric($model->getShopTableRubricID());
        $this->_requestContactType($model->getContactTypeID());

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $shopAddressContactID,
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_Shop_AddressContact', $this->_sitePageData->shopID, "_shop/address/contact/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopAddressContactID));

        $this->_putInMain('/main/_shop/address/contact/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopaddresscontact/save';
        $result = Api_Shop_AddressContact::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Делаем запрос на список типов контактов
     * @param null $currentID
     */
    protected function _requestContactType($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::contacttype/list/list',
            )
        );

        $data = View_View::findAll('DB_ContactType', $this->_sitePageData->shopID,
            "contacttype/list/list", "contacttype/one/list", $this->_sitePageData, $this->_driverDB);

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::contacttype/list/list'] = $data;
        }
    }
}
