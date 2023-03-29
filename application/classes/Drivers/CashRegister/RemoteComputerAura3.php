<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Работа с кассовым аппаратом на удаленном компьютере
 */
class Drivers_CashRegister_RemoteComputerAura3 {
    /**
     * @param SitePageData $sitePageData
     * @return Model_Ab1_Shop_Cashbox
     * @throws HTTP_Exception_500
     */
    private static function _getCashBox(SitePageData $sitePageData){
        $cashBox = $sitePageData->operation->getElement('shop_cashbox_id', true, 0);
        if(empty($cashBox)){
            throw new HTTP_Exception_500('Cashbox no found. #180220150502');
        }

        return $cashBox;
    }

    /**
     * Печать отчетов на удаленном компьютере
     * @param SitePageData $sitePageData
     * @param $viewReport
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function printReport(SitePageData $sitePageData, $viewReport = self::REPORT_Z){
        $cashBox = self::_getCashBox($sitePageData);

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'view_report' => $viewReport,
        );
        $jsonData = Json::json_encode($jsonData);

        try {
            $url = 'http://' . $cashBox->getIP() . '/ab1/print_report';

            $result = self::getDataURLEmulationBrowser($url, $jsonData);

            $status = Arr::path($result, 'status', FALSE);
        }catch(Exception $e){
            $status = FALSE;
        }

        return $status;
    }

    /**
     * Печать чека на удаленном компьютере
     * @param string $recordID - ID записи, чтобы не печатать повторный чек
     * @param float $paymentAmount
     * @param Drivers_CashRegister_Aura3_FiscalCheck $fiscalCheck
     * @param SitePageData $sitePageData
     * @param int $paymentType
     * @param int $operationType
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function printFiscalCheck($recordID, float $paymentAmount, Drivers_CashRegister_Aura3_FiscalCheck $fiscalCheck,
                                            SitePageData $sitePageData,
                                            $paymentType = Drivers_CashRegister_Aura3::PAYMENT_CASH,
                                            $operationType = Drivers_CashRegister_Aura3::OPERATION_SELL){
        $cashBox = self::_getCashBox($sitePageData);

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'data' => $fiscalCheck->saveJson(),
            'paid_amount' => ceil($paymentAmount),
            'payment_type' => $paymentType,
            'operation_type' => $operationType,
            'record_id' => $recordID,
        );
        $jsonData = Json::json_encode($jsonData);

        $url = 'http://'. $cashBox->getIP() . '/ab1/print_fiscal_check';
        return self::getDataURLEmulationBrowser($url, $jsonData);
    }

    /**
     * Печать возратного чека на удаленном компьютере
     * @param string $recordID - ID записи, чтобы не печатать повторный чек
     * @param float $paymentAmount
     * @param Drivers_CashRegister_Aura3_FiscalCheck $fiscalCheck
     * @param SitePageData $sitePageData
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function printReturnFiscalCheck($recordID, float $paymentAmount, Drivers_CashRegister_Aura3_FiscalCheck $fiscalCheck,
                                                  SitePageData $sitePageData){
        $cashBox = self::_getCashBox($sitePageData);

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'data' => $fiscalCheck->saveJson(),
            'paid_amount' => $paymentAmount,
            'record_id' => $recordID,
        );
        $jsonData = Json::json_encode($jsonData);

        $url = 'http://' . $cashBox->getIP() . '/ab1/print_return_fiscal_check';
        return self::getDataURLEmulationBrowser($url, $jsonData);
    }

    /**
     * Открытие смены
     * @param SitePageData $sitePageData
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function openShift(SitePageData $sitePageData){
        $cashBox = self::_getCashBox($sitePageData);

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'data' => null,
        );
        $jsonData = Json::json_encode($jsonData);

        $url = 'http://' . $cashBox->getIP() . '/ab1/open_shift';
        return self::getDataURLEmulationBrowser($url, $jsonData);
    }

    /**
     * Открытие смены
     * @param SitePageData $sitePageData
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function closeShift(SitePageData $sitePageData){
        $cashBox = self::_getCashBox($sitePageData);

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'data' => null,
        );
        $jsonData = Json::json_encode($jsonData);

        $url = 'http://' . $cashBox->getIP() . '/ab1/close_shift';
        return self::getDataURLEmulationBrowser($url, $jsonData);
    }

    /**
     * Тестирование соединения
     * @param SitePageData $sitePageData
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function testConnection(SitePageData $sitePageData){
        $cashBox = self::_getCashBox($sitePageData);
        if($cashBox->getIP() == ''){
            return false;
        }

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'data' => null,
        );
        $jsonData = Json::json_encode($jsonData);

        $url = 'http://' . $cashBox->getIP() . '/ab1/test_connection';
        return self::getDataURLEmulationBrowser($url, $jsonData);
    }

    /**
     * Статус кассового аппарата
     * @param SitePageData $sitePageData
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public static function status(SitePageData $sitePageData){
        $cashBox = self::_getCashBox($sitePageData);
        if($cashBox->getIP() == ''){
            return false;
        }

        $jsonData = array(
            'port' => $cashBox->getPort(),
            'data' => null,
        );
        $jsonData = Json::json_encode($jsonData);

        $url = 'http://' . $cashBox->getIP() . '/ab1/status';
        return self::getDataURLEmulationBrowser($url, $jsonData, 2);
    }

    /**
     * Получение данных по ссылке с эмуляцией заголовков браузера
     * @param $url
     * @param $request
     * @return mixed
     */
    private static function getDataURLEmulationBrowser($url, $request, $timeOut = 10)
    {
        $url = str_replace(' ', '%20', $url);
        $cs = curl_init();
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_COOKIE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_COOKIEFILE => APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'cookie.txt',
            CURLOPT_REFERER => null,
            CURLOPT_TIMEOUT => $timeOut,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HEADER => 0,
        );
        curl_setopt($cs, CURLOPT_POSTFIELDS, array('data' => $request));
        curl_setopt_array($cs, $opt);

        $result = curl_exec($cs);
        $httpCode = curl_getinfo($cs, CURLINFO_HTTP_CODE);
        curl_close($cs);

        if($httpCode != 200) {
            return array(
                'is_send_local' => false,
            );
        }

        $result = substr($result, strpos($result, '{'));
        $result = json_decode($result, true);

        if(!is_array($result)){
            return array(
                'is_send_local' => false,
            );
        }
        $result['is_send_local'] = true;

        return $result;
    }
}