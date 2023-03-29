<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Transport_Fuel_Storage extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_fuel_storages';
	const TABLE_ID = 389;

	public function __construct(){
		parent::__construct(
			array(
                'number',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldStr('number', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }
}
