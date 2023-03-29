<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Asu_BasicAb1 extends Controller_Ab1_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'asu';
        $this->prefixView = 'asu';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'asu';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_ASU;
    }

    public function _putInMain($file, $mainShablonPath = '')
    {
        $this->_sitePageData->addReplaceAndGlobalDatas('view::car_count',
            Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => $this->_sitePageData->operation->getShopTableSelectID(),
                    'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU, 'is_exit' => 0,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    'count_id' => TRUE))->childs[0]->values['count']
            + Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('shop_turn_place_id' => $this->_sitePageData->operation->getShopTableSelectID(),
                    'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU, 'is_exit' => 0,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                    'count_id' => TRUE))->childs[0]->values['count']);

        return parent::_putInMain($file, $mainShablonPath);
    }
}