<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Sequence extends Model_Basic_Name{

	const TABLE_NAME = 'ab_shop_sequences';
	const TABLE_ID = 362;

    public function __construct(){
        parent::__construct(
            array(
                'sequence',
                'is_branch',
                'is_cashbox',
                'is_product',
                'symbol',
                'length',
                'table_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }
    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'table_id':
                        $this->_dbGetElement($this->getTableID(), 'table_id', new Model_Table());
                        break;
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }
    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('table_id', $validation);
        $this->isValidationFieldInt('length', $validation);
        $this->isValidationFieldStr('symbol', $validation);
        $this->isValidationFieldStr('sequence', $validation);
        $this->isValidationFieldBool('is_branch', $validation);
        $this->isValidationFieldBool('is_cashbox', $validation);
        $this->isValidationFieldBool('is_product', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setTableID($value){
        $this->setValueInt('table_id', $value);
    }
    public function getTableID(){
        return $this->getValueInt('table_id');
    }

    public function setLength($value){
        $this->setValueInt('length', $value);
    }
    public function getLength(){
        return $this->getValueInt('length');
    }

    public function setIsBranch($value){
        $this->setValueBool('is_branch', $value);
    }
    public function getIsBranch(){
        return $this->getValueBool('is_branch');
    }
    public function setIsCashbox($value){
        $this->setValueBool('is_cashbox', $value);
    }

    public function getIsCashbox(){
        return $this->getValueBool('is_cashbox');
    }

    public function setIsProduct($value){
        $this->setValueBool('is_product', $value);
    }
    public function getIsProduct(){
        return $this->getValueBool('is_product');
    }

    public function setSequence($value){
        $this->setValue('sequence', $value);
    }
    public function getSequence(){
        return $this->getValue('sequence');
    }

    public function setSymbol($value){
        $this->setValue('symbol', $value);
    }
    public function getSymbol(){
        return $this->getValue('symbol');
    }
}