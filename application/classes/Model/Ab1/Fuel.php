<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Fuel extends Model_Basic_Name{

	const TABLE_NAME = 'ab_fuels';
	const TABLE_ID = 370;

	public function __construct(){
		parent::__construct(
			array(
			    'fuel_type_id',
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
        $this->isValidationFieldInt('fuel_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setFuelTypeID($value){
        $this->setValueInt('fuel_type_id', $value);
    }
    public function getFuelTypeID(){
        return $this->getValueInt('fuel_type_id');
    }
}
