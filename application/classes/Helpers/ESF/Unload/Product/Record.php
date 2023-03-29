<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Объект выгруженного продукта
 * Class Helpers_ESF_Unload_Product_Record
 */
class Helpers_ESF_Unload_Product_Record extends Model_Basic_BasicObject
{
    /**
     * Загрузка данных из XML, который преобразован в массив
     * <product>
            <catalogTruId>1</catalogTruId>
            <description>ПРОСТОКВАШИНО СЛИВКИ СТЕРИЛИЗОВАННЫЕ 200ГР., 10%</description>
            <ndsAmount>79.07</ndsAmount>
            <ndsRate>12</ndsRate>
            <priceWithTax>738</priceWithTax>
            <priceWithoutTax>658.93</priceWithoutTax>
            <productDeclaration>090430042019N00336</productDeclaration>
            <productNumberInDeclaration>002</productNumberInDeclaration>
            <quantity>3</quantity>
            <tnvedName>ПРО СливкиУП 200 10% К27</tnvedName>
            <truOriginCode>2</truOriginCode>
            <turnoverSize>658.93</turnoverSize>
            <unitCode>0401401000</unitCode>
            <unitNomenclature>796</unitNomenclature>
            <unitPrice>219.64</unitPrice>
       </product>
     * @param array $xml
     */
    public function loadXMLArray(array $xml)
    {
        $this->clear();

        $quantity = abs(Arr::path($xml, 'quantity.value', 1));

        $this->setName(Arr::path($xml, 'description.value', ''));
        $this->setCatalogTruID(Arr::path($xml, 'catalogTruId.value', ''));
        $this->setNDSAmount(Arr::path($xml, 'ndsAmount.value', ''));
        $this->setNDSPercent(Arr::path($xml, 'ndsRate.value', ''));
        $this->setPrice(abs(round(Arr::path($xml, 'priceWithTax.value', 0)  / $quantity, 2)));
        $this->setDeclaration(Arr::path($xml, 'productDeclaration.value', ''));
        $this->setNumberInDeclaration(Arr::path($xml, 'productNumberInDeclaration.value', ''));
        $this->setQuantity($quantity);
        $this->setTNVEDName(Arr::path($xml, 'tnvedName.value', ''));
        $this->setTruOriginCode(Arr::path($xml, 'truOriginCode.value', ''));
        $this->setUnitCode(Arr::path($xml, 'unitCode.value', ''));
        $this->setUnitNomenclature(Arr::path($xml, 'unitNomenclature.value', ''));

        $this->calcHash();
    }

    /**
     * Сохраняем в массив
     * @return array
     */
    public function saveInArray(){
        return $this->__getArray(FALSE);
    }

    /**
     * Загружаем из массива в массив
     * @param array $data
     */
    public function loadToArray(array $data){
        $this->__setArray($data);
    }

    // хэш строки
    public function calcHash()
    {
        $this->setValue('hash',md5( json_encode($this->saveInArray()) . rand(1, 200000)));
    }
    public function getHash()
    {
        return $this->getValue('hash');
    }

    // Название
    public function setName($value){
        $this->setValue('name', $value);
    }
    public function getName(){
        return $this->getValue('name');
    }

    // Идентификатор товара, работ, услуг
    public function setCatalogTruID($value){
        $this->setValue('catalog_tru_id', $value);
    }
    public function getCatalogTruID(){
        return $this->getValue('catalog_tru_id');
    }

    // Сумма НДС
    public function setNDSAmount($value){
        $this->setValueFloat('nds_amount', $value);
    }
    public function getNDSAmount(){
        return $this->getValueFloat('nds_amount');
    }

    // Процент НДС
    public function setNDSPercent($value){
        $this->setValueFloat('nds_percent', $value);
    }
    public function getNDSPercent(){
        return $this->getValueFloat('nds_percent');
    }

    // Цена товара вместе с НДС, если она есть
    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return round($this->getValueFloat('price'), 2);
    }

    // № Декларации на товары, заявления в рамках ТС, СТ-1 или СТ-KZ
    public function setDeclaration($value){
        $this->setValue('declaration', $value);
    }
    public function getDeclaration(){
        return $this->getValue('declaration');
    }

    // Номер товарной позиции из заявления в рамках ТС или Декларации на товары
    public function setNumberInDeclaration($value){
        $this->setValue('numberInDeclaration', $value);
    }
    public function getNumberInDeclaration(){
        return $this->getValue('numberInDeclaration');
    }

    // Кол-во товаров
    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return round($this->getValueFloat('quantity'), 3);
    }

    // Наименование товаров в соответствии с Декларацией на товары или заявлением о ввозе товаров и уплате косвенных налогов
    public function setTNVEDName($value){
        $this->setValue('tnved_name', $value);
    }
    public function getTNVEDName(){
        return $this->getValue('tnved_name');
    }

    /*
     * Признак происхождения товара, работ, услуг*
     * «1» – в случае реализации товара, включенного в Перечень, ввезенного на территорию Республики Казахстан из государств-членов ЕАЭС или третьих стран. В случае если товар ранее приобретен по ЭСФ предыдущей версии, в строке 12 «Дополнительные данные» которого были указаны буквенные значения «ЕТТ», «ВТО» или «ТС», то данный товар относится к Признаку «1»;
     * «2» – в случае реализации товара, не включенного в Перечень, ввезенного на территорию Республики Казахстан из государств-членов ЕАЭС или третьих стран;
     * «3» – в случае реализации товара, включенного в Перечень, произведенного на территории Республики Казахстан;
     * «4» – в случае реализации товара, не включенного в Перечень, произведенного на территории Республики Казахстан;
     * «5» – в случае реализации товара, не относящегося к Признакам «1», «2», «3», «4»; «6» – в случае выполнения работ, оказания услуг.
     */
    public function setTruOriginCode($value){
        $this->setValueInt('tru_origin_code', $value);
    }
    public function getTruOriginCode(){
        return $this->getValueInt('tru_origin_code');
    }

    // Единица измерения товара (код)
    public function setUnitCode($value){
        $this->setValue('unit_code', $value);
    }
    public function getUnitCode(){
        return $this->getValue('unit_code');
    }

    // Единица измерения товара (id)
    public function setUnitNomenclature($value){
        $this->setValueInt('unit_nomenclature', $value);
    }
    public function getUnitNomenclature(){
        return $this->getValueInt('unit_nomenclature');
    }

    // С каким продуктов приемки связан
    public function setShopReceiveItemID($value){
        $this->setValueInt('shop_receive_item_id', $value);
    }
    public function getShopReceiveItemID(){
        return $this->getValueInt('shop_receive_item_id');
    }

    // Сумма товаров
    public function getAmount(){
        return $this->getPrice() * $this->getQuantity();
    }
}