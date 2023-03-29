<?php defined('SYSPATH') or die('No direct script access.');

class Bank_Kazkom_Pay
{
    const URL_BANK = 'https://epay.kkb.kz/jsp/process/logon.jsp'; // сюда посылаются данные для оплаты в банке
    const URL_BANK_TEST = 'https://testpay.kkb.kz/jsp/process/logon.jsp'; // сюда посылаются данные для оплаты в банке для тестирования

    const URL_BANK_PAY_STATUS = 'https://epay.kkb.kz/jsp/remote/checkOrdern.jsp'; // проверяем статус заказа
    const URL_BANK_PAY_STATUS_TEST = 'https://testpay.kkb.kz/jsp/remote/checkOrdern.jsp'; // проверяем статус заказа

    const URL_BANK_APPLY_PAY = 'https://epay.kkb.kz/jsp/remote/control.jsp'; // подтверждение списание платежа заказа
    const URL_BANK_APPLY_PAY_TEST = 'https://testpay.kkb.kz/jsp/remote/control.jsp'; // подтверждение списание платежа заказа

    const BANK_NAME = 'kkb'; // внутреннее обозначение банка
    const BANK_PAY_TYPE_ID = 900; // id оплата банком
    const BANK_TITLE = 'АО "Народный банк Казахстана"';

    private $isTest = FALSE; // тестовый режим

    // настройки магазина в базе банка
    public $shopName = ''; // Название магазина (продавца)
    public $shopID = ''; // если $merchantID одинаковый для двух магазинов
    public $merchantCerID = ''; // Серийный номер сертификата
    public $merchantID = ''; // ID продавца в системе

    // ключ банка
    public $filePublicKey = ''; // путь до файла с публичным ключом
    public $filePrivateKey = ''; // путь до файла с приватным ключом
    public $passwordPrivateKey = ''; // пароль от приватьного файла ключа

    // системные ссылки
    public $urlPayOk = ''; // ссылка показывающая клиенту при успешной оплате
    public $urlAuthBankError = ''; // ссылка показывающая клиенту при авторизации сайта в банке с ошибкой
    public $urlBillPay = '/bank/pay?bank='.self::BANK_NAME.'&table_id=#table_id#&bill_id='; // ссылка принимающая статус оплаты с банка

    public $tableID = Model_Shop_Bill::TABLE_ID; // id таблицы заказа

    // интерфейс клиента
    private $language = Model_Language::LANGUAGE_RUSSIAN; // язык интерфейса банка rus/eng
    private $currency = Model_Currency::KZT; // курс валюты

    // заказ
    private $bill = NULL;  // заказа Model_Shop_Basic_Bill
    private $billItems = array(); // массив товаров Model_Shop_Bill_Item

    // клиент
    private $emailShop = ''; // e-mail клиента

    // шаблон заказа для банка
    const MERCHANT_BANK = '<merchant cert_id="%certificate%" name="%merchant_name%"><order order_id="%order_id%" amount="%amount%" currency="%currency%"><department merchant_id="%merchant_id%" amount="%amount%"/></order></merchant>';
    // шаблон получения статуса оплаты с банка
    const MERCHANT_STATUS_PAY_BANK = '<merchant id="%merchant_id%"><order id="%order_id%"/></merchant>';
    // шаблон подтверждение списания оплаты для банка
    const MERCHANT_APPLY_PAY_BANK = '<merchant id="%merchant_id%"><command type="complete"/><payment reference="%reference%" approval_code="%approval_code%" orderid="%order_id%" amount="%amount%" currency_code="%currency%"/></merchant>';

    /* тестовый режим
        echo json_encode(
        array(
            'shopName' => 'Test shop 3',
            'shopID' => '1',
            'merchantCerID' => '00c183d70b',
            'merchantID' => '92061103',
            'filePublicKey' => 'kkbca.pem',
            'filePrivateKey' => 'cert.prv',
            'passwordPrivateKey' => '1q2w3e4r',
            'urlPayOk' => 'http:/oto.kz/bill/pay/finish',
            'urlAuthBankError' => 'http:/oto.kz/bill/pay/finish',
        )); die;
    */

    /**
     * Настройки для работы с банком
     * @param array $options
     */
    public function __construct(array $options){
        $this->shopName = Arr::path($options, 'shopName', '');
        $this->shopID = Arr::path($options, 'shopID', 1);
        $this->merchantCerID = Arr::path($options, 'merchantCerID', '');
        $this->merchantID = Arr::path($options, 'merchantID', '');
        $this->filePublicKey = Arr::path($options, 'filePublicKey', '');
        $this->filePrivateKey = Arr::path($options, 'filePrivateKey', '');
        $this->passwordPrivateKey = Arr::path($options, 'passwordPrivateKey', '');
        $this->urlPayOk = Arr::path($options, 'urlPayOk', '');
        $this->urlAuthBankError = Arr::path($options, 'urlAuthBankError', '');
        $this->isTest = Arr::path($options, 'is_test', FALSE);
    }

    const WRITE_LOGS = TRUE;
    private function _writeLogs($select){
        if (!self::WRITE_LOGS){
            return FALSE;
        }

        if(is_array($select)){
            $select = Json::json_encode($select);
        }

        $select = Date::formatted_time('now').': '.$select;

        try {
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'kkb.txt', $select."\r\n" , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    /**
     * Ссылка на сайт банка
     * @return string
     */
    public function getURL()
    {
        if($this->isTest) {
            return self::URL_BANK_TEST;
        }else{
            return self::URL_BANK;
        }
    }

    /**
     * Ссылка на сайт банка оправлки получения статусы
     * @return string
     */
    private function getURLBankPayStatus()
    {
        if($this->isTest) {
            return self::URL_BANK_PAY_STATUS_TEST;
        }else{
            return self::URL_BANK_PAY_STATUS;
        }
    }

    /**
     * Ссылка на сайт банка подтверждение списания денег
     * @return string
     */
    private function getURLBankApplyPay()
    {
        if($this->isTest) {
            return self::URL_BANK_APPLY_PAY_TEST;
        }else{
            return self::URL_BANK_APPLY_PAY;
        }
    }

    /**
     * Получение статуса оплаты в банк
     * @param $billID
     * @param SitePageData $sitePageData
     * @throws HTTP_Exception_500
     */
    public function _getBankBillStatus($billID, SitePageData $sitePageData){
        require_once("kkb.utils.php");

        $kkb = new KKBSign();
        $kkb->invert();
        // Открываем публичный ключ.
        if ( !$kkb->load_private_key(APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'bank'.DIRECTORY_SEPARATOR.$this->filePrivateKey, $this->passwordPrivateKey)){
            throw new HTTP_Exception_500('FilePrivateKey not load.');
        }

        $result = $this->_getSignedStatusB64($kkb, $billID);
        $result = file_get_contents($this->getURLBankPayStatus().'?'.urlencode('<xml>'.$result.'</xml>'));
        $this->_writeLogs('STATUS:' . $result);

        $result = process_response(stripslashes($result), '',
            array('PUBLIC_KEY_FN' => APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.'bank'.DIRECTORY_SEPARATOR.$this->filePublicKey));

        return $result;
    }

    /**
     * Подтверждение оплаты в банк
     * @param $billID
     * @param $amount
     * @param $reference
     * @param $approvalCode
     * @param SitePageData $sitePageData
     * @throws HTTP_Exception_500
     */
    public function _sendBankBillPayApply($billID, $amount, $reference, $approvalCode, SitePageData $sitePageData){
        require_once("kkb.utils.php");

        $kkb = new KKBSign();
        $kkb->invert();
        // Открываем публичный ключ.
        if ( !$kkb->load_private_key(APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'bank'.DIRECTORY_SEPARATOR.$this->filePrivateKey, $this->passwordPrivateKey)){
            throw new HTTP_Exception_500('FilePrivateKey not load.');
        }

        $result = $this->_getSignedApplyPayB64($kkb, $billID, $amount, $reference, $approvalCode, $sitePageData);

        $result = file_get_contents($this->getURLBankApplyPay().'?'.urlencode('<xml>'.$result.'</xml>'));
        $this->_writeLogs('Списание:' . $result);
    }

    /**
     * Проверяем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @param SitePageData $sitePageData
     * @return bool
     * @throws HTTP_Exception_404
     */
    public function setPayBill(Model_Shop_Basic_Bill $bill, SitePageData $sitePageData)
    {
        require_once("kkb.utils.php");

        $result = process_response(stripslashes($_POST['response']), '',
            array('PUBLIC_KEY_FN' => APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.'bank'.DIRECTORY_SEPARATOR.$this->filePublicKey));

        // сохраняем ответ
        $this->_writeLogs(array('bill_id' => $bill->id, 'bank' => $result));

        $isPay = ((is_array($result)) && (!in_array("ERROR", $result)) && ($result['PAYMENT_RESPONSE_CODE'] == '00'));

        $this->_writeLogs($result['PAYMENT_RESPONSE_CODE'] . '_' . $isPay . '_' . $result['RESULTS_TIMESTAMP']);
        if (!$isPay) {
            echo 'Банк не подтвердил оплату.';
            return FALSE;
        }

        switch ($bill->tableID){
            case Model_Hotel_Shop_Bill::TABLE_ID:
                $modelPayment = new Model_Hotel_Shop_Payment();
                $modelPayment->setDBDriver($bill->getDBDriver());
                if(! Helpers_DB::getDBObject($modelPayment, Request_RequestParams::getParamInt('payment_id'),
                    $sitePageData, $bill->shopID)){
                    throw new HTTP_Exception_404('Payment not is found!');
                }
                if ($modelPayment->getIsPaid()) {
                    return TRUE;
                }

                $modelPayment->setIsPaid(TRUE);
                $modelPayment->setPaidAt(date('Y-m-d H:i:s', strtotime($result['RESULTS_TIMESTAMP'])));
                Helpers_DB::saveDBObject($modelPayment, $sitePageData);

                $bill->setPaidAmount($bill->getPaidAmount() + $modelPayment->getAmount());
                $bill->setLimitTime(NULL);
                Helpers_DB::saveDBObject($bill, $sitePageData);

                $modelClient = new Model_Hotel_Shop_Client();
                $modelClient->setDBDriver($bill->getDBDriver());
                if(Helpers_DB::getDBObject($modelClient, $bill->getShopClientID(), $sitePageData, $bill->shopID)){
                    $modelClient->setAmount($modelClient->getAmount() + $modelPayment->getAmount());
                    Helpers_DB::saveDBObject($modelClient, $sitePageData);
                }

                $this->_writeLogs($bill->getValues());

                $this->_sendBankBillPayApply($modelPayment->id, $modelPayment->getAmount(), $result['PAYMENT_REFERENCE'],
                        $result['PAYMENT_APPROVAL_CODE'], $sitePageData);

                $status = $this->_getBankBillStatus($modelPayment->id, $sitePageData);
                $modelPayment->addOptionsArray(
                    array(
                        'bank' => $status,
                    )
                );
                $modelPayment->setName(Arr::path($status, 'RESPONSE_PAYERNAME', ''));
                Helpers_DB::saveDBObject($modelPayment, $sitePageData);
                echo 0;
                break;
            default:
                $bill->setIsPaid(TRUE);
                $bill->setPaidAt(date('Y-m-d H:i:s', strtotime($result['RESULTS_TIMESTAMP'])));
                $bill->setPaidTypeID(self::BANK_PAY_TYPE_ID);

                $this->_writeLogs($bill->getValues());
                $bill->dbSave(0, 0, $bill->shopID);

                $this->_sendBankBillPayApply($bill->id, $bill->getAmount(), $result['PAYMENT_REFERENCE'],
                    $result['PAYMENT_APPROVAL_CODE'], $sitePageData);
                echo 0;
        }
        return $isPay;
    }

    /**
     * Получаем HTML-код для страницы, чтобы сделать оплату
     * @param Model_Shop_Basic_Bill $bill
     * @param array $billItems типа Model_Shop_Bill_Item
     * @param SitePageData $sitePageData
     */
    public function getHMTLCode(Model_Shop_Basic_Bill $bill, array $billItems, SitePageData $sitePageData){
        $result = '';

        require_once("kkb.utils.php");

        $kkb = new KKBSign();
        $kkb->invert();
        // Открываем публичный ключ.
        if ( !$kkb->load_private_key(APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'bank'.DIRECTORY_SEPARATOR.$this->filePrivateKey, $this->passwordPrivateKey)){
            throw new HTTP_Exception_500('FilePrivateKey not load.');
        }

        // Поле Signed_Order_B64
        $result = $result . $this->_getSignedOrderB64($kkb, $bill, $sitePageData);

        // Поле ShopID
        if(!empty($this->urlPayOk)) {
            $result = $result . '<input hidden="hidden" name="ShopID" value="' . $this->shopID . '">';
        }

        // Поле BackLink успешная оплата
        if(!empty($this->urlPayOk)) {
            $url = str_replace('#shop_id#', $this->shopID,
                str_replace('#table_id#', $this->tableID,
                    str_replace('#bill_id#', $bill->id,
                        $sitePageData->urlBasic.$this->urlPayOk
                    )
                )
            );
            $result = $result . '<input hidden="hidden" name="BackLink" value="' . htmlspecialchars($url) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="BackLink" value="#URL_PAY_OK#">';
        }

        // Поле FailureBackLink неуспешная авторизация
        if(!empty($this->urlAuthBankError)) {
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="' . htmlspecialchars($sitePageData->urlBasic.$this->urlAuthBankError) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="#URL_AUTH_BANK_ERROR#">';
        }

        // Поле PostLink возвращает результат на сайт
        $url = str_replace('#shop_id#', $this->shopID,
            str_replace('#table_id#', $this->tableID, $sitePageData->urlBasic.$this->urlBillPay.$bill->id)
        );
        $result = $result . '<input hidden="hidden" name="PostLink" value="'.htmlspecialchars($url).'">';

        // Поле Language возвращает результат на сайт
        $result = $result . $this->_getLanguage($sitePageData);

        // Поле appendix массив товаров
        $result = $result . $this->_getAppendix($kkb, $billItems, $sitePageData);

        return $result;
    }

    /**
     * Получаем HTML-код для страницы, чтобы сделать оплату отеля
     * @param $shopPaidTypeID
     * @param Model_Hotel_Shop_Bill $bill
     * @param array $billItems
     * @param SitePageData $sitePageData
     * @return string
     * @throws HTTP_Exception_500
     */
    public function getHMTLCodeHotel($shopPaidTypeID, Model_Hotel_Shop_Bill $bill, array $billItems, SitePageData $sitePageData){
        $result = '';

        require_once("kkb.utils.php");

        $kkb = new KKBSign();
        $kkb->invert();
        // Открываем публичный ключ.
        if ( !$kkb->load_private_key(APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'bank'.DIRECTORY_SEPARATOR.$this->filePrivateKey, $this->passwordPrivateKey)){
            throw new HTTP_Exception_500('FilePrivateKey not load.');
        }

        $this->tableID = $bill->tableID;

        $payment = new Model_Hotel_Shop_Payment();
        $payment->setDBDriver($bill->getDBDriver());
        $payment->setShopBillID($bill->id);
        $payment->setShopClientID($bill->getShopClientID());
        $payment->setShopPaidTypeID($shopPaidTypeID);
        $payment->setAmount(Request_RequestParams::getParamFloat('amount'));
        if (($payment->getAmount() < 1) || ($payment->getAmount() > $bill->getAmount() - $bill->getPaidAmount())){
            $payment->setAmount($bill->getAmount() - $bill->getPaidAmount());
        }
        Helpers_DB::saveDBObject($payment, $sitePageData);

        // Поле Signed_Order_B64
        $result = $result . $this->_getSignedOrderB64($kkb, $payment, $sitePageData);

        // Поле ShopID
        if(!empty($this->urlPayOk)) {
            $result = $result . '<input hidden="hidden" name="ShopID" value="' . $this->shopID . '">';
        }

        // Поле BackLink успешная оплата
        if(!empty($this->urlPayOk)) {
            $url = str_replace('#shop_id#', $this->shopID,
                str_replace('#table_id#', $this->tableID,
                    str_replace('#bill_id#', $bill->id,
                        $sitePageData->urlBasic.$this->urlPayOk
                    )
                )
            );
            $result = $result . '<input hidden="hidden" name="BackLink" value="' . htmlspecialchars($url) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="BackLink" value="#URL_PAY_OK#">';
        }

        // Поле FailureBackLink неуспешная авторизация
        if(!empty($this->urlAuthBankError)) {
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="' .
                htmlspecialchars(str_replace('#amount#', $payment->getAmount(), str_replace('#bill_id#', $bill->id, $sitePageData->urlBasic.$this->urlAuthBankError))) . '">';
        }else{
            $result = $result . '<input hidden="hidden" name="FailureBackLink" value="#URL_AUTH_BANK_ERROR#">';
        }

        // Поле PostLink возвращает результат на сайт
        $url = str_replace('#shop_id#', $this->shopID,
            str_replace('#table_id#', $this->tableID, $sitePageData->urlBasic.$this->urlBillPay.$bill->id.'&payment_id='.$payment->id)
        );
        $result = $result . '<input hidden="hidden" name="PostLink" value="'.htmlspecialchars($url).'">';

        // Поле Language возвращает результат на сайт
        $result = $result . $this->_getLanguage($sitePageData);

        // Поле appendix массив товаров
        $result = $result . $this->_getAppendix($kkb, $billItems, $sitePageData);

        return $result;
    }

    private function _getAppendix(KKBSign $kkb, array $billItems, SitePageData $sitePageData){
        $result = '<document>';
        $i = 1;
        foreach($billItems as $billItem){
            $result = $result . '<item number="'.$i.'" name="'.Func::xmlrpc_encode($billItem->getElement('shop_good')->getName()).'" quantity="'.$billItem->getCountElement().'" amount="'.Func::getPrice($sitePageData->currency, $billItem->getAmount()).'"/>';
            $i++;
        }
        $result = $result. '</document>';

        $result = '<input hidden="hidden" name="appendix" value="'.htmlspecialchars(base64_encode($result)).'">';
        return $result;
    }

    /**
     * Язык интерфейса банка
     * @param SitePageData $sitePageData
     * @return string
     */
    private function _getLanguage(SitePageData $sitePageData)
    {
        // курса валют банка
        switch ($sitePageData->languageID) {
            case Model_Language::LANGUAGE_RUSSIAN:
                $language = 'rus';
                break;
            case Model_Language::LANGUAGE_KAZAKH:
                $language = 'rus';
                break;
            default:
                $language = 'eng';
        }

        $result = '<input hidden="hidden" name="Language" value="'.$language.'">';

        return $result;
    }

    /**
     * @param KKBSign $kkb
     * @param Model_Shop_Basic_Bill | Model_Hotel_Shop_Payment $bill
     * @param SitePageData $sitePageData
     * @return mixed|string
     */
    private function _getSignedOrderB64(KKBSign $kkb, $bill, SitePageData $sitePageData){
        // курса валют банка
        switch($sitePageData->currencyID){
            case Model_Currency::USD:
                $currency = 840;
                break;
            default:
                $currency = 398;
        }

        $result = self::MERCHANT_BANK;
        $result = preg_replace('/\%certificate\%/', $this->merchantCerID, $result);
        $result = preg_replace('/\%merchant_name\%/', $this->shopName, $result);
        $result = preg_replace('/\%order_id\%/', $bill->id, $result);
        $result = preg_replace('/\%currency\%/', $currency, $result);
        $result = preg_replace('/\%merchant_id\%/', $this->merchantID, $result);
        $result = preg_replace('/\%amount\%/', $bill->getAmount(), $result);

        $tmp = '<merchant_sign type="RSA">'.$kkb->sign64($result).'</merchant_sign>';
        $result = '<document>'.$result.$tmp.'</document>';

        $result = '<input hidden="hidden" name="Signed_Order_B64" value="'.base64_encode($result).'">';

        return $result;
    }

    /**
     * Получаем поле Signed_Order_B64
     * @param KKBSign $kkb
     * @param $billID
     * @param $amount
     * @param $reference
     * @param $approvalCode
     * @param SitePageData $sitePageData
     * @return mixed|string
     */
    private function _getSignedApplyPayB64(KKBSign $kkb, $billID, $amount, $reference, $approvalCode, SitePageData $sitePageData){
        // курса валют банка
        switch($sitePageData->currencyID){
            case Model_Currency::USD:
                $currency = 840;
                break;
            default:
                $currency = 398;
        }

        $result = self::MERCHANT_APPLY_PAY_BANK;
        $result = preg_replace('/\%order_id\%/', $billID, $result);
        $result = preg_replace('/\%currency\%/', $currency, $result);
        $result = preg_replace('/\%order_id\%/', $billID, $result);
        $result = preg_replace('/\%merchant_id\%/', $this->merchantID, $result);
        $result = preg_replace('/\%reference\%/', $reference, $result);
        $result = preg_replace('/\%approval_code\%/', $approvalCode, $result);
        $result = preg_replace('/\%amount\%/', $amount, $result);

        $tmp = '<merchant_sign type="RSA">'.$kkb->sign64($result).'</merchant_sign>';
        $result = '<document>'.$result.$tmp.'</document>';

        return $result;
    }

    /**
     * Получаем поле Signed_Order_B64
     * @param KKBSign $kkb
     * @param $billID
     * @return mixed|string
     */
    private function _getSignedStatusB64(KKBSign $kkb, $billID){

        $result = self::MERCHANT_STATUS_PAY_BANK;
        $result = preg_replace('/\%order_id\%/', $billID, $result);
        $result = preg_replace('/\%merchant_id\%/', 		$this->merchantID, 		$result);

        $tmp = '<merchant_sign type="RSA">'.$kkb->sign64($result).'</merchant_sign>';
        $result = '<document>'.$result.$tmp.'</document>';

        return $result;
    }


}