<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopConsumable extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Consumable';
        $this->controllerName = 'shopconsumable';
        $this->tableID = Model_Hotel_Shop_Consumable::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Consumable::TABLE_NAME;
        $this->objectName = 'consumable';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopconsumable/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Consumable', $this->_sitePageData->shopID, "_shop/consumable/list/index",
            "_shop/consumable/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/consumable/index');
    }

    public function action_json() {

        $this->_getJSONList(
            $this->_sitePageData->shopID,
            [],
            array(
                'update_user_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopconsumable/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/consumable/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Consumable(),
            '_shop/consumable/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopconsumable/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/consumable/one/edit',
            )
        );

        // id записи
        $shopConsumableID = Request_RequestParams::getParamInt('id');
        if ($shopConsumableID === NULL) {
            throw new HTTP_Exception_404('Consumable order not is found!');
        }else {
            $model = new Model_Hotel_Shop_Consumable();
            if (! $this->dublicateObjectLanguage($model, $shopConsumableID)) {
                throw new HTTP_Exception_404('Consumable order not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Consumable', $this->_sitePageData->shopID, "_shop/consumable/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopConsumableID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopconsumable/save';

        $result = Api_Hotel_Shop_Consumable::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'update_user_name' => array(
                    'id' => 'update_user_id',
                    'model' => new Model_User(),
                ),
            )
        );
    }
}
