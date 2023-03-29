<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Basic_Text extends Model_Shop_Basic_Object{

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        $overallLanguageFields[] = 'order';

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());
        $validation->rule('text', 'max_length', array(':value', 650000))
            ->rule('order', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('order')) {
            $validation->rule('order', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    // Текст новости (HTML-код)
    public function setText($value){
        $this->setValue('text', $value);
    }
    public function getText(){
        return $this->getValue('text');
    }

    public function setOrder($value){
        $this->setValue('order', intval($value));
    }
    public function getOrder(){
        return intval($this->getValue('order'));
    }
}
