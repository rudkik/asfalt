<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Печать чека на локальном компьютере используя полученные данные в виде JSON
 * Class Drivers_CashRegister_LocalComputerAura3
 */
class Drivers_CashRegister_LocalComputerAura3 {
    /**
     * Считываем есть ли данные о печати чека
     * @param $recordID
     * @return null|string
     */
    private static function getCacheCheck($recordID){
        if(empty($recordID)){
            return null;
        }
        return null;

        $memcache = new Helpers_Memcache(array('prefix' => 'aura3_'));
        return $memcache->open()->read($recordID);
    }

    /**
     * Записываем данные о печати чека
     * @param $recordID
     * @param $data
     * @return null|void
     */
    private static function setCacheCheck($recordID, $data){
        if(empty($recordID)){
            return;
        }
        return null;

        $memcache = new Helpers_Memcache(array('prefix' => 'aura3_'));
        $memcache->open()->write($recordID, $data);
    }

    /**
     * Печать возвратного чека на локальном компьютере используя полученные данные в виде JSON
     * @param $jsonData
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function printReturnFiscalCheck($jsonData) {
        $jsonData = json_decode($jsonData, TRUE);
        if(!is_array($jsonData)){
            throw new HTTP_Exception_500('Request data not array! #20201291127');
        }

        if(!key_exists('data', $jsonData) || !key_exists('paid_amount', $jsonData)){
            throw new HTTP_Exception_500('Request data not correct! #2001291127');
        }

        // проверяем, чтобы не печатать чек повторно
        $recordID = Arr::path($jsonData, 'record_id', '');
        $data = self::getCacheCheck($recordID);
        if($data !== null){
            return $data;
        }

        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();
        $fiscalCheck->loadJson($jsonData['data']);

        $aura3 = new Drivers_CashRegister_Aura3();
        $data = $aura3->printFiscalCheck(
            floatval($jsonData['paid_amount']), $fiscalCheck,
            Drivers_CashRegister_Aura3::PAYMENT_CASH,
            Drivers_CashRegister_Aura3::OPERATION_SELL_RETURN
        );
        self::setCacheCheck($recordID, $data);

        return $data;
    }

    /**
     * Печать чека на локальном компьютере используя полученные данные в виде JSON
     * @param $jsonData
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function printFiscalCheck($jsonData) {
        $jsonData = json_decode($jsonData, TRUE);
        if(!is_array($jsonData)){
            throw new HTTP_Exception_500('Request data not array! #20201291127');
        }

        if(!key_exists('data', $jsonData) || !key_exists('paid_amount', $jsonData)
            || !key_exists('payment_type', $jsonData) || !key_exists('operation_type', $jsonData)){
            throw new HTTP_Exception_500('Request data not correct! #2001291127');
        }

        // проверяем, чтобы не печатать чек повторно
        $recordID = Arr::path($jsonData, 'record_id', '');
        $data = self::getCacheCheck($recordID);
        if($data !== null){
            return $data;
        }

        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();
        $fiscalCheck->loadJson($jsonData['data']);

        $aura3 = new Drivers_CashRegister_Aura3();
        $data = $aura3->printFiscalCheck(
            floatval($jsonData['paid_amount']), $fiscalCheck,
            $jsonData['payment_type'], $jsonData['operation_type']
        );
        self::setCacheCheck($recordID, $data);

        return $data;
    }

    /**
     * Печать отчетов на локальном компьютере используя полученные данные в виде JSON
     * @param $jsonData
     * @throws HTTP_Exception_500
     */
    public function printReport($jsonData){
        $jsonData = json_decode($jsonData, TRUE);
        if(!key_exists('view_report', $jsonData)){
            throw new HTTP_Exception_500('Request data not correct! #2001291128');
        }

        $aura3 = new Drivers_CashRegister_Aura3();
        $aura3->printReport($jsonData['view_report']);
    }

    /**
     * Открытие смены
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function openShift() {
        $aura3 = new Drivers_CashRegister_Aura3();
        return $aura3->openShift();
    }

    /**
     * Закрытие смены
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function closeShift() {
        $aura3 = new Drivers_CashRegister_Aura3();
        return $aura3->closeShift();
    }

    /**
     * Проверка соединения
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function testConnection() {
        $aura3 = new Drivers_CashRegister_Aura3();
        return $aura3->testConnection();
    }

    /**
     * Проверка соединения
     * @return string
     * @throws HTTP_Exception_500
     */
    public static function status() {
        $aura3 = new Drivers_CashRegister_Aura3();
        return $aura3->status();
    }
}