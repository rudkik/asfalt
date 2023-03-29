<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopXML extends Controller_Hotel_BasicShop {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopxml';
        $this->objectName = 'xml';

        parent::__construct($request, $response);
    }

    public function action_save_room() {
        $this->_sitePageData->url = '/hotel/shopxml/save_room';

        Api_Hotel_Shop_Room::saveXML($this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_save_room_type() {
        $this->_sitePageData->url = '/hotel/shopxml/save_room_type';

        Api_Hotel_Shop_Room_Type::saveXML($this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_save_service() {
        $this->_sitePageData->url = '/hotel/shopxml/save_service';

        Api_Hotel_Shop_Service::saveXML($this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_save_client() {
        $this->_sitePageData->url = '/hotel/shopxml/save_client';

        Api_Hotel_Shop_Client::saveXML($this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_save_act_service() {
        $this->_sitePageData->url = '/hotel/shopxml/save_act_service';

        Api_Hotel_Shop_Bill::saveActServiceXML($this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_save_consumable() {
        $this->_sitePageData->url = '/hotel/shopxml/save_consumable';

        Api_Hotel_Shop_Consumable::saveXML(Request_RequestParams::getParamDateTime('created_at_from'),
            Request_RequestParams::getParamDateTime('created_at_to'), $this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_save_payment() {
        $this->_sitePageData->url = '/hotel/shopxml/save_payment';

        Api_Hotel_Shop_Payment::saveXML(Request_RequestParams::getParamDateTime('created_at_from'),
            Request_RequestParams::getParamDateTime('created_at_to'), $this->_sitePageData, $this->_driverDB, TRUE);

        exit();
    }

    public function action_load_payment() {
        $this->_sitePageData->url = '/hotel/shopxml/load_payment';

        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Hotel_Shop_Payment::loadXML($_FILES['file']['tmp_name'], $this->_sitePageData, $this->_driverDB);
        }

        exit();
    }



}
