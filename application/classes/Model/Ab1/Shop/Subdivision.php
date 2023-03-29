<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Subdivision extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_subdivisions';
	const TABLE_ID = 318;

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
