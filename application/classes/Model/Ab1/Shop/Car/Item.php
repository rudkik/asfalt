<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Car_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_car_items';
	const TABLE_ID = 229;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_client_id',
                'shop_client_contract_id',
                'shop_client_attorney_id',
                'is_charity',
                'shop_client_contract_item_id',
                'shop_product_price_id',
                'shop_invoice_id',
                'shop_storage_id',
                'shop_subdivision_id',
                'shop_heap_id',
                'shop_formula_product_id',
                'shop_product_time_price_id',
                'shop_client_balance_day_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements !== NULL) && (! is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_formula_product_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_formula_product_id', new Model_Ab1_Shop_Formula_Product());
                        break;
                    case 'shop_head_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_head_id', new Model_Ab1_Shop_Heap());
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisionID(), 'shop_subdivision_id', new Model_Ab1_Shop_Subdivision());
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
                        break;
                    case 'shop_car_id':
                        $this->_dbGetElement($this->getShopCarID(), 'shop_car_id', new Model_Ab1_Shop_Car());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                        break;
                    case 'shop_client_attorney_id':
                        $this->_dbGetElement($this->getShopClientAttorneyID(), 'shop_client_attorney_id', new Model_Ab1_Shop_Client_Attorney(), $shopID);
                        break;
                    case 'shop_product_time_price_id':
                        $this->_dbGetElement($this->getShopProductTimePriceID(), 'shop_product_time_price_id', new Model_Ab1_Shop_Product_Time_Price());
                        break;
                    case 'shop_client_balance_day_id':
                        $this->_dbGetElement($this->getShopClientBalanceDayID(), 'shop_client_balance_day_id', new Model_Ab1_Shop_Client_Balance_Day(), $shopID);
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
        $validation->rule('quantity', 'max_length', array(':value', 12))
			->rule('price', 'max_length', array(':value', 12))
			->rule('amount', 'max_length', array(':value', 12));

        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_car_id', $validation);
        $this->isValidationFieldInt('shop_client_attorney_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_item_id', $validation);
        $this->isValidationFieldInt('shop_product_price_id', $validation);
        $this->isValidationFieldInt('shop_product_time_price_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_invoice_id', $validation);
        $this->isValidationFieldBool('is_charity', $validation);
        $this->isValidationFieldInt('shop_subdivision_id', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);
        $this->isValidationFieldInt('shop_formula_product_id', $validation);
        $this->isValidationFieldInt('shop_client_balance_day_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * изменяет значение по именя
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value) {
        parent::setValue($name, $value);

        if ($name == 'shop_client_id'){
            if($this->getShopClientID() != $value){
                $this->setShopClientBalanceDayID(0);
            }
        }
    }

    public function setShopInvoiceID($value){
        $this->setValueInt('shop_invoice_id', $value);
    }
    public function getShopInvoiceID(){
        return $this->getValueInt('shop_invoice_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', round($value, 3));
        $this->setAmount($this->getQuantity() * $this->getPrice());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopCarID($value){
        $this->setValueInt('shop_car_id', $value);
    }
    public function getShopCarID(){
        return $this->getValueInt('shop_car_id');
    }

    public function setShopClientID($value){
        if($this->getShopClientID() != $value){
            $this->setShopClientBalanceDayID(0);
        }

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

    public function setShopClientContractItemID($value){
        $this->setValueInt('shop_client_contract_item_id', $value);
    }
    public function getShopClientContractItemID(){
        return $this->getValueInt('shop_client_contract_item_id');
    }

    public function setShopProductPriceID($value){
        $this->setValueInt('shop_product_price_id', $value);
    }
    public function getShopProductPriceID(){
        return $this->getValueInt('shop_product_price_id');
    }

    public function setShopProductTimePriceID($value){
        $this->setValueInt('shop_product_time_price_id', $value);
    }
    public function getShopProductTimePriceID(){
        return $this->getValueInt('shop_product_time_price_id');
    }

    public function setIsCharity($value){
        $this->setValueBool('is_charity', $value);
    }
    public function getIsCharity(){
        return $this->getValueBool('is_charity');
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

    public function setShopClientBalanceDayID($value){
        $this->setValueInt('shop_client_balance_day_id', $value);
    }
    public function getShopClientBalanceDayID(){
        return $this->getValueInt('shop_client_balance_day_id');
    }
}
