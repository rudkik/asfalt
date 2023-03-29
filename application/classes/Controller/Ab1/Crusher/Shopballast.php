<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Crusher_ShopBallast extends Controller_Ab1_Crusher_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast';
        $this->controllerName = 'shopballast';
        $this->tableID = Model_Ab1_Shop_Ballast::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast::TABLE_NAME;
        $this->objectName = 'ballast';

        parent::__construct($request, $response);
    }

    public function action_sum_quantity()
    {
        $this->_sitePageData->url = '/crusher/shopballast/sum_quantity';

        $date = Request_RequestParams::getParamDate('date');

        $dateFrom = $date . ' 06:00:00';
        $dateTo = Helpers_DateTime::getDateFormatPHP(Helpers_DateTime::plusDays($date, 1)) . ' 06:00:00';

        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => true,
                'shop_raw_id' => Request_RequestParams::getParamInt('shop_raw_id'),
                'shop_ballast_crusher_id' => Request_RequestParams::getParamInt('shop_ballast_crusher_id'),
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $ballastSum = Request_Request::find(
            'DB_Ab1_Shop_Ballast', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params
        );

        $this->response->body(
            json_encode(
                array(
                    'quantity' => $ballastSum->childs[0]->values['quantity'],
                )
            )
        );
    }
}
