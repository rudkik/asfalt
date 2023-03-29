<?php defined('SYSPATH') or die('No direct script access.');


class Model_Calendar_Shop_Partner extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tc_shop_partners';
	const TABLE_ID = 292;

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
