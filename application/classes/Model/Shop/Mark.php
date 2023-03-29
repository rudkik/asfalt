<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Mark extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_marks';
	const TABLE_ID = 201;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

        $this->isAddUUID = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		parent::dbGetElements($shopID, $elements);
	}
	
	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields)
	{
		$validation = new Validation($this->getValues());

		return $this->_validationFields($validation, $errorFields);
	}
}
