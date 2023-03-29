<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Basic_Remarketing extends Model_Shop_Table_Basic_Table{

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        $overallLanguageFields[] = 'remarketing';

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        if ($this->id < 1){
            $validation->rule('name', 'not_empty');
        }

        $validation->rule('remarketing', 'max_length', array(':value', 650000));

        return $this->_validationFields($validation, $errorFields);
    }

    // Ремаркетинг
    public function setRemarketing($value){
        $this->setValue('remarketing', $value);
    }

    public function getRemarketing(){
        return $this->getValue('remarketing');
    }
}
