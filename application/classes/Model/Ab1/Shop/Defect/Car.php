<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Defect_Car extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_defect_cars';
	const TABLE_ID = 0;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'shop_storage_id',
                'shop_subdivision_id',
                'shop_heap_id',
                'shop_formula_product_id',
                'is_delivery',
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
                    case 'shop_formula_product_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_formula_product_id', new Model_Ab1_Shop_Formula_Product());
                        break;
                    case 'shop_head_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_head_id', new Model_Ab1_Shop_Heap());
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisionID(), 'shop_subdivision_id', new Model_Ab1_Shop_Subdivision(), $shopID);
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
                        break;
					case 'shop_client_id':
						$this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
						break;
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
						break;
					case 'shop_driver_id':
						$this->_dbGetElement($this->getShopDriverID(), 'shop_driver_id', new Model_Ab1_Shop_Driver(), $shopID);
						break;
                    case 'shop_turn_id':
                        $this->_dbGetElement($this->getShopTurnID(), 'shop_turn_id', new Model_Ab1_Shop_Turn(), $shopID);
                        break;
                    case 'weighted_exit_operation_id':
                        $this->_dbGetElement($this->getWeightedExitOperationID(), 'weighted_exit_operation_id', new Model_Shop_Operation());
                        break;
                    case 'asu_operation_id':
                        $this->_dbGetElement($this->getAsuOperationID(), 'asu_operation_id', new Model_Shop_Operation());
                        break;
                    case 'weighted_entry_operation_id':
                        $this->_dbGetElement($this->getWeightedEntryOperationID(), 'weighted_entry_operation_id', new Model_Shop_Operation());
                        break;
                    case 'cash_operation_id':
                        $this->_dbGetElement($this->getCashOperationID(), 'cash_operation_id', new Model_Shop_Operation());
                        break;
                    case 'shop_turn_place_id':
                        $this->_dbGetElement($this->getShopTurnPlaceID(), 'shop_turn_place_id', new Model_Ab1_Shop_Turn_Place());
                        break;
                    case 'shop_transport_company_id':
                        $this->_dbGetElement($this->getShopTransportCompanyID(), 'shop_transport_company_id', new Model_Ab1_Shop_Transport_Company(), $shopID);
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
        $validation->rule('shop_client_id', 'max_length', array(':value', 11))
			->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('shop_driver_id', 'max_length', array(':value', 11))
			->rule('quantity', 'max_length', array(':value', 12))
            ->rule('is_debt', 'max_length', array(':value', 1))
			->rule('is_exit', 'max_length', array(':value', 1))
            ->rule('shop_turn_id', 'max_length', array(':value', 11))
            ->rule('asu_operation_id', 'max_length', array(':value', 11));

        $this->isValidationFieldInt('shop_subdivision_id', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);
        $this->isValidationFieldInt('shop_formula_product_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }


    /**
     * изменяет значение по именя
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value) {
        if ($name == 'name') {
            $value = mb_strtoupper($value);
        }

        parent::setValue($name, $value);
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setIsDelivery($value){
        $this->setValueBool('is_delivery', $value);
    }
    public function getIsDelivery(){
        return $this->getValueBool('is_delivery');
    }

    public function setShopHeapID($value){
        $this->setValueInt('shop_heap_id', $value);
    }
    public function getShopHeapID(){
        return $this->getValueInt('shop_heap_id');
    }

    public function setShopFormulaProductID($value){
        $this->setValueInt('shop_formula_product_id', $value);
    }
    public function getShopFormulaProductID(){
        return $this->getValueInt('shop_formula_product_id');
    }

    public function setIsTest($value){
        $this->setValueBool('is_test', $value);
    }
    public function getIsTest(){
        return $this->getValueBool('is_test');
    }

    public function setPackedCount($value){
        $this->setValueFloat('packed_count', $value);
    }
    public function getPackedCount(){
        return $this->getValueFloat('packed_count');
    }

    public function setShopTransportCompanyID($value){
        $this->setValueInt('shop_transport_company_id', $value);
    }
    public function getShopTransportCompanyID(){
        return $this->getValueInt('shop_transport_company_id');
    }

    public function setPackedQuantity($value){
        $this->setValueFloat('packed_quantity', $value);
    }
    public function getPackedQuantity(){
        return $this->getValueFloat('packed_quantity');
    }

    public function setWeightedEntryAt($value){
        $this->setValueDateTime('weighted_entry_at', $value);
    }
    public function getWeightedEntryAt(){
        return $this->getValue('weighted_entry_at');
    }

    public function setWeightedEntryOperationID($value){
        $this->setValueInt('weighted_entry_operation_id', $value);
    }
    public function getWeightedEntryOperationID(){
        return $this->getValueInt('weighted_entry_operation_id');
    }

    public function setCashOperationID($value){
        $this->setValueInt('cash_operation_id', $value);
    }
    public function getCashOperationID(){
        return $this->getValueInt('cash_operation_id');
    }

    public function setWeightedExitAt($value){
        $this->setValueDateTime('weighted_exit_at', $value);
    }
    public function getWeightedExitAt(){
        return $this->getValue('weighted_exit_at');
    }

    public function setWeightedExitOperationID($value){
        $this->setValueInt('weighted_exit_operation_id', $value);
    }
    public function getWeightedExitOperationID(){
        return $this->getValueInt('weighted_exit_operation_id');
    }

    public function setAsuAt($value){
        $this->setValueDateTime('asu_at', $value);
    }
    public function getAsuAt(){
        return $this->getValue('asu_at');
    }

    public function setAsuOperationID($value){
        $this->setValueInt('asu_operation_id', $value);
    }
    public function getAsuOperationID(){
        return $this->getValueInt('asu_operation_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
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

    public function setBrutto($value){
        $this->setValueFloat('brutto', $value);
    }
    public function getBrutto(){
        return $this->getValueFloat('brutto');
    }

    public function setShopDriverID($value){
        $this->setValueInt('shop_driver_id', $value);
    }
    public function getShopDriverID(){
        return $this->getValueInt('shop_driver_id');
    }

    public function setIsDebt($value){
        $this->setValueBool('is_debt', $value);
    }
    public function getIsDebt(){
        return true || $this->getValueBool('is_debt');
    }

    public function setExitAt($value){
        $this->setValueDateTime('exit_at', $value);
    }
    public function getExitAt(){
        return $this->getValue('exit_at');
    }

    public function setArrivalAt($value){
        $this->setValueDateTime('arrival_at', $value);
    }
    public function getArrivalAt(){
        return $this->getValue('arrival_at');
    }

    public function setIsExit($value){
        $this->setValueBool('is_exit', $value);

        if($this->getIsExit()){
            if(empty($this->getExitAt())){
                $this->setExitAt(date('Y-m-d H:i:s'));
            }
        }else{
            $this->setExitAt(NULL);
        }
    }
    public function getIsExit(){
        return $this->getValueBool('is_exit');
    }

    public function setShopTurnID($value){
        $this->setValueInt('shop_turn_id', $value);
    }
    public function getShopTurnID(){
        return $this->getValueInt('shop_turn_id');
    }

    public function setShopTurnPlaceID($value){
        $this->setValueInt('shop_turn_place_id', $value);
    }
    public function getShopTurnPlaceID(){
        return $this->getValueInt('shop_turn_place_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
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
