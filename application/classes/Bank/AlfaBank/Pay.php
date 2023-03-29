<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ДАННЫЕ ДЛЯ ПОДКЛЮЧЕНИЯ К ПЛАТЕЖНОМУ ШЛЮЗУ
 *
 * USERNAME         Логин магазина, полученный при подключении.
 * PASSWORD         Пароль магазина, полученный при подключении.
 * WSDL             Адрес описания веб-сервиса.
 * RETURN_URL       Адрес, на который надо перенаправить пользователя
 *                  в случае успешной оплаты.
 */
class Bank_AlfaBank_Pay
{
    const URL_BANK = 'https://web.rbsuat.com/ab/rest/register.do'; // сюда посылаются данные для оплаты в банке
    const URL_BANK_TEST = 'https://web.rbsuat.com/ab/rest/register.do'; // сюда посылаются данные для оплаты в банке для тестирования

    const BANK_NAME = 'alfabank'; // внутреннее обозначение банка
    const BANK_PAY_TYPE_ID = 905; // id оплата банком
    const BANK_TITLE = 'АО "Альфа банк"';

    // пользователь в банке
    public $userName = '';

    // пароль пользователя в банке
    public $password = '';

    // системные ссылки
    public $urlPayOk = ''; // ссылка показывающая клиенту при успешной оплате
    public $urlAuthBankError = ''; // ссылка показывающая клиенту при авторизации сайта в банке с ошибкой
    public $urlBillPay = '/bank/pay?shop_id=#shop_id#&table_id=#table_id#&bank='.self::BANK_NAME.'&bill_id='; // ссылка принимающая статус оплаты с банка

    public $billTitle = ''; // заголовок заказа

    // интерфейс клиента
    private $language = Model_Language::LANGUAGE_RUSSIAN; // язык интерфейса банка rus/eng
    private $currency = Model_Currency::KZT; // курс валюты

    /**
     * Настройки для работы с банком
     * @param array $options
     */
    public function __construct(array $options){
        $this->userName = Arr::path($options, 'userName', '');
        $this->password = Arr::path($options, 'terminalID', '');
        $this->urlPayOk = Arr::path($options, 'urlPayOk', '');
        $this->urlAuthBankError = Arr::path($options, 'urlAuthBankError', '');
        $this->billTitle = Arr::path($options, 'bill_title', '');
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
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'alfabank.txt', str_replace("\r\n", ' ', $select."\r\n") , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    /**
     * Оправляем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @throws HTTP_Exception_500
     */
    public function inBank(Model_Shop_Basic_Bill $bill, SitePageData $sitePageData){
        $url = str_replace('#shop_id#', $this->shopID,
            str_replace('#table_id#', $this->tableID, $sitePageData->urlBasic.$this->urlBillPay.$bill->id)
        );

        $data = array(
            'userName' => $this->userName,
            'password' => $this->password,
            'orderNumber' => urlencode($bill->id),
            'amount' => urlencode($bill->getAmount()),
            'returnUrl' => $url,
        );

        /**
         * ЗАПРОС РЕГИСТРАЦИИ ОДНОСТАДИЙНОГО ПЛАТЕЖА В ПЛАТЕЖНОМ ШЛЮЗЕ
         *      register.do
         *
         * ПАРАМЕТРЫ
         *      userName        Логин магазина.
         *      password        Пароль магазина.
         *      orderNumber     Уникальный идентификатор заказа в магазине.
         *      amount          Сумма заказа в копейках.
         *      returnUrl       Адрес, на который надо перенаправить пользователя в случае успешной оплаты.
         *
         * ОТВЕТ
         *      В случае ошибки:
         *          errorCode       Код ошибки. Список возможных значений приведен в таблице ниже.
         *          errorMessage    Описание ошибки.
         *
         *      В случае успешной регистрации:
         *          orderId         Номер заказа в платежной системе. Уникален в пределах системы.
         *          formUrl         URL платежной формы, на который надо перенаправить браузер клиента.
         *
         *  Код ошибки      Описание
         *      0           Обработка запроса прошла без системных ошибок.
         *      1           Заказ с таким номером уже зарегистрирован в системе.
         *      3           Неизвестная (запрещенная) валюта.
         *      4           Отсутствует обязательный параметр запроса.
         *      5           Ошибка значения параметра запроса.
         *      7           Системная ошибка.
         */
        $response = $this->gateway('register.do', $data);

        print_r($response); die;
        if (isset($response['errorCode'])) { // В случае ошибки вывести ее
            throw new HTTP_Exception_500('Ошибка #' . $response['errorCode'] . ': ' . $response['errorMessage']);
        } else { // В случае успеха перенаправить пользователя на платежную форму
            header('Location: ' . $response['formUrl']);
            die();
        }
    }

    /**
     * Проверяем оплату через банк
     * @param Model_Shop_Basic_Bill $bill
     * @return bool
     */
    public function setPayBill(Model_Shop_Basic_Bill $bill)
    {
        if ($bill->getIsPaid()){
            return TRUE;
        }

        $this->_writeLogs(print_r($_GET, TRUE) . print_r($_SERVER, TRUE));

        if (!($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['orderId']))){
            return FALSE;
        }

        $data = array(
            'userName' => $this->userName,
            'password' => $this->password,
            'orderId' => $_GET['orderId']
        );

        /**
         * ЗАПРОС СОСТОЯНИЯ ЗАКАЗА
         *      getOrderStatus.do
         *
         * ПАРАМЕТРЫ
         *      userName        Логин магазина.
         *      password        Пароль магазина.
         *      orderId         Номер заказа в платежной системе. Уникален в пределах системы.
         *
         * ОТВЕТ
         *      ErrorCode       Код ошибки. Список возможных значений приведен в таблице ниже.
         *      OrderStatus     По значению этого параметра определяется состояние заказа в платежной системе.
         *                      Список возможных значений приведен в таблице ниже. Отсутствует, если заказ не был найден.
         *
         *  Код ошибки      Описание
         *      0           Обработка запроса прошла без системных ошибок.
         *      2           Заказ отклонен по причине ошибки в реквизитах платежа.
         *      5           Доступ запрещён;
         *                  Пользователь должен сменить свой пароль;
         *                  Номер заказа не указан.
         *      6           Неизвестный номер заказа.
         *      7           Системная ошибка.
         *
         *  Статус заказа   Описание
         *      0           Заказ зарегистрирован, но не оплачен.
         *      1           Предавторизованная сумма захолдирована (для двухстадийных платежей).
         *      2           Проведена полная авторизация суммы заказа.
         *      3           Авторизация отменена.
         *      4           По транзакции была проведена операция возврата.
         *      5           Инициирована авторизация через ACS банка-эмитента.
         *      6           Авторизация отклонена.
         */
        $response = $this->gateway('getOrderStatus.do', $data);

        $isPay = $response['ErrorCode'] == 0
            && $response['OrderStatus'] == 2;

        if ($isPay) {
            $bill->setIsPaid(TRUE);
            $bill->setPaidAt(date('Y-m-d H:i:s'));
            $bill->setPaidTypeID(self::BANK_PAY_TYPE_ID);

            $this->_writeLogs($bill->getValues());
            $bill->dbSave(0, 0, $bill->shopID);
        }

        return $isPay;
    }


    private function gateway($method, $data) {
        $curl = curl_init(); // Инициализируем запрос
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::URL_BANK.$method, // Полный адрес метода
            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            CURLOPT_POST => true, // Метод POST
            CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));
        $response = curl_exec($curl); // Выполняем запрос

        $response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение
        return $response; // Возвращаем ответ
    }
}