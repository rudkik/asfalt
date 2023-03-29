<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Act_Revise extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_act_revises';
	const TABLE_ID = 298;

	public function __construct(){
		parent::__construct(
			array(
			    'date',
                'amount',
                'act_revise_type_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'act_revise_type_id':
                    $this->_dbGetElement($this->getActReviseTypeID(), 'act_revise_type_id', new Model_Ab1_ActReviseType(), $shopID);
                    break;
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
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldStr('act_revise_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setActReviseTypeID($value){
        $this->setValue('act_revise_type_id', $value);
    }
    public function getActReviseTypeID(){
        return $this->getValue('act_revise_type_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

	public function setDate($value){
		$this->setValueDate('date', $value);
	}
	public function getDate(){
		return $this->getValueDate('date');
	}
}
