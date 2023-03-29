<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopBillItem extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Bill_Item';
        $this->controllerName = 'shopbillitem';
        $this->tableID = Model_Hotel_Shop_Bill_Item::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Bill_Item::TABLE_NAME;
        $this->objectName = 'billitem';

        parent::__construct($request, $response);
    }

    public function action_current_entry() {
        $this->_sitePageData->url = '/hotel/shopbillitem/current_entry';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/item/list/current/entry',
            )
        );

        View_View::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, "_shop/bill/item/list/current/entry",
            "_shop/bill/item/one/current/entry", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bill/item/current/entry');
    }

    public function action_current_exit() {
        $this->_sitePageData->url = '/hotel/shopbillitem/current_exit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/item/list/current/exit',
            )
        );

        View_View::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, "_shop/bill/item/list/current/exit",
            "_shop/bill/item/one/current/exit", $this->_sitePageData, $this->_driverDB, array(),
            array('limit' => 1), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bill/item/current/exit');
    }

    public function action_current_relax() {
        $this->_sitePageData->url = '/hotel/shopbillitem/current_relax';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/item/list/current/relax',
            )
        );

        View_View::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, "_shop/bill/item/list/current/relax",
            "_shop/bill/item/one/current/relax", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bill/item/current/relax');
    }

    public function action_json_entry() {
        $this->_sitePageData->url = '/hotel/shopbillitem/json_entry';

        $this->_getJSONList(
            $this->_sitePageData->shopID,
            ['date_from' => date('Y-m-d')],
            array(
                'shop_bill_id' => array('is_finish', 'finish_date'),
                'shop_client_id' => array('name', 'phone'),
                'shop_room_id' => array('name'),
            )
        );
    }

    public function action_json_exit() {
        $this->_sitePageData->url = '/hotel/shopbillitem/json_exit';

        $this->_getJSONList(
            $this->_sitePageData->shopID,
            ['date_to' => date('Y-m-d', strtotime('-1 day'))],
            array(
                'shop_bill_id' => array('is_finish', 'finish_date'),
                'shop_client_id' => array('name', 'phone'),
                'shop_room_id' => array('name'),
            )
        );
    }

    public function action_json_relax() {
        $this->_sitePageData->url = '/hotel/shopbillitem/json_relax';

        $this->_getJSONList(
            $this->_sitePageData->shopID,
            [
                'period_from' => date('Y-m-d'),
                'period_to' => date('Y-m-d'),
            ],
            array(
                'shop_bill_id' => array('is_finish', 'finish_date'),
                'shop_client_id' => array('name', 'phone'),
                'shop_room_id' => array('name'),
            )
        );
    }

    public function action_bill_edit()
    {
        $this->_sitePageData->url = '/hotel/shopbillitem/bill_edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill_Item();
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_404('Bill item not is found!');
        }

        self::redirect('/hotel/shopbill/edit?id='.$model->getShopBillID());
    }
}
