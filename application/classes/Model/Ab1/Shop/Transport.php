<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transports';
	const TABLE_ID = 407;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'milage',
                'fuel_quantity',
                'shop_transport_mark_id',
                'shop_transport_driver_id',
                'shop_transport_fuel_storage_id',
                'is_trailer',
                'shop_branch_storage_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}
    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_transport_mark_id':
                        $this->_dbGetElement($this->getShopTransportMarkID(), 'shop_transport_mark_id', new Model_Ab1_Shop_Transport_Mark(), 0);
                        break;
                    case 'shop_transport_driver_id':
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), 0);
                        break;
                    case 'shop_transport_fuel_storage_id':
                        $this->_dbGetElement($this->getShopTransportFuelStorageID(), 'shop_transport_fuel_storage_id', new Model_Ab1_Shop_Transport_Fuel_Storage(), 0);
                        break;
                    case 'shop_branch_storage_id':
                        $this->_dbGetElement($this->getShopBranchStorageID(), 'shop_branch_storage_id', new Model_Ab1_Shop_Storage(), 0);
                        break;
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }
    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('shop_transport_mark_id', $validation);
        $this->isValidationFieldInt('shop_transport_driver_id', $validation);
        $this->isValidationFieldInt('shop_transport_fuel_storage_id', $validation);
        $this->isValidationFieldInt('shop_branch_storage_id', $validation);
        $this->isValidationFieldStr('number', $validation);
        $this->isValidationFieldStr('milage', $validation);
        $this->isValidationFieldStr('fuel_quantity', $validation);
        $this->isValidationFieldBool('is_trailer', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportMarkID($value){
        $this->setValueInt('shop_transport_mark_id', $value);
    }
    public function getShopTransportMarkID(){
        return $this->getValueInt('shop_transport_mark_id');
    }

    public function setTransportWageID($value){
        $this->setValueInt('transport_wage_id', $value);
    }
    public function getTransportWageID(){
        return $this->getValueInt('transport_wage_id');
    }

    public function setShopTransportFuelStorageID($value){
        $this->setValueInt('shop_transport_fuel_storage_id', $value);
    }
    public function getShopTransportFuelStorageID(){
        return $this->getValueInt('shop_transport_fuel_storage_id');
    }

    public function setShopTransportDriverID($value){
        $this->setValueInt('shop_transport_driver_id', $value);
    }
    public function getShopTransportDriverID(){
        return $this->getValueInt('shop_transport_driver_id');
    }

    public function setShopBranchStorageID($value){
        $this->setValueInt('shop_branch_storage_id', $value);
    }
    public function getShopBranchStorageID(){
        return $this->getValueInt('shop_branch_storage_id');
    }
    public function setIsTrailer($value){
        $this->setValueBool('is_trailer', $value);
    }
    public function getIsTrailer(){
        return $this->getValueBool('is_trailer');
    }
    public function setFuelQuantity($value){
        $this->setValue('fuel_quantity', $value);
    }
    public function getFuelQuantity(){
        return $this->getValue('fuel_quantity');
    }
    public function setMilage($value){
        $this->setValue('milage', $value);
    }
    public function getMilage(){
        return $this->getValue('milage');
    }
    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setDriverNormDay($value){
        $this->setValueFloat('driver_norm_day', $value);
    }
    public function getDriverNormDay(){
        return $this->getValueFloat('driver_norm_day');
    }

    public function setIsWage($value){
        $this->setValueBool('is_wage', $value);
    }
    public function getIsWage(){
        return $this->getValueBool('is_wage');
    }
}
