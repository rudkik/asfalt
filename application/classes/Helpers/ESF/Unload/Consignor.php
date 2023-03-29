<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Объект выгруженного грузоперевозчик
 * Class Helpers_ESF_Unload_Consignor
 */
class Helpers_ESF_Unload_Consignor extends Model_Basic_BasicObject
{
    /**
     * Загрузка данных из XML, который преобразован в массив
     * <consignor>
            <address>Республика Казахстан, г.Алматы, Ташкентская, дом № 540/7, корпус оф 302</address>
            <name>Товарищество с ограниченной ответственностью "Eurasia DS"</name>
            <tin>170340003434</tin>
       </consignor>
     * @param array $xml
     */
    public function loadXMLArray(array $xml)
    {
        $this->clear();

        $this->setName(Arr::path($xml, 'name.value', ''));
        $this->setAddress(Arr::path($xml, 'address.value', ''));
        $this->setBIN(Arr::path($xml, 'tin.value', ''));
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

    // Название
    public function setName($value){
        $this->setValue('name', $value);
    }
    public function getName(){
        return $this->getValue('name');
    }

    // Адрес
    public function setAddress($value){
        $this->setValue('address', $value);
    }
    public function getAddress(){
        return $this->getValue('address');
    }

    // БИН
    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }
}