<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopFinish extends Controller_Ab1_Cash_BasicAb1 {

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopfinish/index';

        /** @var Model_Ab1_Shop_Cashbox $cashbox */
        $cashbox = $this->_sitePageData->operation->getElement('shop_cashbox_id', true, $this->_sitePageData->shopMainID);
        if (empty($cashbox)) {
            throw new HTTP_Exception_500('Cashbox no found. #120320162100');
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
        $this->_sitePageData->url = '/cash/shopfinish/report_z';


        Drivers_CashRegister_RemoteComputerAura3::printReport($this->_sitePageData, Drivers_CashRegister_Aura3::REPORT_Z);

        $this->redirect('/cash/shopfinish/index');
    }

    public function action_report_x() {
        $this->_sitePageData->url = '/cash/shopfinish/report_x';


        Drivers_CashRegister_RemoteComputerAura3::printReport($this->_sitePageData, Drivers_CashRegister_Aura3::REPORT_X);

        $this->redirect('/cash/shopfinish/index');
    }

    public function action_aura3_status() {
        $this->_sitePageData->url = '/cash/shopfinish/aura3_status';

        $result = Drivers_CashRegister_RemoteComputerAura3::status($this->_sitePageData);

        $this->response->body(
            Json::json_encode(
                $result
            )
        );
    }

    public function action_open_shift() {
        $this->_sitePageData->url = '/cash/shopfinish/open_shift';

        Drivers_CashRegister_RemoteComputerAura3::openShift($this->_sitePageData);

        $this->redirect('/cash/shopfinish/index');
    }

    public function action_close_shift() {
        $this->_sitePageData->url = '/cash/shopfinish/close_shift';

        Drivers_CashRegister_RemoteComputerAura3::closeShift($this->_sitePageData);

        $this->redirect('/cash/shopfinish/index');
    }
}
