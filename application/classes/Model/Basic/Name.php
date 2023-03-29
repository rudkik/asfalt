<?php defined('SYSPATH') or die('No direct script access.');


class Model_Basic_Name extends Model_Basic_DBValue{

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        if ($this->id < 1){
            // $validation->rule('name', 'not_empty');
        }

        $validation->rule('name', 'max_length', array(':value', 250));


        return $this->_validationFields($validation, $errorFields);
    }

    // Название новости
    public function setName($value){
        $this->setValue('name', $value);
    }
    public function getName(){
        return $this->getValue('name');
    }
}
