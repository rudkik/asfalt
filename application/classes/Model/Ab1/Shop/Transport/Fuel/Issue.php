<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Transport_Fuel_Issue extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_fuel_issues';
	const TABLE_ID = 358;

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
        $this->isValidationFieldInt('fuel_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setFuelID($value){
        $this->setValueInt('fuel_id', $value);
    }
    public function getFuelID(){
        return $this->getValueInt('fuel_id');
    }

    public function setShopClienlID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }
}
