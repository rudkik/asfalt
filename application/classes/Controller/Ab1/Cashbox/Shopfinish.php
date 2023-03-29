<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopFinish extends Controller_Ab1_Cashbox_BasicAb1 {

    public function action_index() {
        $this->_sitePageData->url = '/cashbox/shopfinish/index';

        /** @var Model_Ab1_Shop_Cashbox $cashbox */
        $cashbox = $this->_sitePageData->operation->getElement('shop_cashbox_id', true, $this->_sitePageData->shopMainID);
        if (empty($cashbox)) {
            throw new HTTP_Exception_500('Cashbox no found');
        }

        $dateFrom = date('Y-m-d 00:00:00');
        $dateTo = date('Y-m-d 23:59:59');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_amount' => TRUE,
                'shop_cashbox_id' => $cashbox->id,
            )
        );

        // приход денег
        $ids = Request_Request::find('DB_Ab1_Shop_Payment',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );

        $this->_sitePageData->replaceDatas['payment'] = count($ids->childs) > 0 ? $ids->childs[0]->values['amount'] : 0;

        // возврат денег
        $ids = Request_Request::find('DB_Ab1_Shop_Payment_Return',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        $this->_sitePageData->replaceDatas['return'] = count($ids->childs) > 0 ? $ids->childs[0]->values['amount'] : 0;

        $this->_putInMain('/main/_shop/finish/index');
    }

    public function action_report_z() {
        $this->_sitePageData->url = '/cashbox/shopfinish/report_z';


        Drivers_CashRegister_RemoteComputerAura3::printReport($this->_sitePageData, Drivers_CashRegister_Aura3::REPORT_Z);

        $this->redirect('/cashbox/shopfinish/index');
    }

    public function action_report_x() {
        $this->_sitePageData->url = '/cashbox/shopfinish/report_x';


        Drivers_CashRegister_RemoteComputerAura3::printReport($this->_sitePageData, Drivers_CashRegister_Aura3::REPORT_X);

        $this->redirect('/cashbox/shopfinish/index');
    }
}
