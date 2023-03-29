<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Piece extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_pieces';
	const TABLE_ID = 95;

	public function __construct(){
		parent::__construct(
			array(
                'root_id',
                'delivery_quantity',
                'shop_client_contract_id',
                'is_charity',
                'is_one_attorney',
                'is_invoice',
                'delivery_shop_client_contract_id',
                'delivery_shop_client_attorney_id',
                'amount_service',
                'quantity_service',
                'shop_head_id',
                'shop_formula_product_id',
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
                    case 'shop_formula_product_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_formula_product_id', new Model_Ab1_Shop_Formula_Product());
                        break;
                    case 'shop_head_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_head_id', new Model_Ab1_Shop_Heap());
                        break;
                    case 'shop_delivery_id':
                        $this->_dbGetElement($this->getShopDeliveryID(), 'shop_delivery_id', new Model_Ab1_Shop_Delivery());
                        break;
                    case 'shop_client_attorney_id':
                        $this->_dbGetElement($this->getShopClientAttorneyID(), 'shop_client_attorney_id', new Model_Ab1_Shop_Client_Attorney(), $shopID);
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_driver_id':
                        $this->_dbGetElement($this->getShopDriverID(), 'shop_driver_id', new Model_Ab1_Shop_Driver(), $shopID);
                        break;
                    case 'shop_payment_id':
                        $this->_dbGetElement($this->getShopPaymentID(), 'shop_payment_id', new Model_Ab1_Shop_Payment());
                        break;
                    case 'shop_transport_company_id':
                        $this->_dbGetElement($this->getShopTransportCompanyID(), 'shop_transport_company_id', new Model_Ab1_Shop_Transport_Company(), $shopID);
                        break;
                    case 'cash_operation_id':
                        $this->_dbGetElement($this->getCashOperationtID(), 'cash_operation_id', new Model_Shop_Operation());
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
            ->rule('shop_driver_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('is_debt', 'max_length', array(':value', 1))
            ->rule('number', 'max_length', array(':value', 250));
        $this->isValidationFieldInt('shop_client_attorney_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('root_id', $validation);
        $this->isValidationFieldFloat('delivery_quantity', $validation);
        $this->isValidationFieldBool('is_charity', $validation);
        $this->isValidationFieldBool('is_one_attorney', $validation);
        $this->isValidationFieldBool('is_invoice', $validation);
        $this->isValidationFieldInt('delivery_shop_client_attorney_id', $validation);
        $this->isValidationFieldInt('delivery_shop_client_contract_id', $validation);
        $this->isValidationFieldFloat('amount_service', $validation);
        $this->isValidationFieldFloat('quantity_service', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);
        $this->isValidationFieldInt('shop_formula_product_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsInvoice($value){
        $this->setValueBool('is_invoice', $value);
    }
    public function getIsInvoice(){
        return $this->getValueBool('is_invoice');
    }

    /**
     * изменяет значение по именя
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value) {
        parent::setValue($name, $value);

        if ($name == 'quantity'){
            $this->setDeliveryQuantity($this->getQuantity());
        }elseif ($name == 'shop_delivery_id'){
            $this->setIsDelivery($this->getShopDeliveryID() > 0);
        }
    }

    public function setIsCharity($value){
        $this->setValueBool('is_charity', $value);
    }
    public function getIsCharity(){
        return $this->getValueBool('is_charity');
    }

    public function setRootID($value){
        $this->setValueInt('root_id', $value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }

    public function setShopDeliveryID($value){
        $this->setValueInt('shop_delivery_id', $value);
        $this->setIsDelivery($this->getShopDeliveryID() > 0);
    }
    public function getShopDeliveryID(){
        return $this->getValueInt('shop_delivery_id');
    }
    public function setIsDelivery($value){
        $this->setValueBool('is_delivery', $value);
        if(!$this->getIsDelivery()){
            $this->setDeliveryAmount(0);
            $this->setDeliveryKM(0);
            $this->setDeliveryQuantity(0);
            if($this->getShopDeliveryID() != 0){
                $this->setShopDeliveryID(0);
            }
        }
    }
    public function getIsDelivery(){
        return $this->getValueBool('is_delivery');
    }
    public function setDeliveryAmount($value){
        $this->setValueFloat('delivery_amount', $value);
    }
    public function getDeliveryAmount(){
        return $this->getValueFloat('delivery_amount');
    }
    public function setDeliveryKM($value){
        $this->setValueFloat('delivery_km', $value);
    }
    public function getDeliveryKM(){
        return $this->getValueFloat('delivery_km');
    }
    // вес доставки может отличаться от веса заказа, может быть заказ разбит на несколько строчек
    private function setDeliveryQuantity($value){
        $this->setValueFloat('delivery_quantity', $value);
    }
    public function getDeliveryQuantity(){
        return $this->getValueFloat('delivery_quantity');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);

        $this->setDeliveryQuantity($this->getQuantity());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setCashOperationID($value){
        $this->setValueInt('cash_operation_id', $value);
    }
    public function getCashOperationID(){
        return $this->getValueInt('cash_operation_id');
    }

    public function setIsBalance($value){
        $this->setValueBool('is_balance', $value);
    }
    public function getIsBalance(){
        return $this->getValueBool('is_balance');
    }

    public function setShopTransportCompanyID($value){
        $this->setValueInt('shop_transport_company_id', $value);
    }
    public function getShopTransportCompanyID(){
        return $this->getValueInt('shop_transport_company_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientAttorneyID($value){
        $this->setValueInt('shop_client_attorney_id', $value);
    }
    public function getShopClientAttorneyID(){
        return $this->getValueInt('shop_client_attorney_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopDriverID($value){
        $this->setValueInt('shop_driver_id', $value);
    }
    public function getShopDriverID(){
        return $this->getValueInt('shop_driver_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setIsDebt($value){
        $this->setValueBool('is_debt', $value);
    }
    public function getIsDebt(){
        return $this->getValueBool('is_debt');
    }

    public function setShopPaymentID($value){
        $this->setValueInt('shop_payment_id', $value);
    }
    public function getShopPaymentID(){
        return $this->getValueInt('shop_payment_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setIsOneAttorney($value){
        $this->setValueBool('is_one_attorney', $value);
    }
    public function getIsOneAttorney(){
        return $this->getValueBool('is_one_attorney');
    }

    public function setDeliveryShopClientAttorneyID($value){
        $this->setValueInt('delivery_shop_client_attorney_id', $value);
    }
    public function getDeliveryShopClientAttorneyID(){
        return $this->getValueInt('delivery_shop_client_attorney_id');
    }

    public function setDeliveryShopClientContractID($value){
        $this->setValueInt('delivery_shop_client_contract_id', $value);
    }
    public function getDeliveryShopClientContractID(){
        return $this->getValueInt('delivery_shop_client_contract_id');
    }

    public function setAmountService($value){
        $this->setValueFloat('amount_service', $value);
    }
    public function getAmountService(){
        return $this->getValueFloat('amount_service');
    }

    public function setQuantityService($value){
        $this->setValueFloat('quantity_service', $value);
    }
    public function getQuantityService(){
        return $this->getValueFloat('quantity_service');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
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

    public function setShopActServiceID($value){
        $this->setValueInt('shop_act_service_id', $value);
    }
    public function getShopActServiceID(){
        return $this->getValueInt('shop_act_service_id');
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
