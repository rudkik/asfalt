<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Car_To_Material extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_car_to_materials';
	const TABLE_ID = 77;

	public function __construct(){
		parent::__construct(
			array(
                'shop_daughter_id',
                'shop_material_id',
                'quantity',
                'shop_driver_id',
                'shop_client_material_id',
                'weighted_operation_id',
                'tarra',
                'shop_car_tare_id',
                'quantity_invoice',
                'shop_transport_company_id',
                'is_test',
                'shop_branch_receiver_id',
                'quantity_daughter',
                'shop_branch_daughter_id',
                'update_tare_at',
                'shop_heap_daughter_id',
                'shop_heap_receiver_id',
                'shop_subdivision_daughter_id',
                'shop_subdivision_receiver_id',
                'receiver_at',
                'date_document',
                'is_weighted',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
                    case 'shop_subdivision_daughter_id':
                        $this->_dbGetElement($this->getShopSubdivisionDaughterID(), 'shop_subdivision_daughter_id', new Model_Ab1_Shop_Subdivision(), $this->getShopBranchDaughterID());
                        break;
                    case 'shop_subdivision_receiver_id':
                        $this->_dbGetElement($this->getShopSubdivisionReceiverID(), 'shop_subdivision_receiver_id', new Model_Ab1_Shop_Subdivision(), $this->getShopBranchReceiverID());
                        break;
                    case 'shop_heap_daughter_id':
                        $this->_dbGetElement($this->getShopHeapDaughterID(), 'shop_heap_daughter_id', new Model_Ab1_Shop_Heap(), $this->getShopBranchDaughterID());
                        break;
                    case 'shop_heap_receiver_id':
                        $this->_dbGetElement($this->getShopHeapReceiverID(), 'shop_heap_receiver_id', new Model_Ab1_Shop_Heap(), $this->getShopBranchReceiverID());
                        break;
                    case 'shop_subdivision_daughter_id':
                        $this->_dbGetElement($this->getShopSubdivisionDaughterID(), 'shop_subdivision_daughter_id', new Model_Ab1_Shop_Subdivision(), $this->getShopBranchDaughterID());
                        break;
                    case 'shop_subdivision_receiver_id':
                        $this->_dbGetElement($this->getShopSubdivisionReceiverID(), 'shop_subdivision_receiver_id', new Model_Ab1_Shop_Subdivision(), $this->getShopBranchReceiverID());
                        break;
                    case 'shop_branch_receiver_id':
                        $this->_dbGetElement($this->getShopBranchReceiverID(), 'shop_branch_receiver_id', new Model_Shop(), $shopID);
                        break;
                    case 'shop_branch_daughter_id':
                        $this->_dbGetElement($this->getShopBranchDaughterID(), 'shop_branch_daughter_id', new Model_Shop(), $shopID);
                        break;
					case 'shop_daughter_id':
						$this->_dbGetElement($this->getShopDaughterID(), 'shop_daughter_id', new Model_Ab1_Shop_Daughter(), $shopID);
						break;
					case 'shop_material_id':
						$this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
						break;
					case 'shop_driver_id':
						$this->_dbGetElement($this->getShopDriverID(), 'shop_driver_id', new Model_Ab1_Shop_Driver(), $shopID);
						break;
                    case 'shop_client_material_id':
                        $this->_dbGetElement($this->getShopClientMaterialID(), 'shop_client_material_id', new Model_Ab1_Shop_Client_Material(), $shopID);
                        break;
                    case 'shop_car_tare_id':
                        $this->_dbGetElement($this->getShopCarTareID(), 'shop_car_tare_id', new Model_Ab1_Shop_Car_Tare(), $shopID);
                        break;
                    case 'weighted_operation_id':
                        $this->_dbGetElement($this->getWeightedOperationID(), 'weighted_operation_id', new Model_Shop_Operation());
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
        $this->isValidationFieldInt('shop_branch_receiver_id', $validation);
        $this->isValidationFieldInt('shop_branch_daughter_id', $validation);
        $this->isValidationFieldInt('shop_daughter_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_driver_id', $validation);
        $this->isValidationFieldInt('shop_client_material_id', $validation);
        $this->isValidationFieldInt('shop_car_tare_id', $validation);
        $this->isValidationFieldInt('weighted_operation_id', $validation);
        $this->isValidationFieldInt('shop_heap_daughter_id', $validation);
        $this->isValidationFieldInt('shop_heap_receiver_id', $validation);
        $this->isValidationFieldInt('shop_subdivision_daughter_id', $validation);
        $this->isValidationFieldInt('shop_subdivision_receiver_id', $validation);

        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('quantity_invoice', $validation);
        $this->isValidationFieldFloat('quantity_daughter', $validation);
        $this->isValidationFieldBool('is_weighted', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setCreatedAt($value)
    {
        parent::setCreatedAt($value);

        if(strtotime($this->getCreatedAt(), 0) > strtotime($this->getDateDocument())){
            $this->setDateDocument($this->getCreatedAt());
        }
    }

    public function setIsWeighted($value){
        $this->setValueBool('is_weighted', $value);
    }
    public function getIsWeighted(){
        return $this->getValueBool('is_weighted');
    }

    public function setIsTest($value){
        $this->setValueBool('is_test', $value);
    }
    public function getIsTest(){
        return $this->getValueBool('is_test');
    }

    public function setShopBranchReceiverID($value){
        $this->setValueInt('shop_branch_receiver_id', $value);
    }
    public function getShopBranchReceiverID(){
        return $this->getValueInt('shop_branch_receiver_id');
    }

    public function setShopBranchDaughterID($value){
        $this->setValueInt('shop_branch_daughter_id', $value);
    }
    public function getShopBranchDaughterID(){
        return $this->getValueInt('shop_branch_daughter_id');
    }

    public function setShopTransportCompanyID($value){
        $this->setValueInt('shop_transport_company_id', $value);
    }
    public function getShopTransportCompanyID(){
        return $this->getValueInt('shop_transport_company_id');
    }

    public function setDateDocument($value){
        $this->setValueDateTime('date_document', $value);
    }
    public function getDateDocument(){
        return $this->getValueDateTime('date_document');
    }

    public function setUpdateTareAt($value){
        $this->setValueDateTime('update_tare_at', $value);

        if($this->getUpdateTareAt() != null && strtotime($this->getUpdateTareAt(), 0) > strtotime($this->getDateDocument())){
            $this->setDateDocument($this->getUpdateTareAt());
        }
    }
    public function getUpdateTareAt(){
        return $this->getValueDateTime('update_tare_at');
    }

    public function setReceiverAt($value){
        $this->setValueDateTime('receiver_at', $value);

        if($this->getReceiverAt() != null && strtotime($this->getReceiverAt()) > strtotime($this->getDateDocument())){
            $this->setDateDocument($this->getReceiverAt());
        }
    }
    public function getReceiverAt(){
        return $this->getValueDateTime('receiver_at');
    }

    public function setTare($value){
        $this->setValueFloat('tarra', $value);
    }
    public function getTare(){
        return $this->getValueFloat('tarra');
    }

    public function setShopDaughterID($value){
        $this->setValueInt('shop_daughter_id', $value);
    }
    public function getShopDaughterID(){
        return $this->getValueInt('shop_daughter_id');
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

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);

        if((Func::_empty($this->getReceiverAt())) && ($this->getQuantity() > 0.001)){
            $this->setReceiverAt(date('Y-m-d H:i:s'));
        }elseif($this->getQuantity() < 0.001){
            $this->setReceiverAt(NULL);
        }
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setQuantityInvoice($value){
        $this->setValueFloat('quantity_invoice', $value);
    }
    public function getQuantityInvoice(){
        return $this->getValueFloat('quantity_invoice');
    }
    public function getQuantityFact(){
        if($this->getQuantityInvoice() > 0.0001){
            $quantity = $this->getQuantityInvoice();
        }else{
            $quantity = $this->getQuantityDaughter();
        }

        return $quantity;
    }

    public function setQuantityDaughter($value){
        $this->setValueFloat('quantity_daughter', $value);
    }
    public function getQuantityDaughter(){
        return $this->getValueFloat('quantity_daughter');
    }

    public function setShopDriverID($value){
        $this->setValueInt('shop_driver_id', $value);
    }
    public function getShopDriverID(){
        return $this->getValueInt('shop_driver_id');
    }

    public function setShopClientMaterialID($value){
        $this->setValueInt('shop_client_material_id', $value);
    }
    public function getShopClientMaterialID(){
        return $this->getValueInt('shop_client_material_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setWeightedOperationID($value){
        $this->setValueInt('weighted_operation_id', $value);
    }
    public function getWeightedOperationID(){
        return $this->getValueInt('weighted_operation_id');
    }

    public function setShopHeapDaughterID($value){
        $this->setValueInt('shop_heap_daughter_id', $value);
    }
    public function getShopHeapDaughterID(){
        return $this->getValueInt('shop_heap_daughter_id');
    }

    public function setShopHeapReceiverID($value){
        $this->setValueInt('shop_heap_receiver_id', $value);
    }
    public function getShopHeapReceiverID(){
        return $this->getValueInt('shop_heap_receiver_id');
    }

    public function setShopSubdivisionDaughterID($value){
        $this->setValueInt('shop_subdivision_daughter_id', $value);
    }
    public function getShopSubdivisionDaughterID(){
        return $this->getValueInt('shop_subdivision_daughter_id');
    }

    public function setShopSubdivisionReceiverID($value){
        $this->setValueInt('shop_subdivision_receiver_id', $value);
    }
    public function getShopSubdivisionReceiverID(){
        return $this->getValueInt('shop_subdivision_receiver_id');
    }
}
