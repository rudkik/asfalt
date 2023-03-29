<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Contract  {

    /**
     * Просчет количество допсоглашений договора
     * @param $shopClientContractID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveContract
     * @return int|MyArray|null
     * @throws HTTP_Exception_500
     */
    public static function calcCountAdditionalAgreement($shopClientContractID, SitePageData $sitePageData,
                                                        Model_Driver_DBBasicDriver $driver, $isSaveContract = true)
    {
        $shopClientContractID = intval($shopClientContractID);
        if($shopClientContractID < 1) {
            return 0;
        }

        $count = Request_Request::findOne(
            DB_Ab1_Shop_Client_Contract::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'basic_shop_client_contract_id' => $shopClientContractID,
                    'count_id' => true
                ]
            )
        );
        if($count != null){
            $count = $count->values['count'];
        }

        if($isSaveContract){
            $model = new Model_Ab1_Shop_Client_Contract();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopClientContractID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client contract id="' . $shopClientContractID . '" not found. #2901201612');
            }

            $model->setOperationUpdatedAt(Helpers_DateTime::getCurrentDateTimePHP());
            $model->setAdditionalAgreementCount($count);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return $count;
    }

    /**
     * Просчет суммы договора с доп. соглашениями, которые увеличивают сумму договора
     * @param $shopClientContractID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isAddBasicContract
     * @param bool $isSaveAmount
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function calcAmount($shopClientContractID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $isAddBasicContract = true, $isSaveAmount = false)
    {
        $amount = 0;
        $quantity = 0;

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $shopClientContractID,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Client_Contract_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
            $quantity += $ids->childs[0]->values['quantity'];
        }

        if($isAddBasicContract) {
            $params = Request_RequestParams::setParams(
                array(
                    'basic_shop_client_contract_id' => $shopClientContractID,
                    'is_add_basic_contract' => true,
                    'sum_amount' => TRUE,
                    'sum_quantity' => TRUE,
                )
            );
            // реализация
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Client_Contract_Item',
                array(), $sitePageData, $driver, $params
            );
            if (count($ids->childs) > 0) {
                $amount += $ids->childs[0]->values['amount'];
                $quantity += $ids->childs[0]->values['quantity'];
            }
        }

        if($isSaveAmount) {
            $model = new Model_Ab1_Shop_Client_Contract();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopClientContractID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client contract id="' . $shopClientContractID . '" not found. #2901201612');
            }
            $model->setAmount($amount);
            $model->setQuantity($quantity);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return array(
            'amount' => $amount,
            'quantity' => $quantity,
        );
    }

    /**
     * Просчет баланса договора
     * @param int $shopClientContractID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string | null $dateTo
     * @return bool|int
     * @throws HTTP_Exception_500
            */
    public static function calcBalance($shopClientContractID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $dateTo = null)
    {
        $shopClientContractID = intval($shopClientContractID);
        if($shopClientContractID < 1) {
            return FALSE;
        }

        $model = new Model_Ab1_Shop_Client_Contract();
        $model->setDBDriver($driver);
        if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientContractID, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Client contract id="' . $shopClientContractID . '" not found. #2901201612');
        }

        $block = self::calcBalanceBlock($shopClientContractID, $sitePageData, $driver, false, $dateTo);

        return $model->getAmount() - $block;
    }

    /**
     * Просчет заблокированного баланса договора
     * @param int $shopClientContractID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveAmount
     * @param string | null $dateTo
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcBalanceBlock($shopClientContractID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                            $isSaveAmount = TRUE, $dateTo = null)
    {
        $shopClientContractID = intval($shopClientContractID);
        if($shopClientContractID < 1) {
            return FALSE;
        }

        if($dateTo == null) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_contract_id' => $shopClientContractID,
                    'is_fixed_price' => true,
                )
            );
            // список продукции договора
            $contractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
                $sitePageData->shopMainID, $sitePageData, $driver, $params
            );

            /** Пересчитываем остатки для продукций договора **/
            Api_Ab1_Shop_Client_Contract_Item::calcBalancesBlock(
                $contractItemIDs->getChildArrayID(), $sitePageData, $driver
            );
        }

        /** Пересчитываем остатки для договора **/
        $amount = 0;
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $shopClientContractID,
                'sum_amount' => TRUE,
            )
        );
        // реализация
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // штучный товар
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        // дополнительные услуги
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Addition_Service_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amount += $ids->childs[0]->values['amount'];
        }

        /** Доставка **/
        $amountDelivery = 0;
        $params = Request_RequestParams::setParams(
            array(
                'delivery_shop_client_contract_id' => $shopClientContractID,
                'sum_delivery_amount' => TRUE,
            )
        );

        // реализация доставка
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountDelivery += $ids->childs[0]->values['delivery_amount'];
        }

        // штучный товар доставка
        $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $amountDelivery += $ids->childs[0]->values['delivery_amount'];
        }

        if($isSaveAmount && $dateTo == null) {
            $model = new Model_Ab1_Shop_Client_Contract();
            $model->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($model, $shopClientContractID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client contract id="' . $shopClientContractID . '" not found. #2901201612');
            }
            $model->setBlockAmount($amount + $amountDelivery);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return $amount;
    }

    /**
     *  Просчет заблокированного баланса доверенностей
     * @param array $shopClientContractIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcBalancesBlock(array $shopClientContractIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        foreach ($shopClientContractIDs as $child){
            self::calcBalanceBlock(floatval($child), $sitePageData, $driver);
        }
    }

    /**
     * Сохранение в Word
     * http://oto.flo/sbyt/shopclientcontract/save_word?id=1305457&file=agreement_1&is_not_replace=1
     * @param $shopClientContractID
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isNotReplace
     * @throws HTTP_Exception_404
     */
    public static function saveInWord($shopClientContractID, $fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $isNotReplace = false)
    {
        /*echo Json::json_encode(
            array(
                'contract' => array(
                    0 => array(
                        'title' => 'Печать договора',
                        'file' => 'contract',
                        'bottom' => 'Печать договора',
                        'contract_template_params' => array(
                            'branch_address' =>
                                array(
                                    'title' => 'Поставщика, находящейся по адресу',
                                    'values' => array('г.Алматы, ул.Серикова 20А', 'Алматинкая область, Енбекшиказахский район, с.Байтерек, улица Заводская, дом 14, Филиал  АБиКМ'),
                                ),
                            'goods' =>
                                array(
                                    'title' => 'Обязуется направлять ежемесячную заявку потребности в',
                                    'values' => array('асфальтобетонных смесях', 'дорожных нефтебитумах', 'асфальтобетонных смесях или дорожных нефтебитумах'),
                                ),
                            'contract_clause_4_2' =>
                                array(
                                    'title' => 'Пункт 4.2',
                                    'values' => array('Отгрузка товара по настоящему Договору предусматривает оплату за товар Покупателем путем 100 %-ого предварительного платежа на счет Продавца в срок не позднее 25 числа предшествующего к отгрузке месяца. При этом отгрузка продукции производится в пределах размера денежных средств Покупателя находящихся на расчетном счете Поставщика, вне зависимости от заявленного месячного объема согласно п.2.3. Договора.', 'Отгрузка товара по настоящему Договору предусматривает оплату за товар Покупателем, путем платежа на счет Продавца, в срок не позднее 25 числа после отгрузки месяца, выборка товара осуществляется с марта по декабрь {#year#} года.'),
                                ),
                        ),
                        'contract_template_others' => array(
                            'contract.number' => 'Номер договора',
                            'contract.from_at' => 'Начала договора',
                            'contract.amount' => 'Сумма договора',
                            'client.name_1c' => 'Клиент',
                            'client.bin' => 'БИН',
                            'client.address' => 'Юридический адрес клиента',
                            'client.account' => 'Расчетный счет',
                            'client.bik' => 'БИК',
                            'client.bank' => 'Название банка',
                            'client.director' => 'Директор',
                            'client.charter' => 'Действующий на основании ',
                        ),
                    ),
                ),
                'agreement' => array(
                    0 => array(
                        'title' => 'Печать изменение цены',
                        'file' => 'agreement_1',
                        'bottom' => 'Печать',
                        'contract_template_params' => array(),
                        'contract_template_others' => array(
                            'contract_root.number' => 'Номер договора',
                            'contract_root.from_at' => 'Начала договора',
                            'contract_root.number' => 'Номер договора',

                            'contract.number' => 'Номер допсоглашения',
                            'contract.from_at' => 'Начала допсоглашения',
                            'contract.amount' => 'Сумма допсоглашения',

                            'client.name_1c' => 'Клиент',
                            'client.bin' => 'БИН',
                            'client.address' => 'Юридический адрес клиента',
                            'client.account' => 'Расчетный счет',
                            'client.bik' => 'БИК',
                            'client.bank' => 'Название банка',
                            'client.director' => 'Директор',
                            'client.charter' => 'Действующий на основании ',
                        ),
                    ),
                    1 => array(
                        'title' => 'Печать дополнения',
                        'file' => 'agreement_2',
                        'bottom' => 'Печать',
                        'contract_template_params' => array(),
                        'contract_template_others' => array(
                            'contract_root.number' => 'Номер договора',
                            'contract_root.from_at' => 'Начала договора',
                            'contract_root.number' => 'Номер договора',

                            'contract.number' => 'Номер допсоглашения',
                            'contract.from_at' => 'Начала допсоглашения',
                            'contract.amount' => 'Сумма допсоглашения',

                            'client.name_1c' => 'Клиент',
                            'client.bin' => 'БИН',
                            'client.address' => 'Юридический адрес клиента',
                            'client.account' => 'Расчетный счет',
                            'client.bik' => 'БИК',
                            'client.bank' => 'Название банка',
                            'client.director' => 'Директор',
                            'client.charter' => 'Действующий на основании ',
                        ),
                    ),
                ),
            )
        );die;*/

        $model = new Model_Ab1_Shop_Client_Contract();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopClientContractID, $sitePageData, $sitePageData->shopMainID) && !$isNotReplace){
            throw new HTTP_Exception_404('Client contract not id="' . $shopClientContractID . '" found.');
        }

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($modelClient, $model->getShopClientID(), $sitePageData, $sitePageData->shopMainID) && !$isNotReplace){
            throw new HTTP_Exception_404('Client not id="' . $model->getShopClientID() . '" found.');
        }

        $modelRoot = new Model_Ab1_Shop_Client_Contract();
        $modelRoot->setDBDriver($driver);
        if($model->getBasicShopClientContractID() > 0 && !Helpers_DB::getDBObject($modelRoot, $model->getBasicShopClientContractID(), $sitePageData, $sitePageData->shopMainID) && !$isNotReplace){
            throw new HTTP_Exception_404('Client basic contract not id="' . $model->getBasicShopClientContractID() . '" found.');
        }

        $path = Helpers_Path::getPathFile(
            APPPATH,  array('views', 'ab1', '_report', $sitePageData->dataLanguageID, '_word', 'contract')
        );

        $pathName = $path . $fileName;
        if (empty($fileName) || (!file_exists($pathName))){
            throw new HTTP_Exception_404('File not "' . $pathName . '" found.');
        }

        ob_end_clean();
        require_once APPPATH.'vendor'.DIRECTORY_SEPARATOR.'PHPWord'.DIRECTORY_SEPARATOR.'autoload.php';

        $templateObject = new \PhpOffice\PhpWord\TemplateProcessor($pathName);

        $values = array(
            'contract' => $model->getValues(true, true, $sitePageData->shopMainID),
            'client' => $modelClient->getValues(true, true, $sitePageData->shopMainID),
            'contract_root' => $modelRoot->getValues(true, true, $sitePageData->shopMainID),
            'params' => Arr::path($model->getOptionsArray(), 'contract_template_params', array()),
        );
        $values['contract']['year'] = Helpers_DateTime::getYear($model->getFromAt());
        $values['contract']['from_at_rus'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getFromAt(), true);
        $values['contract']['amount_str'] = Func::numberToStr($model->getAmount());
        $values['contract']['amount_currency_str'] = Func::numberToStr($model->getAmount(), true, $sitePageData->currency, true, true);
        $values['contract']['amount'] = Func::getNumberStr($model->getAmount(), true, 2, false);

        $values['contract_root']['year'] = Helpers_DateTime::getYear($modelRoot->getFromAt());
        $values['contract_root']['from_at_rus'] = Helpers_DateTime::getDateTimeDayMonthRus($modelRoot->getFromAt(), true);
        $values['contract_root']['amount_str'] = Func::numberToStr($modelRoot->getAmount());
        $values['contract_root']['amount_currency_str'] = Func::numberToStr($modelRoot->getAmount(), true, $sitePageData->currency, true, true);
        $values['contract_root']['amount'] = Func::getNumberStr($modelRoot->getAmount(), true, 2, false);

        $values['params'] = [];
        $params = Arr::path($model->getOptionsArray(), 'contract_template_params.' . $fileName, array());
        foreach ($params as $key => $param){
            $values['params'][$key] = $param;
        }

        if(!$isNotReplace){
            foreach ($values as $basic => $arr) {
                foreach ($arr as $key => $value) {
                    if (!is_array($value)) {
                        $templateObject->setValue('{#' . $basic . '.' . $key . '#}', $value);
                    }
                }
            }
        }

        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_client_contract_id' => $shopClientContractID,
                )
            ),
            0, true,
            array(
                'shop_product_id' => array('name', 'shop_id', 'unit'),
                'shop_product_rubric_id' => array('name'),
                'product_shop_branch_id' => array('name', 'options'),
            )
        );

        $i = 1;
        $listValues = array();
        $values = array();
        foreach ($shopClientContractItemIDs->childs as $child) {
            $values[] = array(
                't_n' => $i++,
                'table_name' => $child->getElementValue('shop_product_id', 'name', $child->getElementValue('shop_product_rubric_id')),
                'table_q' => Func::getNumberStr($child->values['quantity'], true, 3, true),
                'table_p' => Func::getNumberStr($child->values['price'], true, 2, false),
                'table_a' => Func::getNumberStr($child->values['amount'], true, 2, false),
                'table_unit' => $child->getElementValue('shop_product_id', 'unit'),
            );

            $productShopBranchID = $child->values['product_shop_branch_id'];
            if($productShopBranchID == 0){
                $productShopBranchID = $child->getElementValue('shop_product_id', 'shop_id');
            }

            if(!key_exists($productShopBranchID, $listValues)){
                $listValues[$productShopBranchID] = array(
                    'name' => $child->getElementValue('product_shop_branch_id'),
                    'address' => Arr::path(json_decode($child->getElementValue('product_shop_branch_id', 'options'), true), 'requisites.address', ''),
                    'data' => array(),
                    'amount' => 0,
                );
            }
            $listValues[$productShopBranchID]['data'][] = array(
                't_n' => count($listValues[$productShopBranchID]['data']) + 1,
                'table_name' => $child->getElementValue('shop_product_id', 'name', $child->getElementValue('shop_product_rubric_id')),
                'table_q' => Func::getNumberStr($child->values['quantity'], true, 3, true),
                'table_p' => Func::getNumberStr($child->values['price'], true, 2, false),
                'table_a' => Func::getNumberStr($child->values['amount'], true, 2, false),
                'table_unit' => $child->getElementValue('shop_product_id', 'unit'),
            );
            $listValues[$productShopBranchID]['amount'] += $child->values['amount'];
        }

        if(!$isNotReplace) {
            try {
                $templateObject->cloneRowAndSetValues('t_n', $values);
            }catch (Exception $e){}
        }

        $i = 0;
        foreach ($listValues as $shopID => $listValue){
            $i++;
            $values = array();
            foreach ($listValue['data'] as $value){
                $values[] = array(
                    't'.$i.'_n' => $value['t_n'],
                    'table'.$i.'_name' => $value['table_name'],
                    'table'.$i.'_q' => $value['table_q'],
                    'table'.$i.'_p' => $value['table_p'],
                    'table'.$i.'_a' => $value['table_a'],
                    'table'.$i.'_unit' => $value['table_unit'],
                );
            }

            if(!$isNotReplace) {
                try {
                    $templateObject->cloneRowAndSetValues('t'.$i.'_n', $values);
                }catch (Exception $e){}
            }

            if(empty($listValue['name'])){
                $modelShop = new Model_Shop();
                $modelShop->setDBDriver($driver);
                Helpers_DB::getDBObject($modelShop, $shopID, $sitePageData, 0);
                $listValue['address'] = $modelShop->getOptionsValue('requisites.address');
            }

            $templateObject->setValue('{#table'.$i.'.address#}', $listValue['address']);
            $templateObject->setValue('{#table'.$i.'.amount#}', Func::getNumberStr($listValue['amount'], true, 2, false));

            $templateObject->setValue('${table'.$i.'}', '');
            $templateObject->setValue('${/table'.$i.'}', '');
        }

        // удаляем лишние таблицы
        for ($i = count($listValues) + 1; $i < 11; $i++){
            $templateObject->deleteBlock('table'.$i);
        }

        $fileName = $templateObject->save();

        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: attachment; filename="Договор '.$modelClient->getName().'.docx"');
        header('Cache-Control: max-age=0');

        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $phpWord = $objReader->load($fileName);
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * Сохранение договора в PDF
     * @param $shopClientContractID
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isNotReplace
     * @param bool $isPHPOutput
     * @throws HTTP_Exception_404
     */
    public static function saveInPDF($shopClientContractID, $fileName,  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                     $isNotReplace = false, $isPHPOutput = true)
    {
        $model = new Model_Ab1_Shop_Client_Contract();
        $model->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($model, $shopClientContractID, $sitePageData, $sitePageData->shopMainID) && !$isNotReplace){
            throw new HTTP_Exception_404('Client contract not id="' . $shopClientContractID . '" found.');
        }

        // шаблон договора
        $contractTemplate = $model->getContractTemplatesArray($fileName);
        if(empty($contractTemplate) || ! is_array($contractTemplate)){
            throw new HTTP_Exception_404('Template contract not "' . $fileName . '" found.');
        }

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($modelClient, $model->getShopClientID(), $sitePageData, $sitePageData->shopMainID) && !$isNotReplace){
            throw new HTTP_Exception_404('Client not id="' . $model->getShopClientID() . '" found.');
        }

        $modelRoot = new Model_Ab1_Shop_Client_Contract();
        $modelRoot->setDBDriver($driver);
        if($model->getBasicShopClientContractID() > 0 && !Helpers_DB::getDBObject($modelRoot, $model->getBasicShopClientContractID(), $sitePageData, $sitePageData->shopMainID) && !$isNotReplace){
            throw new HTTP_Exception_404('Client basic contract not id="' . $model->getBasicShopClientContractID() . '" found.');
        }

        $values = array(
            'contract' => $model->getValues(true, true, $sitePageData->shopMainID),
            'client' => $modelClient->getValues(true, true, $sitePageData->shopMainID),
            'contract_root' => $modelRoot->getValues(true, true, $sitePageData->shopMainID),
            'params' => Arr::path($model->getOptionsArray(), 'contract_template_params', array()),
        );
        $values['contract']['year'] = Helpers_DateTime::getYear($model->getFromAt());
        $values['contract']['from_at_rus'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getFromAt(), true);
        $values['contract']['from_at'] = Helpers_DateTime::getDateFormatRus($model->getFromAt());
        $values['contract']['amount_str'] = Func::numberToStr($model->getAmount());
        $values['contract']['amount_currency_str'] = Func::numberToStr($model->getAmount(), true, $sitePageData->currency, true, true);
        $values['contract']['amount'] = Func::getNumberStr($model->getAmount(), true, 2, false);

        $values['contract_root']['year'] = Helpers_DateTime::getYear($modelRoot->getFromAt());
        $values['contract_root']['from_at_rus'] = Helpers_DateTime::getDateTimeDayMonthRus($modelRoot->getFromAt(), true);
        $values['contract_root']['from_at'] = Helpers_DateTime::getDateFormatRus($modelRoot->getFromAt());
        $values['contract_root']['amount_str'] = Func::numberToStr($modelRoot->getAmount());
        $values['contract_root']['amount_currency_str'] = Func::numberToStr($modelRoot->getAmount(), true, $sitePageData->currency, true, true);
        $values['contract_root']['amount'] = Func::getNumberStr($modelRoot->getAmount(), true, 2, false);

        $values['params'] = [];
        $params = Arr::path($model->getOptionsArray(), 'contract_template_params.' . $fileName, array());
        foreach ($params as $key => $param){
            $values['params'][$key] = $param;
        }

        // получаем список товаров договора
        $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
            $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_client_contract_id' => $shopClientContractID,
                    'sort_by' => array('created_at' => 'asc'),
                )
            ),
            0, true,
            array(
                'shop_product_id' => array('name', 'shop_id', 'unit'),
                'shop_product_rubric_id' => array('name'),
                'shop_product_id.shop_id' => array('name', 'options'),
            )
        );
        $shopClientContractItemIDs->addAdditionDataChilds(['is_fixed_contract' => $model->getIsFixedContract()]);

        // заменяем данные в шаблоне
        $replaceValues = function ($data, array $values){
            if(!empty($data)){
                foreach ($values as $basic => $arr) {
                    foreach ($arr as $key => $value) {
                        if (!is_array($value)) {
                            $data = mb_str_replace('{#' . $basic . '.' . $key . '#}', $value, $data);
                        }
                    }
                }
            }

            return $data;
        };

        // заменяем данные в шаблоне
        $replaceGoodsValues = function ($data, MyArray $shopClientContractItemIDs){
            // добавляем таблицу товаров филиалов
            $params = $shopClientContractItemIDs;

            $beginBranch = mb_strpos($data, '{#shop_branches.begin#}');
            if ($beginBranch !== false) {
                $endBranch = mb_strpos($data, '{#shop_branches.end#}', $beginBranch);
                if ($endBranch !== false) {
                    $templateBranch = mb_substr($data, $beginBranch + strlen('{#shop_branches.begin#}'), $endBranch - $beginBranch - strlen('{#shop_branches.begin#}'));

                    $begin = mb_strpos($templateBranch, '{#shop_client_contract_items.begin#}');
                    if ($begin !== false) {
                        $end = mb_strpos($templateBranch, '{#shop_client_contract_items.end#}', $begin);
                        if ($end !== false) {
                            $template = mb_substr($templateBranch, $begin + strlen('{#shop_client_contract_items.begin#}'), $end - $begin - strlen('{#shop_client_contract_items.begin#}'));

                            $items = array();
                            foreach ($params->childs as $child) {
                                $shop = $child->getElementValue('shop_product_id', 'shop_id', 0);
                                if (!key_exists($shop, $items)) {
                                    $items[$shop] = array(
                                        'text' => '',
                                        'shop' => $child,
                                        'field' => 'shop_id',
                                        'index' => 1,
                                    );
                                }

                                $items[$shop]['text'] .= mb_str_replace('#index#', $items[$shop]['index']++,
                                    mb_str_replace('{#shop_client_contract_items.name#}', $child->getElementValue('shop_product_id', 'name', $child->getElementValue('shop_product_rubric_id')),
                                        mb_str_replace('{#shop_client_contract_items.quantity#}', Func::getNumberStr($child->values['quantity'], true, 3, true),
                                            mb_str_replace('{#shop_client_contract_items.price#}', Func::getNumberStr($child->values['price'], true, 2, false),
                                                mb_str_replace('{#shop_client_contract_items.amount#}', Func::getNumberStr($child->values['amount'], true, 2, false),
                                                    mb_str_replace('{#shop_client_contract_items.unit#}', $child->getElementValue('shop_product_id', 'unit'), $template)
                                                )
                                            )
                                        )
                                    )
                                );
                            }

                            $itemsBranch = '';
                            foreach ($items as $child) {
                                $itemsBranch .= mb_str_replace(
                                    '{#shop_branches.address#}',
                                    Arr::path(json_decode($child['shop']->getElementValue($child['field'], 'options'), true), 'requisites.address', ''),
                                    mb_str_replace('{#shop_client_contract_items.begin#}' . $template . '{#shop_client_contract_items.end#}', $child['text'], $templateBranch)
                                );
                            }
                            $data = mb_str_replace('{#shop_branches.begin#}' . $templateBranch . '{#shop_branches.end#}', $itemsBranch, $data);
                        }
                    }
                }
            }

            // добавляем таблицу товаров
            $params = $shopClientContractItemIDs;
            $begin = mb_strpos($data, '{#shop_client_contract_items.begin#}');
            if ($begin !== false) {
                $end = mb_strpos($data, '{#shop_client_contract_items.end#}', $begin);
                if ($end !== false) {
                    $template = mb_substr($data, $begin + strlen('{#shop_client_contract_items.begin#}'), $end - $begin - strlen('{#shop_client_contract_items.begin#}'));

                    $index = 1;
                    $items = '';
                    foreach ($params->childs as $child) {
                        $items .= mb_str_replace('#index#', $index++,
                            mb_str_replace('{#shop_client_contract_items.name#}', $child->getElementValue('shop_product_id', 'name', $child->getElementValue('shop_product_rubric_id')),
                                mb_str_replace('{#shop_client_contract_items.quantity#}', Func::getNumberStr($child->values['quantity'], true, 3, true),
                                    mb_str_replace('{#shop_client_contract_items.price#}', Func::getNumberStr($child->values['price'], true, 2, false),
                                        mb_str_replace('{#shop_client_contract_items.amount#}', Func::getNumberStr($child->values['amount'], true, 2, false),
                                            mb_str_replace('{#shop_client_contract_items.unit#}', $child->getElementValue('shop_product_id', 'unit'), $template)
                                        )
                                    )
                                )
                            )
                        );

                        if (!is_array($child)) {
                            continue;
                        }
                    }
                    $data = mb_str_replace('{#shop_client_contract_items.begin#}' . $template . '{#shop_client_contract_items.end#}', $items, $data);
                }
            }

            return $data;
        };

        $pdf = new PDF_Ab1_Page('', '');

        // верхник колонтитул
        $header = Arr::path($contractTemplate, 'header', '');
        if(!$isNotReplace) {
            $header = $replaceValues($header, $values);
        }
        $pdf->headerHTML($header);

        // нижний колонтитул
        $pdf->setFooterFont(Array('dejavusans', '', 9));
        $footer = Arr::path($contractTemplate, 'footer', '');
        if(!$isNotReplace) {
            $footer = $replaceValues($footer, $values);
        }
        $pdf->footerHtml($footer);
        $pdf->footerHtml('<table><tr><td style="width: 50%">Поставщик: _____________________________</td><td style="text-align: right; width: 50%">Покупатель: _____________________________</td></tr></table><br>' . $footer);

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER - 5);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM - 6);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);

        // тело документа
        $pdf->SetFont('dejavusans', '', 11.3);

        $body = '';
        foreach ($contractTemplate['body'] as $template){
            $str = $template['text'];

            if(!$isNotReplace){
                if ($template['type'] == 'goods'){
                    $str = $replaceGoodsValues($str, $shopClientContractItemIDs);
                }

                $str = $replaceValues($str, $values);
            }

            $body .= $str;
        }

        $pdf->writeHTML($body);

        ob_end_clean();
        $fileName = 'Договор №' . mb_str_replace('/', ' ', $model->getNumber()) . '.pdf';
        if ($isPHPOutput){
            $pdf->Output($fileName, 'D');
        }else {
            $pdf->Output($fileName, 'F');
        }
        die;
    }

    /**
     * удаление товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 1){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Client_Contract();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Client contract not found. #2901201610');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
                $sitePageData->shopMainID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_contract_id' => $id,
                        'is_delete' => 1,
                        'is_public' => 0,
                    )
                )
            );

            $driver->unDeleteObjectIDs(
                $shopClientContractItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME, array('is_public' => 1), $sitePageData->shopMainID
            );
        }else{
            $shopClientContractItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Contract_Item',
                $sitePageData->shopMainID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_contract_id' => $id,
                    )
                )
            );

            $driver->deleteObjectIDs(
                $shopClientContractItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Client_Contract_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopMainID
            );
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Contract();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client contract not found. #2901201611');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamFloat('amount', $model);

        Request_RequestParams::setParamStr('original', $model);
        Request_RequestParams::setParamStr('subject', $model);
        Request_RequestParams::setParamBoolean('is_basic', $model);
        Request_RequestParams::setParamBoolean('is_prolongation', $model);
        Request_RequestParams::setParamBoolean('is_redaction_client', $model);
        Request_RequestParams::setParamInt('basic_shop_client_contract_id', $model);
        Request_RequestParams::setParamInt('client_contract_type_id', $model);
        Request_RequestParams::setParamInt('client_contract_status_id', $model);
        Request_RequestParams::setParamInt('client_contract_view_id', $model);
        Request_RequestParams::setParamInt('client_contract_kind_id', $model);
        Request_RequestParams::setParamInt('executor_shop_worker_id', $model);
        Request_RequestParams::setParamBoolean('is_fixed_contract', $model);
        Request_RequestParams::setParamBoolean('is_show_branch', $model);
        Request_RequestParams::setParamBoolean('is_add_basic_contract', $model);
        Request_RequestParams::setParamInt('currency_id', $model);
        Request_RequestParams::setParamBoolean('is_perpetual', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);
        Request_RequestParams::setParamInt('shop_client_contract_storage_id', $model);
        Request_RequestParams::setParamInt('shop_department_id', $model);
        Request_RequestParams::setParamBoolean('is_receive', $model);

        $contractTemplates = Request_RequestParams::getParamArray('contract_templates');
        if ($contractTemplates !== NULL) {
            $model->setContractTemplatesArray($contractTemplates);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $model->setUpdatedOperationID($sitePageData->operationID);
            if(Func::_empty($model->getNumber())){
                $model->setNumber(DB_Basic::getNumber1C($model, $sitePageData, $driver, $sitePageData->shopID).'-'.date('m').'/'.date('y'));
            }

            if($model->getExecutorShopWorkerID() < 1 && $sitePageData->interfaceID != Model_Ab1_Shop_Operation::RUBRIC_JURIST){
                $model->setExecutorShopWorkerID($sitePageData->operation->getShopWorkerID());
            }

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии и файлы
            DB_Basic::saveFiles($model, $sitePageData, $driver);

            // если прикреплен хоть один файл и договор имеет статус "На согласовании", то ставим статус "Действует"
            if($model->getClientContractStatusID() == Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_ON_APPROVAL
                && !Helpers_Array::_empty($model->getOptionsValue('files'))){
                $model->setClientContractStatusID(Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);
            }

            $shopClientContractItems = Request_RequestParams::getParamArray('shop_client_contract_items');
            if($shopClientContractItems !== NULL) {
                switch ($model->getClientContractTypeID()){
                    case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT:
                        $data = Api_Ab1_Shop_Client_Contract_Item::saveProduct(
                            $sitePageData->shopID, $model, $shopClientContractItems, $sitePageData, $driver
                        );
                        $model->setIsFixedPrice($data['is_fixed_price']);
                        $model->setSubject(implode(', ', $data['rubrics']));
                        break;
                    case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_MATERIAL:
                        Api_Ab1_Shop_Client_Contract_Item::saveMaterial(
                            $sitePageData->shopID, $model, $shopClientContractItems, $sitePageData, $driver
                        );
                        break;
                    case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_RAW:
                        Api_Ab1_Shop_Client_Contract_Item::saveRaw(
                            $sitePageData->shopID, $model, $shopClientContractItems, $sitePageData, $driver
                        );
                        break;
                    case Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_BUY_FUEL:
                        Api_Ab1_Shop_Client_Contract_Item::saveFuel(
                            $sitePageData->shopID, $model, $shopClientContractItems, $sitePageData, $driver
                        );
                        break;
                    default:
                        Api_Ab1_Shop_Client_Contract_Item::save(
                            $sitePageData->shopID, $model, $shopClientContractItems, $sitePageData, $driver
                        );
                }

                // Просчет суммы договора с доп. соглашениями, которые увеличивают сумму договора
                $data = self::calcAmount(
                    $model->id, $sitePageData, $driver, $model->getBasicShopClientContractID() == 0
                );
                $model->setAmount($data['amount']);
                $model->setQuantity($data['quantity']);

                // Просчет суммы основного договора с доп. соглашениями, которые увеличивают сумму договора
                if($model->getBasicShopClientContractID() > 0){
                    self::calcAmount(
                        $model->getBasicShopClientContractID(), $sitePageData, $driver, true, true
                    );
                }
            }

            $model->setOperationUpdatedAt(date('Y-m-d H:i:s'));

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();

            // просчитываем количетсво допсоглашений у основного договора
            if($model->isEditValue('is_basic')){
                self::calcCountAdditionalAgreement($model->getBasicShopClientContractID(), $sitePageData, $driver);
                self::calcCountAdditionalAgreement(
                    $model->getOriginalValue('basic_shop_client_contract_id'), $sitePageData, $driver
                );
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
