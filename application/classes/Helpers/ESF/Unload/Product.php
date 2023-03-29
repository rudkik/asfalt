<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Объект выгруженного продукта
 * Class Helpers_ESF_Unload_Product
 */
class Helpers_ESF_Unload_Product extends Model_Basic_BasicObject
{
    /**
     * Список записей данного товара
     * @var  Helpers_ESF_Unload_Product_Record
     */
    private $records;

    /**
     * Helpers_ESF_Unload_Product constructor.
     */
    public function __construct()
    {
        $this->records = new Helpers_Array_Collection();
    }

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
        $record = new Helpers_ESF_Unload_Product_Record();
        $record->loadXMLArray($xml);
        $this->records->add($record);
        $this->calcHash();
    }

    /**
     * Сохраняем в массив
     * @return array
     */
    public function saveInArray(){
        $result = $this->__getArray(FALSE);
        $result['records'] = array();

        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            $result['records'][] = $child->saveInArray();
        }

        return $result;
    }

    /**
     * Загружаем из массива в массив
     * @param array $data
     */
    public function loadToArray(array $data){
        $this->clear();

        $records = Arr::path($data, 'records', array());
        if(is_array($records)) {
            foreach ($records as $child) {
                $record = new Helpers_ESF_Unload_Product_Record();
                $record->loadToArray($child);

                $this->records->add($record);
            }
        }
        unset($data['records']);

        $this->__setArray($data);
    }

    /**
     * Отчиска данных
     */
    public function clear(){
        parent::clear();
        $this->records->clear();
    }


    /**
     * Список товаров ЭСФ
     * @return Helpers_Array_Collection|Helpers_ESF_Unload_Product_Record[]
     */
    public function getRecords()
    {
        return $this->records;
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
    public function getName(){
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            return $child->getName();
        }

        return '';
    }

    // Единица измерения
    public function getUnitNomenclature(){
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            return $child->getUnitNomenclature();
        }

        return '';
    }

    // Процент НДС
    public function getNDSPercent(){
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            return $child->getNDSPercent();
        }

        return 0;
    }

    // Цена
    public function getPrice(){
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            return $child->getPrice();
        }

        return 0;
    }

    // С каким продуктов приемки связан
    public function setShopReceiveItemID($value){
        $this->setValueInt('shop_receive_item_id', $value);
    }
    public function getShopReceiveItemID(){
        return $this->getValueInt('shop_receive_item_id');
    }

    // Кол-во товаров
    public function getQuantity(){
        $result = 0;
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            $result += $child->getQuantity();
        }

        return $result;
    }

    // Сумма товаров
    public function getAmount(){
        $result = 0;
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            $result += $child->getAmount();
        }

        return $result;
    }

    // Сумма НДС товаров
    public function getNDSAmount(){
        $result = 0;
        /** @var Helpers_ESF_Unload_Product_Record $child */
        foreach ($this->records->getValues() as $child){
            $result += $child->getNDSAmount();
        }

        return $result;
    }
}