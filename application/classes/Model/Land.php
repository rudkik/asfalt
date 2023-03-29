<?php defined('SYSPATH') or die('No direct script access.');

class Model_Land extends Model_Basic_Name{

	const TABLE_NAME='ct_lands';
	const TABLE_ID = 43;

	public function __construct(){
		parent::__construct(
			array(
				'currency_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
	
	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('currency_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('currency_id')) {
			$validation->rule('currency_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	// ID типа товара
	public function setCurrencyID($value){
		$this->setValueInt('currency_id', $value);
	}

	public function getCurrencyID(){
		return $this->getValueInt('currency_id');
	}
}
