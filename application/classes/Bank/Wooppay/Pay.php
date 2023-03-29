<?php defined('SYSPATH') or die('No direct script access.');

include 'Wooppay.php';
include 'Options.php';
include 'Reference.php';

class Bank_Wooppay_Pay
{
    const BANK_NAME = 'wooppay'; // внутреннее обозначение банка
    const BANK_PAY_TYPE_ID = 903; // id оплата банком
    const BANK_TITLE = 'Wooppay';

    // настройки магазина в базе банка
    public $login = ''; // логин
    public $password = ''; // пароль

    public $isTest = FALSE; // тестовый режим

    public $urlBillPay = '/bank/pay?shop_id=#shop_id#&table_id=#table_id#&bank='.self::BANK_NAME.'&bill_id='; // ссылка принимающая статус оплаты с банка
    public $urlClientPay = '/bill/pay?id=#bill_id#'; // ссылка перенаправления клиента после оплаты

    public $billTitle = ''; // заголовок заказа

    public $tableID = Model_Shop_Bill::TABLE_ID; // id таблицы заказа
    public $shopID = -1; // id магазину у которого оформлен заказ

    /**
     * заказ
     * @var null | Model_Shop_Basic_Bill
     */
    private $bill = NULL;

    /**
     * Настройки для работы с банком
     * @param array $options
     */
    public function __construct(array $options){
        $this->login = Arr::path($options, 'login', '');
        $this->password = Arr::path($options, 'password', '');
        $this->billTitle = Arr::path($options, 'bill_title', '');
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
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'wooppay.txt', str_replace("\r\n", ' ', $select."\r\n") , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    /**
     * создание оплаты на сайте Wooppay
     * @param Model_Shop_Basic_Bill $bill
     * @param SitePageData $sitePageData
     * @param string $infoBill
     */
    public function createBillOnWooppay(Model_Shop_Basic_Bill $bill, SitePageData $sitePageData, $infoBill = ''){
        $operationUrl = Arr::path($bill->getOptionsArray(), 'wooppay.operation_url', '');
        if (!empty($operationUrl)){
            return $operationUrl;
        }

        // Авторизация в платежной системе
        $wooppay =  new Wooppay();
        $options = new Options($this->login, $this->password, NULL, NULL, $this->isTest);
        $wooppay->connect($options);

        $url = str_replace('#shop_id#', $this->shopID,
            str_replace('#table_id#', $this->tableID, $this->urlBillPay.$bill->id)
        );
        if((strpos($url, 'http://') === FALSE) && (strpos($url, 'https://') === FALSE)){
            $url = $sitePageData->urlBasic . $url;
        }

        $urlClient = str_replace('#bill_id#', $bill->id, $this->urlClientPay);
        if((strpos($urlClient, 'http://') === FALSE) && (strpos($urlClient, 'https://') === FALSE)){
            $urlClient = $sitePageData->urlBasic . $urlClient;
        }

        // Выставление счета;
        $request = new CashCreateInvoiceRequest([
            'amount' => $bill->getAmount(),
            'deathDate' => date('Y-m-d H:i:s', strtotime('+30 day')),
            'description' => $infoBill,
            'addInfo' => $infoBill,
            'referenceId' => $bill->id,
            'orderNumber' => $bill->id,
            'backUrl' => $urlClient,
            'requestUrl' => $url,
        ]);

        $data = $wooppay->cash_createInvoice($request);

        if ($data->error_code == Reference::ERROR_NO_ERRORS) {
            $operationId = $data->response->operationId;
            $operationUrl = $data->response->operationUrl;
        }

        $bill->addOptionsArray(
            array(
                'wooppay' => array(
                    'operation_id' => $operationId,
                    'operation_url' => $operationUrl,
                ),
            )
        );

        $bill->dbSave();

        return $operationUrl;
    }

    /**
     * Оправляем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @param array $billItems
     * @param SitePageData $sitePageData
     * @param string $infoBill
     * @return array
     */
    public function getHMTLCode(Model_Shop_Basic_Bill $bill, array $billItems, SitePageData $sitePageData, $infoBill = ''){
        if(empty($infoBill)){
            $infoBill = $this->billTitle;
        }
        $infoBillItem = '';
        foreach ($billItems as $billItem){
            $infoBillItem = $infoBillItem . $billItem->getName() . ' - ' . $billItem->getCountElement(). ' шт.' . "\r\n";
        }
        $infoBill = trim($infoBill."\r\n".$infoBillItem);

        $data = array(
            'url_bank' => $this->createBillOnWooppay($bill, $sitePageData, $infoBill),
        );

        return $data;
    }

    /**
     * Проверяем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @return bool
     */
    public function setPayBill($bill, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($bill->getIsPaid()){
            return TRUE;
        }

        $this->_writeLogs(print_r($_GET, TRUE) . print_r($_SERVER, TRUE));

        $wooppay = new Wooppay();
        $options = new Options($this->login, $this->password, NULL, NULL, $this->isTest);
        $wooppay->connect($options);

        $operationId = Arr::path($bill->getOptionsArray(), 'wooppay.operation_id', 0);

        // Проверка оплаты счета
        $isPay = $wooppay->isPaid($operationId);
        if ($isPay) {
            $bill->setIsPaid(TRUE);
            $bill->setPaidAt(date('Y-m-d H:i:s'));
            $bill->setPaidTypeID(self::BANK_PAY_TYPE_ID);

            $this->_writeLogs($bill->getValues());
            $bill->dbSave(0, 0, $bill->shopID);

            if ($bill->tableID == Model_Tax_Shop_Bill::TABLE_ID) {
                // если заказ оплачен, то добавляем приход денег
                Api_Tax_Shop_Payment_Book::addPaymentBill($bill, $sitePageData, $driver);
            }

            // Ответ для сервер wooppay об успешном проведении операции
            Wooppay::response(true);
        } else {
            // Ответ для сервер wooppay если произошла ошибка
            Wooppay::response(false);
        }

        return $isPay;
    }
}