<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Move_Empty extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_move_empties';
	const TABLE_ID = 419;

	public function __construct(){
		parent::__construct(
			array(
                'quantity',
                'shop_driver_id',
                'weighted_exit_operation_id',
                'tarra',
                'shop_transport_company_id',
                'is_test',
                'shop_move_place_id',
                'shop_car_tare_id',
                'shop_transport_id'
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_driver_id':
						$this->_dbGetElement($this->getShopDriverID(), 'shop_driver_id', new Model_Ab1_Shop_Driver(), $shopID);
						break;
                    case 'weighted_exit_operation_id':
                        $this->_dbGetElement($this->getWeightedExitOperationID(), 'weighted_exit_operation_id', new Model_Shop_Operation());
                        break;
                    case 'shop_transport_company_id':
                        $this->_dbGetElement($this->getShopTransportCompanyID(), 'shop_transport_company_id', new Model_Ab1_Shop_Transport_Company(), $shopID);
                        break;
                    case 'shop_move_place_id':
                        $this->_dbGetElement($this->getShopMovePlaceID(), 'shop_move_place_id', new Model_Ab1_Shop_Move_Place(), $shopID);
                        break;
                    case 'shop_car_tare_id':
                        $this->_dbGetElement($this->getShopCarTareID(), 'shop_car_tare_id', new Model_Ab1_Shop_Car_Tare(), $shopID);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), $shopID);
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
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
        $this->isValidationFieldInt('shop_driver_id', $validation);
        $this->isValidationFieldInt('weighted_exit_operation_id', $validation);
        $this->isValidationFieldFloat('tarra', $validation);
        $this->isValidationFieldInt('shop_transport_company_id', $validation);
        $this->isValidationFieldBool('is_test', $validation);
        $this->isValidationFieldInt('shop_move_place_id', $validation);
        $this->isValidationFieldInt('shop_car_tare_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setShopDriverID($value){
        $this->setValueInt('shop_driver_id', $value);
    }
    public function getShopDriverID(){
        return $this->getValueInt('shop_driver_id');
    }

    public function setWeightedExitOperationID($value){
        $this->setValueInt('weighted_exit_operation_id', $value);
    }
    public function getWeightedExitOperationID(){
        return $this->getValueInt('weighted_exit_operation_id');
    }

    public function setWeightedExitAt($value){
        $this->setValueDateTime('weighted_exit_at', $value);
    }
    public function getWeightedExitAt(){
        return $this->getValue('weighted_exit_at');
    }

    public function setTarra($value){
        $this->setValueFloat('tarra', $value);
    }
    public function getTarra(){
        return $this->getValueFloat('tarra');
    }

    public function setShopTransportCompanyID($value){
        $this->setValueInt('shop_transport_company_id', $value);
    }
    public function getShopTransportCompanyID(){
        return $this->getValueInt('shop_transport_company_id');
    }

    public function setIsTest($value){
        $this->setValueBool('is_test', $value);
    }
    public function getIsTest(){
        return $this->getValueBool('is_test');
    }

    public function setShopMovePlaceID($value){
        $this->setValueInt('shop_move_place_id', $value);
    }
    public function getShopMovePlaceID(){
        return $this->getValueInt('shop_move_place_id');
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
}
