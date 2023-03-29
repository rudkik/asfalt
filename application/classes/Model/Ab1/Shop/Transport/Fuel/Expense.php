<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Transport_Fuel_Expense extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_fuel_expenses';
	const TABLE_ID = 0;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_move_client_id',
                'fuel_id',
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
        $this->isValidationFieldInt('shop_move_client_id', $validation);
        $this->isValidationFieldInt('shop_transport_mark_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportMarkID($value){
        $this->setValueInt('shop_transport_mark_id', $value);
    }
    public function getShopTransportMarkID(){
        return $this->getValueInt('shop_transport_mark_id');
    }

    public function setFuelID($value){
        $this->setValueInt('fuel_id', $value);
    }
    public function getFuelID(){
        return $this->getValueInt('fuel_id');
    }

    public function setShopMoveClientID($value){
        $this->setValueInt('shop_move_client_id', $value);
    }
    public function getShopMoveClientID(){
        return $this->getValueInt('shop_move_client_id');
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