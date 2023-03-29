<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Transport_Mark extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_marks';
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
        $this->isValidationFieldStr('number', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setTransportWageID($value){
        $this->setValueInt('transport_wage_id', $value);
    }
    public function getTransportWageID(){
        return $this->getValueInt('transport_wage_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setFuelQuantity($value){
        $this->setValueFloat('fuel_quantity', $value);
    }
    public function getFuelQuantity(){
        return $this->getValueFloat('fuel_quantity');
    }

    public function setMilage($value){
        $this->setValueFloat('milage', $value);
    }
    public function getMilage(){
        return $this->getValueFloat('milage');
    }

    public function setTransportViewID($value){
        $this->setValueInt('transport_view_id', $value);
    }
    public function getTransportViewID(){
        return $this->getValueInt('transport_view_id');
    }

    public function setTransportWorkID($value){
        $this->setValueInt('transport_work_id', $value);
    }
    public function getTransportWorkID(){
        return $this->getValueInt('transport_work_id');
    }

    public function setTransportType1CID($value){
        $this->setValueInt('transport_type_1c_id', $value);
    }
    public function getTransportType1CID(){
        return $this->getValueInt('transport_type_1c_id');
    }

    public function setTransportFormPaymentID($value){
        $this->setValueInt('transport_form_payment_id', $value);
    }
    public function getTransportFormPaymentID(){
        return $this->getValueInt('transport_form_payment_id');
    }
}
