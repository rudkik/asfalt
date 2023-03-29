<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Список объектов выгруженного продукта
 * Class Helpers_ESF_Unload_Products
 */
class Helpers_ESF_Unload_Products extends Helpers_Array_Collection
{
    /**
     * Загрузка данных из XML, который преобразован в массив
     * <products>
           <product>
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
       </products>
     * @param array $xml
     */
    public function loadXMLArray(array $xml)
    {
        $this->clear();

        if(key_exists('description', $xml)){
            $xml = array($xml);
        }

        foreach ($xml as $child){
            $quantity = Arr::path($child, 'quantity.value', 1);
            if($quantity == 0){
                continue;
            }
            if($quantity < 0) {
                $quantity = $quantity * -1;
            }
            $name = Arr::path($child, 'description.value', '') . '_' .
                round(Arr::path($child, 'priceWithTax.value', 0)  / $quantity, 2);
            if(empty($name)){
                continue;
            }

            // группируем товары с одним названием и ценой
            $product = $this->get($name);
            if($product === NULL){
                $product = new Helpers_ESF_Unload_Product();
            }
            $product->loadXMLArray($child);

            $this->set($name, $product);
        }
    }

    /**
     * Сохраняем в массив
     * @return array
     */
    public function saveInArray(){
        $result = array();
        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($this->getValues() as $child){
            $result[] = $child->saveInArray();
        }

        return $result;
    }

    /**
     * Загружаем из массива в массив
     * @param array $data
     */
    public function loadToArray(array $data){
        $this->clear();

        foreach ($data as $child){
            $product = new Helpers_ESF_Unload_Product();
            $product->loadToArray($child);

            $this->set($product->getName().'_'.$product->getPrice().'_'.$product->getShopReceiveItemID(), $product);
        }
    }

    /**
     * Ищем продукцию по хэшу
     * @param $hash
     * @return bool|Helpers_ESF_Unload_Product
     */
    public function findProductByHash($hash){
        /** @var Helpers_ESF_Unload_Product $child */
        $result = [];
        foreach ($this->getValues() as $child){
            if($child->getHash() == $hash){
                return $child;
            }
        }

        return FALSE;
    }

    // Кол-во товаров
    public function getQuantity(){
        $result = 0;
        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($this->getValues() as $child){
            $result += $child->getQuantity();
        }

        return $result;
    }

    // Сумма товаров
    public function getAmount(){
        $result = 0;
        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($this->getValues() as $child){
            $result += $child->getAmount();
        }

        return $result;
    }

    // Сумма НДС товаров
    public function getNDSAmount(){
        $result = 0;
        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($this->getValues() as $child){
            $result += $child->getNDSAmount();
        }

        return $result;
    }

    // Проверяем есть ли не распределенные продукты
    public function isNotProcessed(){
        if($this->isEmpty()){
            return false;
        }

        /** @var Helpers_ESF_Unload_Product $child */
        foreach ($this->getValues() as $child){
            if($child->getShopReceiveItemID() < 1){
                return true;
            }
        }

        return false;
    }
}