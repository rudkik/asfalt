<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Объект выгруженного продавца
 * Class Helpers_ESF_Unload_Seller
 */
class Helpers_ESF_Unload_Seller extends Model_Basic_BasicObject
{
    /**
     * Загрузка данных из XML, который преобразован в массив
     * <seller>
            <address>Республика Казахстан, г.Алматы, Ташкентская, дом № 540/7, корпус оф 302</address>
            <bank>АО "Народный Банк Казахстана"</bank>
            <bik>HSBKKZKX</bik>
            <certificateNum>1192568</certificateNum>
            <certificateSeries>60001</certificateSeries>
            <iik>KZ156017131000024449</iik>
            <kbe>17</kbe>
            <name>Товарищество с ограниченной ответственностью "Eurasia DS"</name>
            <tin>170340003434</tin>
       </seller>
     * @param array $xml
     */
    public function loadXMLArray(array $xml)
    {
        $this->clear();

        $this->setName(Arr::path($xml, 'name.value', ''));
        $this->setAddress(Arr::path($xml, 'address.value', ''));
        $this->setBank(Arr::path($xml, 'bank.value', ''));
        $this->setBIK(Arr::path($xml, 'bik.value', ''));
        $this->setCertificateNumber(Arr::path($xml, 'certificateNum.value', ''));
        $this->setCertificateSeries(Arr::path($xml, 'certificateSeries.value', ''));
        $this->setIIK(Arr::path($xml, 'iik.value', ''));
        $this->setKBE(Arr::path($xml, 'kbe.value', ''));
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

    // Юридический адрес
    public function setAddress($value){
        $this->setValue('address', $value);
    }
    public function getAddress(){
        return $this->getValue('address');
    }

    // Название банка
    public function setBank($value){
        $this->setValue('bank', $value);
    }
    public function getBank(){
        return $this->getValue('bank');
    }

    // БИК
    public function setBIK($value){
        $this->setValue('bik', $value);
    }
    public function getBIK(){
        return $this->getValue('bik');
    }

    // Номер сертификата
    public function setCertificateNumber($value){
        $this->setValue('certificate_number', $value);
    }
    public function getCertificateNumber(){
        return $this->getValue('certificate_number');
    }

    // Серия сертификата
    public function setCertificateSeries($value){
        $this->setValue('certificate_series', $value);
    }
    public function getCertificateSeries(){
        return $this->getValue('certificate_series');
    }

    // Номер расчетного счета
    public function setIIK($value){
        $this->setValue('iik', $value);
    }
    public function getIIK(){
        return $this->getValue('iik');
    }

    // КБЕ
    public function setKBE($value){
        $this->setValue('kbe', $value);
    }
    public function getKBE(){
        return $this->getValue('kbe');
    }

    // BИН
    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }
}