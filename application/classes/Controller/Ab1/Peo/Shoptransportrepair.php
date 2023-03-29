<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportRepair extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Repair';
        $this->controllerName = 'shoptransportrepair';
        $this->tableID = Model_Ab1_Shop_Transport_Repair::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Repair::TABLE_NAME;
        $this->objectName = 'transportrepair';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shoptransportrepair/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestShopTransports();

        View_View::find(
            'DB_Ab1_Shop_Transport_Repair', $this->_sitePageData->shopID,
            '_shop/transport/repair/list/total', '_shop/transport/repair/one/total',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array_merge(
                    $_GET,
                    $_POST,
                    [
                        'sum_hours' => true,
                        'sort_by' => null,
                    ]
                )
            )
        );

        parent::_actionIndex(
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name'),
                'create_user_id' => array('name'),
            ),
            array(
                'sort_by' => array(
                    'date' => 'asc',
                )
            )
        );
    }
}

