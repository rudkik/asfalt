<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Объект выгруженный электронный счет фактуры
 * Class Helpers_ESF_Unload_Invoice
 */
class Helpers_ESF_Unload_Invoice extends Model_Basic_BasicObject
{
    const INVOICE_TYPE_ADDITIONAL_INVOICE = 'ADDITIONAL_INVOICE';

    /**
     * Грузоперевозчик
     * @var Helpers_ESF_Unload_Consignor
     */
    private $consignor;

    /**
     * Грузопоплучатель
     * @var Helpers_ESF_Unload_Consignor
     */
    private $consignee;

    /**
     * Список продукции
     * @var Helpers_ESF_Unload_Products
     */
    private $products;

    /**
     * Продавец
     * @var Helpers_ESF_Unload_Seller
     */
    private $seller;

    /**
     * связанная накладная
     * @var Helpers_ESF_Unload_Related
     */
    private $relatedInvoice;

    /**
     * Helpers_ESF_Unload_Invoice constructor.
     */
    public function __construct()
    {
        $this->consignor = new Helpers_ESF_Unload_Consignor();
        $this->consignee = new Helpers_ESF_Unload_Consignor();
        $this->products = new Helpers_ESF_Unload_Products();
        $this->seller = new Helpers_ESF_Unload_Seller();
        $this->relatedInvoice = new Helpers_ESF_Unload_Related();
    }

    /**
     * Загрузка данных из XML, который преобразован в массив
     * <v2:invoice xmlns:v2="v2.esf" xmlns:a="abstractInvoice.esf">
            <date>18.06.2019</date>
            <num>400004995</num>
            <turnoverDate>05.06.2019</turnoverDate>
            <consignor>Грузоперевозчик</consignor>
            <deliveryDocDate>05.06.2019</deliveryDocDate>
            <deliveryDocNum>3185</deliveryDocNum>
            <deliveryTerm>
                <contractDate>26.11.2018</contractDate>
                <contractNum>01/261118</contractNum>
                <hasContract>true</hasContract>
                <term>безналичный расчет</term>
            </deliveryTerm>
            <productSet>
                <currencyCode>KZT</currencyCode>
                <products>Список продукции</products>
            </productSet>
            <sellers>
                <seller>Продавец</seller>
            </sellers>
       </v2:invoice>
     * @param array $xml
     * @return bool
     */
    public function loadXMLArray(array $xml)
    {
        $this->clear();

        $this->setDate(Arr::path($xml, 'date.value', ''));
        $this->setNumber(Arr::path($xml, 'num.value', ''));
        $this->setTurnoverDate(Arr::path($xml, 'turnoverDate.value', ''));
        $this->setDeliveryDocDate(Arr::path($xml, 'deliveryDocDate.value', NULL));
        $this->setDeliveryDocNumber(Arr::path($xml, 'deliveryDocNum.value', ''));

        $this->setInvoiceType(Arr::path($xml, 'invoiceType.value', ''));

        // Договор
        $this->setContractDate(Arr::path($xml, 'deliveryTerm.contractDate.value', ''));
        $this->setContractNumber(Arr::path($xml, 'deliveryTerm.contractNum.value', ''));
        $this->setTerm(Arr::path($xml, 'deliveryTerm.term.value', ''));

        // Грузоперевозчик
        $this->getConsignor()->loadXMLArray(Arr::path($xml, 'consignor', array()));

        // Грузополучатель
        $this->getConsignee()->loadXMLArray(Arr::path($xml, 'consignee', array()));

        // Связанная накладная
        $this->getRelatedInvoice()->loadXMLArray(Arr::path($xml, 'relatedInvoice', array()));

        // продавец
        foreach (Arr::path($xml, 'sellers', array()) as $child) {
            $this->getSeller()->loadXMLArray($child);
            break;
        }

        // продукция
        $this->getProducts()->loadXMLArray(Arr::path($xml, 'productSet.products.product', array()));


        return TRUE;
    }

    /**
     * Сохраняем в массив
     * @return array
     */
    public function saveInArray(){
        $result = $this->__getArray(FALSE);
        $result['consignor'] = $this->consignor->saveInArray();
        $result['consignee'] = $this->consignee->saveInArray();
        $result['seller'] = $this->seller->saveInArray();
        $result['related_invoice'] = $this->relatedInvoice->saveInArray();
        $result['products'] = $this->products->saveInArray();

        return $result;
    }

    /**
     * Загружаем из массива в массив
     * @param array $data
     */
    public function loadToArray(array $data){
        $this->clear();

        $this->consignor->loadToArray(Arr::path($data, 'consignor', array()));
        unset($data['consignor']);

        $this->consignee->loadToArray(Arr::path($data, 'consignee', array()));
        unset($data['consignee']);

        $this->seller->loadToArray(Arr::path($data, 'seller', array()));
        unset($data['seller']);

        $this->relatedInvoice->loadToArray(Arr::path($data, 'related_invoice', array()));
        unset($data['related_invoice']);

        $this->products->loadToArray(Arr::path($data, 'products', array()));
        unset($data['products']);

        $this->__setArray($data);
    }

    /**
     * Отчиска данных
     */
    public function clear(){
        parent::clear();
        $this->consignor->clear();
        $this->consignee->clear();
        $this->products->clear();
        $this->seller->clear();
        $this->relatedInvoice->clear();
    }

    // Грузоперевозчик
    public function getConsignor(){
        return $this->consignor;
    }

    // Грузополучатель
    public function getConsignee(){
        return $this->consignee;
    }

    // Список продукции
    public function getProducts(){
        return $this->products;
    }

    // Связанная накладная
    public function getRelatedInvoice(){
        return $this->relatedInvoice;
    }

    // Продавец
    public function getSeller(){
        return $this->seller;
    }

    // Дата выписки
    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    // Номер учетной системы
    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    // Дата совершения оборота
    public function setTurnoverDate($value){
        $this->setValueDate('turnover_date', $value);
    }
    public function getTurnoverDate(){
        return $this->getValueDate('turnover_date');
    }

    // Дата документа, подтверждающего поставку товаров, работ, услуг
    public function setDeliveryDocDate($value){
        $this->setValueDate('delivery_doc_date', $value);
    }
    public function getDeliveryDocDate(){
        return $this->getValueDate('delivery_doc_date');
    }

    // Номер документа, подтверждающего поставку товаров, работ, услуг
    public function setDeliveryDocNumber($value){
        $this->setValue('delivery_doc_number', $value);
    }
    public function getDeliveryDocNumber(){
        return $this->getValue('delivery_doc_number');
    }

    // Тип счет-фактуры
    public function setInvoiceType($value){
        $this->setValue('invoice_type', $value);
    }
    public function getInvoiceType(){
        return $this->getValue('invoice_type');
    }

    // Дата договора
    public function setContractDate($value){
        $this->setValueDate('contract_date', $value);
    }
    public function getContractDate(){
        return $this->getValueDate('contract_date');
    }

    // Номер договора
    public function setContractNumber($value){
        $this->setValue('contract_number', $value);
    }
    public function getContractNumber(){
        return $this->getValue('contract_number');
    }

    // Тип оплаты (наличными или безналичными)
    public function setTerm($value){
        $this->setValue('term', $value);
    }
    public function getTerm(){
        return $this->getValue('term');
    }

    // Номер ЭФС в системе
    public function setRegistrationNumber($value){
        $this->setValue('registration_number', $value);
    }
    public function getRegistrationNumber(){
        return $this->getValue('registration_number');
    }
}