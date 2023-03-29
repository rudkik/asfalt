<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_Storage extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_product_storages';
	const TABLE_ID = 273;

	public function __construct(){
		parent::__construct(
			array(
                'shop_product_id',
                'quantity',
                'asu_operation_id',
                'tarra',
                'shop_storage_id',
                'weighted_operation_id',
                'weighted_at',
                'shop_turn_place_id',
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
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
                        break;
                    case 'asu_operation_id':
                        $this->_dbGetElement($this->getAsuOperationID(), 'asu_operation_id', new Model_Shop_Operation());
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopDriverID(), 'shop_storage_id', new Model_Ab1_Shop_Storage(), $shopID);
                        break;
                    case 'weighted_operation_id':
                        $this->_dbGetElement($this->getWeightedOperationID(), 'weighted_operation_id', new Model_Shop_Operation());
                        break;
                    case 'shop_turn_place_id':
                        $this->_dbGetElement($this->getShopTurnPlaceID(), 'shop_turn_place_id', new Model_Ab1_Shop_Turn_Place());
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

        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('asu_operation_id', $validation);
        $this->isValidationFieldFloat('tarra', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('weighted_operation_id', $validation);
        $this->isValidationFieldInt('shop_turn_place_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setWeightedAt($value){
        $this->setValueDateTime('weighted_at', $value);
    }
    public function getWeightedAt(){
        return $this->getValue('weighted_at');
    }

    public function setWeightedOperationID($value){
        $this->setValueInt('weighted_operation_id', $value);
    }
    public function getWeightedOperationID(){
        return $this->getValueInt('weighted_operation_id');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setAsuOperationID($value){
        $this->setValueInt('asu_operation_id', $value);
    }
    public function getAsuOperationID(){
        return $this->getValueInt('asu_operation_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setTarra($value){
        $this->setValueFloat('tarra', $value);
    }
    public function getTarra(){
        return $this->getValueFloat('tarra');
    }

    public function setShopTurnPlaceID($value){
        $this->setValueInt('shop_turn_place_id', $value);
    }
    public function getShopTurnPlaceID(){
        return $this->getValueInt('shop_turn_place_id');
    }

    public function setShopCarTareID($value){
        $this->setValueInt('shop_car_tare_id', $value);
    }
    public function getShopCarTareID(){
        return $this->getValueInt('shop_car_tare_id');
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }

    public function setShopTransportWaybillID($value){
        $this->setValueInt('shop_transport_waybill_id', $value);
    }
    public function getShopTransportWaybillID(){
        return $this->getValueInt('shop_transport_waybill_id');
    }
}
