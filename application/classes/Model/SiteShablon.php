<?php defined('SYSPATH') or die('No direct script access.');

class Model_SiteShablon extends Model_Basic_Options{

	const TABLE_NAME='ct_site_shablons';
	const TABLE_ID = 50;

	public function __construct(){
		parent::__construct(
			array(
				'shablon_path'
			),
			self::TABLE_NAME,
			self::TABLE_ID,
			FALSE
		);
	}
	
	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('shablon_path', 'max_length', array(':value', 200));

		return $this->_validationFields($validation, $errorFields);
	}

	//Путь до шаблона
	public function setShablonPath($value){
		$this->setValue('shablon_path', $value);
	}

	public function getShablonPath(){
		return $this->getValue('shablon_path');
	}}
