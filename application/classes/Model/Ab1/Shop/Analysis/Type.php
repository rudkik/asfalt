<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Analysis_Type extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_analysis_types';
	const TABLE_ID = 379;

    const OPTIONS_TYPE_INTEGER = 1;
    const OPTIONS_TYPE_FLOAT = 2;
    const OPTIONS_TYPE_DOUBLE = 3;
    const OPTIONS_TYPE_TEXT = 4;
    const OPTIONS_TYPE_DATE = 5;
    const OPTIONS_TYPE_TIME = 6;
    const OPTIONS_TYPE_FORMULA = 7;
    const OPTIONS_TYPE_TABLE = 8;
    const OPTIONS_TYPE_DATA_TIME = 9;

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
