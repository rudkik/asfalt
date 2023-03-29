<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopFinish extends Controller_Magazine_Bar_BasicMagazine {

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopfinish/index';

        $dateFrom = date('Y-m-d 00:00:00');
        $dateTo = date('Y-m-d 23:59:59');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo,
                //'shop_cashbox_id' => $this->_sitePageData->operation->getShopCashboxID(),
                'sum_amount' => TRUE,
               /* 'is_special' => array(
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                ),*/
                'group_by' => array(
                    'is_special',
                    'shop_worker_id',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item', 
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );

        $result = array(
            'special' => 0,
            'cache' => 0,
            'worker' => 0,
            'return' => 0,
        );
        foreach ($ids->childs as $child){
            if($child->values['is_special'] == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT){
                $result['special'] += $child->values['amount'];
            }elseif($child->values['shop_worker_id'] == 0){
                $result['cache'] += $child->values['amount'];
            }else{
                $result['worker'] += $child->values['amount'];
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_cashbox_id' => $this->_sitePageData->operation->getShopCashboxID(),
                'sum_amount' => TRUE,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item', 
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $result['return'] = +$ids->childs[0]->values['amount'];
        }

        $this->_sitePageData->replaceDatas['realization'] = $result;

        $this->_putInMain('/main/_shop/finish/index');
    }

    public function action_report_z() {
        $this->_sitePageData->url = '/bar/shopfinish/report_z';


        Drivers_CashRegister_RemoteComputerAura3::printReport($this->_sitePageData, Drivers_CashRegister_Aura3::REPORT_Z);

        $this->redirect('/bar/shopfinish/index');
    }

    public function action_report_x() {
        $this->_sitePageData->url = '/bar/shopfinish/report_x';


        Drivers_CashRegister_RemoteComputerAura3::printReport($this->_sitePageData, Drivers_CashRegister_Aura3::REPORT_X);

        $this->redirect('/bar/shopfinish/index');
    }
}
