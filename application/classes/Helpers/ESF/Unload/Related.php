<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Объект связанной накладной
 * Class Helpers_ESF_Unload_Consignor
 */
class Helpers_ESF_Unload_Related extends Model_Basic_BasicObject
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

        $this->setDate(Arr::path($xml, 'date.value', ''));
        $this->setNum(Arr::path($xml, 'num.value', ''));
        $this->setRegistrationNumber(Arr::path($xml, 'registrationNumber.value', ''));
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

    // Дата
    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    // Номер
    public function setNum($value){
        $this->setValue('num', $value);
    }
    public function getNum(){
        return $this->getValue('num');
    }

    // Регистрационный номер
    public function setRegistrationNumber($value){
        $this->setValue('registration_number', $value);
    }
    public function getRegistrationNumber(){
        return $this->getValue('registration_number');
    }
}