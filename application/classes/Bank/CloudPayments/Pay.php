<?php defined('SYSPATH') or die('No direct script access.');

class Bank_CloudPayments_Pay
{
    const BANK_NAME = 'cloudpayments'; // внутреннее обозначение банка
    const BANK_PAY_TYPE_ID = 906; // id оплата банком
    const BANK_TITLE = 'CloudPayments';

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

        Helpers_File::saveInLogs('cloudpayments.txt', $select);

        return TRUE;
    }

    /**
     * Проверяем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @return bool
     */
    public function setPayBill($bill)
    {
        if ($bill->getIsPaid()){
            return TRUE;
        }

        $this->_writeLogs(print_r($_GET, TRUE) . print_r($_POST, TRUE));

        // Проверка оплаты счета
        $amount = Request_RequestParams::getParamFloat('Amount');
        $isPay = $amount == $bill->getAmount()
                && Request_RequestParams::getParamStr('OperationType') == 'Payment';
        if ($isPay) {
            $bill->setIsPaid(TRUE);
            $bill->setPaidAt(Request_RequestParams::getParamDateTime('DateTime'));
            $bill->setPaidAmount($amount);

            $this->_writeLogs($bill->getValues());
            $bill->dbSave(0, 0, $bill->shopID);

            echo '{"code":0}';
        } else {
            // Ответ для сервер если произошла ошибка
            echo '{"code":1}';
        }

        return $isPay;
    }
}