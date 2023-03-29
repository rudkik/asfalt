<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopTransport extends Controller_Ab1_Make_BasicAb1 {

    public function action_director_index() {
        $this->_sitePageData->url = '/make/shoptransport/director_index';

        $this->_requestListDB('DB_Ab1_Transport_View');
        $this->_requestListDB('DB_Ab1_Transport_Work');
        $this->_requestShopBranches($this->_sitePageData->shopID, true);

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find(
            'DB_Ab1_Shop_Transport', $this->_sitePageData->shopID,
            '_shop/transport/list/director-index', '_shop/transport/one/director-index',
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 25, 'shop_branch_storage_id' => $this->_sitePageData->shopID),
            array(
                'shop_transport_mark_id' => array('name'),
                'shop_transport_driver_id' => array('name'),
                'shop_transport_fuel_storage_id' => array('name'),
                'shop_branch_storage_id' => array('name'),
                'shop_transport_mark_id.transport_work_id' => array('name'),
                'shop_transport_mark_id.transport_view_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/director-index', 'ab1/_all');
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/make/shoptransport/statistics';

        $this->_actionShopTransportStatistics();
    }
}
