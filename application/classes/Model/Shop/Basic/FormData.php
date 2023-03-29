<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Basic_FormData extends Model_Shop_Basic_SEO{

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        $validation->rule('form_data', 'max_length', array(':value', 65000));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['form_data'] = $this->getFormDataArray();
        }

        return $arr;
    }

    // JSON настройки списка полей
    public function setFormData($value){
        $this->setValue('form_data', $value);
    }

    public function getFormData(){
        return $this->getValue('form_data');
    }

    // JSON настройки списка полей
    public function setFormDataArray(array $value){
        $this->setValueArray('form_data', $value);
    }
    public function getFormDataArray(){
        return $this->getValueArray('form_data');
    }
    public function addFormDataArray(array $value)
    {
        $tmp = $this->getFormDataArray();

        foreach($value as $k => $v){
            $tmp[$k] = $v;
        }

        $this->setFormDataArray($tmp);
    }
    public function joinFormDataArray(array $value)
    {
        $this->setFormDataArray(Helpers_Array::arrayJoin($this->getFormDataArray(), $value));
    }
}

