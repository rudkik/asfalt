<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_CashRegister_Aura3 {

    // виды операция
    const OPERATION_BUY = 0;         // Покупка
    const OPERATION_BUY_RETURN = 1;  // Возврат покупки
    const OPERATION_SELL = 2;        //Продажа
    const OPERATION_SELL_RETURN = 3; // Возврат продажи

    // вид оплат
    const PAYMENT_CASH = 0; // Наличные
    const PAYMENT_CARD = 1; // Банковская карта
    const PAYMENT_CREDIT = 2; // Оплата в кредит
    const PAYMENT_TARE = 3; // Оплата тарой

    // виды отчетов
    const REPORT_Z = 0; // Z-отчет (также закрывает текущую смену)
    const REPORT_X = 1; // X-отчет (отчет по текущей смене)
    const REPORT_CASHIER = 2; // Отчет по кассирам
    const REPORT_SECTION = 3; // Отчет по секциям
    const REPORT_CHECK_SHORT = 4; // Контрольная лента сокращенная (только итоги чеков)
    const REPORT_CHECK_FULL = 5; // Контрольная лента полная (полная копия чеков)

    // тип операции
    const MONEY_PLACEMENT_DEPOSIT = 0; // Внесение денег в кассу
    const MONEY_PLACEMENT_WITHDRAWAL = 1; // Снятие денег из кассы

    // тип документа для повтора печати
    const REPEAT_PRINT_FISCAL_CHECK = 0; // Фискальный чек
    const REPEAT_PRINT_REPORT = 1; // Z-отчёт.

    /**
     * IP подключения к кассовому аппарату
     * @var string
     */
    private $_ip = '192.168.7.1';

    /**
     * Порт подключения к касовому аппарату
     * @var int
     */
    private $_port = 6000;

    /**
     * Логин
     * @var string
     */
    //private $_login = 'Admin';
    private $_login = 'Oper';

    /**
     * Пароль
     * @var string
     */
    //private $_password = 'root';
    private $_password = '123456';

    /**
     * Тестовый режим
     * @var bool
     */
    private $_isTest = TRUE;

    const WRITE_LOGS = TRUE;

    /**
     * Сохранение в лог
     * @param $select
     * @param $isRequest
     * @return bool
     */
    private function _writeLogs($select, $isRequest){
        if (!self::WRITE_LOGS){
            return FALSE;
        }

        if($isRequest){
            $prefix = 'Команда';
        }else{
            $prefix = 'Результа';
        }
        $select = $prefix.':'."\t". Date::formatted_time('now').':'."\t".str_replace("\r\n", ' ', $select);

        try {
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'aura3.txt', $select."\r\n" , FILE_APPEND);
        } catch (Exception $e) {
        }

        return TRUE;
    }

    /**
     * Загрузка настроек
     * @param $login
     * @param $password
     * @param $ip
     * @param $port
     */
    public function loadOptions($login, $password, $ip, $port){
        $this->_login = $login;
        $this->_password = $password;
        $this->_ip = $ip;
        $this->_port = $port;
    }

    /**
     * Проверка связи с ОФД
     * Запрос:
        <?xml version="1.0" encoding="utf-8"?>
        <TestConnection>
            <User>Admin</User>
            <Password>root</Password>
        </ TestConnection >

     * Ответ:
        <?xml version="1.0" encoding="UTF-8"?>
        <TestConnection>
            <Errorcode>0</Errorcode>
            <TestInternet>OK</TestInternet>
            <TestOFDServer>OK</TestOFDServer>
        </TestConnection>
     * @return bool
     */
    public function testConnection(){
        $body = '';
        return $this->_runCommand('TestConnection', $body, 'TestOFDServer') == 'OK';
    }

    /**
     * Печать последнего чека
     * Запрос:
        <?xml version="1.0" encoding="utf-8"?>
        <Repeat>
            <User>Admin</User>
            <Password>root</Password>
            <Type> FiscalCheck </ Type >
            <Perifery>
                <Cut>true</Cut>
            </Perifery>
        </Repeat>
     * @param int $documentType
     * @return bool
     */
    public function repeatPrint($documentType = self::REPEAT_PRINT_FISCAL_CHECK){
        $body = '<Type>'.$documentType.'</Type>';
        return $this->_runCommand('Repeat', $body);
    }

    /**
     * Внесение и выплата денег
     * Запрос:
        <?xml version="1.0" encoding="utf-8"?>
        <CashInOut>
            <User>Admin</User>
            <Password>root</Password>
            <Operation>MONEY_PLACEMENT_DEPOSIT</Operation>
            <Sum>
                <Bills>2000</Bills>
                <Coins>0</Coins>
            </Sum>
        </CashInOut>
     * Ответ:
        <?xml version="1.0" encoding="utf-8"?>
        <CashInOut>
            <Errorcode>0</Errorcode>
            <Online>1</Online>
        </CashInOut>
     * @param float $amount
     * @param int $operationType
     * @return bool
     */
    public function cashInOut($amount, $operationType = self::MONEY_PLACEMENT_WITHDRAWAL){
        $body = '<Operation>'.$operationType.'</Operation>'
                . '<Sum>'.Drivers_CashRegister_Aura3_Convert::moneyToXML($amount).'</Sum>';
        return $this->_runCommand('CashInOut', $body);
    }

    /**
     * Печать чека
     * Возвращает уникальный номер чека сгенерированный на ОФД или ККМ
     * Запрос
        <?xml version="1.0" encoding="utf-8"?>
        <FiscalCheck>
            <User>Admin</User>
            <Password>root</Password>
            <Operation>OPERATION_SELL</Operation>
            <ClisheStrings>
                <String>Магазин №4</String>
                <String>ул. такая-то, д.5</String>
            </ClisheStrings>
            <Commodity>
                <Item>
                    <Name>Онлайн ККМ Аура3</Name>
                    <Quantity>1000</Quantity>
                    <Price>
                        <Bills>125000</Bills>
                        <Coins>0</Coins>
                    </Price>
                    <DiscountPercent>10000</DiscountPercent>
                    <Section>1</Section>
                    <Taxes>
                        <Tax>
                            <Vat>12000</Vat>
                            <Vatname>НДС</Vatname>
                            <Vatinprice>true</Vatinprice>
                        </Tax>
                    </Taxes>
                </Item>
            </Commodity>
            <Document>
                <Strings>
                    <String>Товар возврату и обмену</String>
                    <String>Не подлежит</String>
                </Strings>
            </Document>
            <Payments>
                <Payment>
                    <Paymenttype>PAYMENT_CASH</Paymenttype>
                    <Sum>
                        <Bills>200000</Bills>
                        <Coins>0</Coins>
                    </Sum>
                </Payment>
            </Payments>
            <VaultStrings>
                <String>Спасибо за покупку!!!</String>
                <String>Всего хорошего!!!</String>
            </VaultStrings>
            <Perifery>
                <Cut>true</Cut>
            </Perifery>
        </FiscalCheck>
     * Ответ
        <?xml version="1.0" encoding="utf-8"?>
        <FiscalCheck>
            <Errorcode>0</Errorcode>
            <Online>1</Online>
            <CheckNumber>235932944</CheckNumber>
        </FiscalCheck>
     * @param float $paymentAmount
     * @param Drivers_CashRegister_Aura3_GoodsList $goodsList - список товаров
     * @param array $clisheStrings - Печатаются дополнительные строки в клише сразу после строк из настроек ККМ и строк с сервера ОФД.
     * @param array $vaultStrings - Печатает дополнительные строки в подвале чека сразу после строк из настроек ККМ и строк с сервера ОФД
     * @param array $document - Информация о товарах или услугах, представленная текстовыми строками.
     * @param int $paymentType
     * @param int $operationType
     * @return string
     */
    public function fiscalCheck($paymentAmount, Drivers_CashRegister_Aura3_GoodsList $goodsList,
                                $paymentType = self::PAYMENT_CASH, $operationType = self::OPERATION_SELL,
                                array $clisheStrings = array(), array $vaultStrings = array(), array $document = array()){
        // Код операции с чеком
        $body = '<Operation>'.$operationType.'</Operation>';

        // Печатаются дополнительные строки в клише сразу после строк из настроек ККМ и строк с сервера ОФД.
        if(!empty($clisheStrings)){
            $body .= '<ClisheStrings>'.Drivers_CashRegister_Aura3_Convert::arrayToXML($clisheStrings).'</ClisheStrings>';
        }

        // Список товаров или услуг
        $body .= '<Commodity>'.$goodsList->getXMLStr().'</Commodity>';

        // Список товаров или услуг текстовыми строками
        if(!empty($document)){
            $body .= '<Document>'.Drivers_CashRegister_Aura3_Convert::arrayToXML($document).'</Document>';
        }

        // Оплата по чеку (Считаем, что можно только оплатить одним типом оплаты)
        $body .= '<Payments>'.Drivers_CashRegister_Aura3_Convert::paymentTypeToXML($paymentType, $paymentAmount).'</Payments>';

        // Печатает дополнительные строки в подвале чека сразу после строк из настроек ККМ и строк с сервера ОФД
        if(!empty($vaultStrings)){
            $body .= '<VaultStrings>'.Drivers_CashRegister_Aura3_Convert::arrayToXML($vaultStrings).'</VaultStrings>';
        }

        // Возвращает уникальный номер чека сгенерированный на ОФД или ККМ
        $checkNumber = $this->_runCommand('FiscalCheck', $body, 'CheckNumber');

        return strval($checkNumber);
    }

    /**
     * Печать чека
     * @param $paymentAmount
     * @param Drivers_CashRegister_Aura3_FiscalCheck $fiscalCheck
     * @param int $paymentType
     * @param int $operationType
     * @return string
     */
    public function printFiscalCheck($paymentAmount, Drivers_CashRegister_Aura3_FiscalCheck $fiscalCheck,
                                $paymentType = self::PAYMENT_CASH, $operationType = self::OPERATION_SELL){
        return $this->fiscalCheck(
            $paymentAmount,
            $fiscalCheck->getGoodsList(),
            $paymentType, $operationType,
            $fiscalCheck->getClisheStrings(),
            $fiscalCheck->getVaultStrings(),
            $fiscalCheck->getDocument()
        );
    }

    /**
     * Печать отчетов
     * Запрос
    <?xml version="1.0" encoding="utf-8"?>
    <Report>
        <User>Admin</User>
        <Password>root</Password>
        <Type>REPORT_Z</Type>
    </Report>
     * @param int $viewReport
     * @return bool
     */
    public function printReport($viewReport = self::REPORT_Z){
        $body = '<Type>'.$viewReport.'</Type>';
        return $this->_runCommand('Report', $body);
    }

    /**
     * Открытие смены
     * Запрос
     * <?xml version="1.0" encoding="utf-8"?>
       <OpenShift>
           <User>Admin</User>
           <Password>root</Password>
           <Demomode>0</Demomode>
       </OpenShift>
     * Ответ
     * <?xml version="1.0" encoding="utf-8"?>
       <OpenShift>
           <Errorcode>0</Errorcode>
           <ShiftNumber>1</ShiftNumber>
       </OpenShift>
     * @return bool
     * @throws HTTP_Exception_500
     */
    public function openShift(){
        if($this->_isTest){
            $body = '<Demomode>1</Demomode>';
        }else{
            $body = '<Demomode>0</Demomode>';
        }

        return $this->_runCommand('OpenShift', $body);
    }

    /**
     * Закрытие смены
     * Запрос:
    <?xml version="1.0" encoding="utf-8"?>
    <CloseShift>
    <User>Admin</User>
    <Password>root</Password>
    </CloseShift>
     * @return bool
     */
    public function сloseShift(){
        $body = '';
        return $this->_runCommand('CloseShift', $body);
    }

    /**
     * Закрытие смены
     * Запрос:
        <?xml version="1.0" encoding="utf-8"?>
        <Status>
            <User>Admin</User>
            <Password>root</Password>
        </Status>
     * Ответ:
        <?xml version="1.0" encoding="UTF-8"?>
        <Status>
            <Errorcode>0</Errorcode>
            <Mode>1</Mode>
            <Demomode>0</Demomode>
            <Registration>1</Registration>
            <Shiftopen>0</Shiftopen>
            <Checknumber>2</Checknumber>
            <Documentnumber>12</Documentnumber>
            <Shiftnumber>6</Shiftnumber>
            <Currentdate>
            <year>2018</year>
            <month>12</month>
            <day>12</day>
            </Currentdate>
            <Currenttime>
            <hour>19</hour>
            <minute>32</minute>
            <second>01</second>
            </Currenttime>
            <Draweropened>0</Draweropened>
            <Paperpresent>0</Paperpresent>
            <Coveropen>0</Coveropen>
        </Status>
     * @return bool
     */
    public function status(){
        $body = '';

        $data = $this->_runCommand('Status', $body, '');

        $result = array(
            'Errorcode' => intval($data->Errorcode),
            'Mode' => intval($data->Mode),
            'Demomode' => intval($data->Demomode),
            'Registration' => intval($data->Registration),
            'Shiftopen' => intval($data->Shiftopen),
            'Checknumber' => intval($data->Checknumber),
            'Documentnumber' => intval($data->Documentnumber),
            'Shiftnumber' => intval($data->Shiftnumber),
            'Currentdate' => $data->Currentdate->year . '-' . $data->Currentdate->month . '-' . $data->Currentdate->day
                . '-' . $data->Currenttime->hour . '-' . $data->Currenttime->minute . '-' . $data->Currenttime->second,
            'Draweropened' => intval($data->Draweropened),
            'Paperpresent' => intval($data->Paperpresent),
            'Papernearend' => intval($data->Papernearend),
            'Coveropen' => intval($data->Coveropen),
        );

        return $result;
    }

    /**
     * Выполнить команду
     * @param $command
     * @param $body
     * @param string $readValue
     * @return bool|SimpleXMLElement[]
     * @throws Drivers_CashRegister_Exception
     */
    private function _runCommand($command, $body, $readValue = null){
        $request = $this->_getCommand($command, $body);
        $this->_writeLogs($request, true);

        $response = $this->getDataURLEmulationBrowser($this->getURLConnect(), $request);
        $this->_writeLogs($response, false);

        try{
            $xml = simplexml_load_string($response);
        }catch (Exception $e){
            throw new Drivers_CashRegister_Exception('Response correct not command "'.$command.'"', $command);
        }

        if(empty($xml)){
            throw new Drivers_CashRegister_Exception('Empty response command "'.$command.'"', $command);
        }

        if ($xml->Errorcode > 0){
            $error = Helpers_XML::getXMLFieldValue($xml, 'Errortext');
            if(!empty($error)){
                $error = '"'.$error.'" ';
            }
            throw new Drivers_CashRegister_Exception('Command '.$command.' error '.$error.'code "'.$xml->Errorcode.'".', $command, $xml->Errorcode);
        }

        if(!empty($readValue)){
            return $xml->$readValue;
        }

        if($readValue !== null){
            return $xml;
        }

        return TRUE;
    }

    /**
     * Создаем XML документ с базовыми данными
     * @param $command
     * @param $body
     * @return string
     */
    private function _getCommand($command, $body){
        $result =
            '<?xml version="1.0" encoding="UTF-8"?>'
            .'<'.$command.'>'
            .'<User>'.$this->_login.'</User>'
            .'<Password>'.$this->_password.'</Password>'
            .$body
            .'</'.$command.'>';

        return $result;
    }

    /**
     * Ссылка для подключения к касовому аппарату
     * @return string
     */
    public function getURLConnect(){
        return 'http://'.$this->_ip.':'.$this->_port;
    }

    /**
     * Получение данных по ссылке с эмуляцией заголовков браузера
     * @param $url
     * @param $request
     * @return mixed
     */
    public function getDataURLEmulationBrowser($url, $request)
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
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_HEADER => 0,
        );
        curl_setopt($cs, CURLOPT_POSTFIELDS, $request);
        curl_setopt_array($cs, $opt);

        $result = curl_exec($cs);
        curl_close($cs);
        return $result;
    }
}