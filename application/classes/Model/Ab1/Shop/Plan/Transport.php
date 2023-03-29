<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Plan_Transport extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_plan_transports';
	const TABLE_ID = 232;

	public function __construct(){
		parent::__construct(
			array(
                'date',
                'count',
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
        $this->isValidationFieldInt('count', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setCount($value){
        $this->setValueInt('count', $value);
    }
    public function getCount(){
        return $this->getValueInt('count');
    }
}
