<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Basic_Collations extends Model_Shop_Basic_Remarketing{

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        $overallLanguageFields[] = 'collations';

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $validation->rule('collations', 'max_length', array(':value', 650000));

        return $this->_validationFields($validation, $errorFields);
    }

    // JSON настройки списка полей
    public function setCollations($value){
        $this->setValue('collations', $value);
    }

    public function getCollations(){
        return $this->getValue('collations');
    }

    // JSON список значений для сопоставления
    public function setCollationsArray(array $value){
        $this->setValueArray('collations', $value);
    }

    public function getCollationsArray(){
        return $this->getValueArray('collations');
    }

    public function addCollationsArray($value){
        $tmp = $this->getCollationsArray();

        if(is_array($value)) {
            foreach ($value as $v) {
                if (array_search($v, $tmp) === FALSE) {
                    $tmp[] = $v;
                }
            }
        }else{
            if (array_search($value, $tmp) === FALSE) {
                $tmp[] = $value;
            }
        }

        $this->setCollationsArray($tmp);
    }
}
