<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Fuel_Issue extends Model_Basic_Name{

	const TABLE_NAME = 'ab_fuel_issues';
	const TABLE_ID = 374;

	public function __construct(){
		parent::__construct(
			array(
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
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        return $this->_validationFields($validation, $errorFields);
    }

}
