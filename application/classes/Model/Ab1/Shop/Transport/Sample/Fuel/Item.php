<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Sample_Fuel_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_sample_fuel_items';
	const TABLE_ID = 391;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_id',
                'quantity',
                'shop_transport_driver_id',
                'fuel_type_id',
                'unit',
                'shop_transport_sample_fuel_id',
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
                    case 'shop_transport_driver_id':
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), $shopID);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), $shopID);
                        break;
                    case 'shop_transport_sample_fuel_id':
                        $this->_dbGetElement($this->getShopTransportSampleFuelID(), 'shop_transport_sample_fuel_id', new Model_Ab1_Shop_Transport_Sample_Fuel(), 0);
                        break;
                    case 'fuel_type_id':
                        $this->_dbGetElement($this->getFuelTypeID(), 'fuel_type_id', new Model_Ab1_Fuel_Type(), 0);
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
        $this->isValidationFieldInt('shop_transport_driver_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldInt('fuel_type_id', $validation);
        $this->isValidationFieldInt('shop_transport_sample_fuel_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldStr('unit', $validation);
        return $this->_validationFields($validation, $errorFields);
    }


    public function setShopTransportDriverID($value){
        $this->setValueInt('shop_transport_driver_id', $value);
    }
    public function getShopTransportDriverID(){
        return $this->getValueInt('shop_transport_driver_id');
    }
    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
    public function setShopTransportSampleFuelID($value){
        $this->setValueInt('shop_transport_sample_fuel_id', $value);
    }
    public function getShopTransportSampleFuelID(){
        return $this->getValueInt('shop_transport_sample_fuel_id');
    }
    public function setFuelTypeID($value){
        $this->setValueInt('fuel_type_id', $value);
    }
    public function getFuelTypeID(){
        return $this->getValueInt('fuel_type_id');
    }
    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
    public function setUnit($value){
        $this->setValue('unit', $value);
    }
    public function getUnit(){
        return $this->getValue('unit');
    }

}
