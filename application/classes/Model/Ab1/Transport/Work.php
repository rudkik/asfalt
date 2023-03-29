<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Transport_Work extends Model_Basic_Name{

    const TABLE_NAME = 'ab_transport_works';
    const TABLE_ID = 411;

    public function __construct(){
        parent::__construct(
            array(
                'number',
                'salary',
                'salary_hour',
                'formula',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldStr('number', $validation);
        $this->isValidationFieldStr('salary', $validation);
        $this->isValidationFieldStr('salary_hour', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['shop_transport_work_ids'] = $this->getShopTransportWorkIDsArray();
        }

        return $arr;
    }

    public function setIs1C($value){
        $this->setValueBool('is_1c', $value);
    }
    public function getIs1C(){
        return $this->getValueBool('is_1c');
    }

    public function setFormula($value){
        $this->setValue('formula', $value);
    }
    public function getFormula(){
        return $this->getValue('formula');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setSalary($value){
        $this->setValueFloat('salary', $value);
    }
    public function getSalary(){
        return $this->getValueFloat('salary');
    }

    public function setSalaryHour($value){
        $this->setValueFloat('salary_hour', $value);
    }
    public function getSalaryHour(){
        return $this->getValueFloat('salary_hour');
    }

    // JSON настройки списка полей
    public function setShopTransportWorkIDs($value){
        $this->setValue('shop_transport_work_ids', $value);
    }
    public function getShopTransportWorkIDs(){
        return $this->getValue('shop_transport_work_ids');
    }
    public function setShopTransportWorkIDsArray(array $value){
        $this->setValueArray('shop_transport_work_ids', $value, false, true);
    }
    public function getShopTransportWorkIDsArray(){
        return $this->getValueArray('shop_transport_work_ids', NULL, array(), false, true);
    }

}
