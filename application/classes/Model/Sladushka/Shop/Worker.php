<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sladushka_Shop_Worker extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'sl_shop_workers';
	const TABLE_ID = 172;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
