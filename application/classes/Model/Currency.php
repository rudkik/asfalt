<?php defined('SYSPATH') or die('No direct script access.');

class  Model_Currency extends Model_Basic_Name{

	const KZT = 18;
	const USD = 19;
    const RUB = 21;
    const EUR = 22;

	const TABLE_NAME='ct_currencies';
	const TABLE_ID = 37;

	public function __construct(){
		parent::__construct(
			array(
				'is_round',
				'currency_rate',
				'code',
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

		$validation->rule('code', 'max_length', array(':value', 50))
		->rule('symbol', 'max_length', array(':value', 50))
		->rule('is_round', 'max_length', array(':value', 1))
		->rule('is_round', 'range', array(':value', 0, 1))
		->rule('currency_rate', 'decimal', array(':value', 4, 10));
	
		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Получение список полей для перевода
	 * @return array
	 */
	public function getLanguageFields() {
		return array('name', 'symbol');
	}
	
	// Код валюты (KZT)
	public function setCode($value){
		$this->setValue('code', $value);
	}
	public function getCode(){
		return $this->getValue('code');
	}

	// Шаблон для отображения правильной валюты
	public function setSymbol($value){
		$this->setValue('symbol', $value);
	}

	public function getSymbol(){
		return $this->getValue('symbol');
	}

	// Округлять ли до целого числа
	public function setIsRound($value){
		$this->setValueBool('is_round', $value);
	}

	public function getIsRound(){
		return $this->getValueBool('is_round');
	}

	// Курс валюты
	public function setCurrencyRate($value){
		$this->setValueFloat('currency_rate', $value);
	}

	public function getCurrencyRate(){
		return $this->getValueFloat('currency_rate');
	}

}