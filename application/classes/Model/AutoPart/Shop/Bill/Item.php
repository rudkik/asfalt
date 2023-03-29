<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Bill_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_bill_items';
	const TABLE_ID = 71;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_product_storage_id'
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
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_AutoPart_Shop_Product());
						break;
                    case 'shop_bill_id':
                        $this->_dbGetElement($this->getShopBillID(), 'shop_bill_id', new Model_AutoPart_Shop_Bill());
                        break;
                    case 'shop_product_storage_id':
                        $this->_dbGetElement($this->getShopProductStorageID(), 'shop_product_storage_id', new Model_AutoPart_Shop_Product_Storage());
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
        $validation->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('quantity', 'max_length', array(':value', 12))
			->rule('price', 'max_length', array(':value', 12))
			->rule('amount', 'max_length', array(':value', 12))
            ->rule('shop_bill_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('shop_product_id')) {
            $validation->rule('shop_product_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_bill_id')) {
            $validation->rule('shop_bill_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_product_storage_id')) {
            $validation->rule('shop_product_storage_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }
    public function setShopProductStorageID($value){
        $this->setValueInt('shop_product_storage_id', $value);
    }
    public function getShopProductStorageID(){
        return $this->getValueInt('shop_product_storage_id');
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
        $this->setAmountCost($this->getQuantity() * $this->getPriceCost());
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

    public function setPriceCost($value){
        $this->setValueFloat('price_cost', $value);
        $this->setAmountCost($this->getQuantity() * $this->getPriceCost());
    }
    public function getPriceCost(){
        return $this->getValueFloat('price_cost');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', round($value, 0));
        $this->calcProfit();
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setAmountCost($value){
        $this->setValueFloat('amount_cost', round($value, 0));
        $this->calcProfit();
    }
    public function getAmountCost(){
        return $this->getValueFloat('amount_cost');
    }

    public function setShopBillID($value){
        $this->setValueInt('shop_bill_id', $value);
    }
    public function getShopBillID(){
        return $this->getValueInt('shop_bill_id');
    }

    public function setDeliveryAmount($value){
        $this->setValueFloat('delivery_amount', $value);
        $this->calcProfit();
    }
    public function getDeliveryAmount(){
        return $this->getValueFloat('delivery_amount');
    }

    public function setShopSourceID($value){
        $this->setValue('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValue('shop_source_id');
    }

    public function setShopReceiveID($value){
        $this->setValue('shop_receive_id', $value);
    }
    public function getShopReceiveID(){
        return $this->getValue('shop_receive_id');
    }

    public function setShopCourierID($value){
        $this->setValueInt('shop_courier_id', $value);
    }
    public function getShopCourierID(){
        return $this->getValueInt('shop_courier_id');
    }

    public function setShopCompanyID($value){
        $this->setValue('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValue('shop_company_id');
    }

    public function setShopBillItemStatusID($value){
        $this->setValueInt('shop_bill_item_status_id', $value);
        $this->setBillItemStatusAt(date('Y-m-d H:i:s'));
    }
    public function getShopBillItemStatusID(){
        return $this->getValueInt('shop_bill_item_status_id');
    }

    public function setShopSupplierAddressID($value){
        $this->setValueInt('shop_supplier_address_id', $value);
    }
    public function getShopSupplierAddressID(){
        return $this->getValueInt('shop_supplier_address_id');
    }

    public function setBillItemStatusAt($value){
        $this->setValueDateTime('bill_item_status_at', $value);
    }
    public function getBillItemStatusAt(){
        return $this->getValueDateTime('bill_item_status_at');
    }

    public function setProfit($value){
        $this->setValueFloat('profit', round($value, 0));
    }
    public function getProfit(){
        return $this->getValueFloat('profit');
    }

    public function setCommissionSupplier($value){
        $this->setValueFloat('commission_supplier', round($value, 0));
        $this->calcProfit();
    }
    public function getCommissionSupplier(){
        return $this->getValueFloat('commission_supplier');
    }

    public function setCommissionSource($value){
        $this->setValueFloat('commission_source', round($value, 0));
        $this->calcProfit();
    }
    public function getCommissionSource(){
        return $this->getValueFloat('commission_source');
    }

    public function setCommissionSourcePayment($value){
        $this->setValueFloat('commission_source_payment', $value);
        $this->setCommissionSource($this->getCommissionSourcePayment() + $this->getCommissionSourceService());
    }
    public function getCommissionSourcePayment(){
        return $this->getValueFloat('commission_source_payment');
    }

    public function setCommissionSourceService($value){
        $this->setValueFloat('commission_source_service', $value);
        $this->setCommissionSource($this->getCommissionSourcePayment() + $this->getCommissionSourceService());
    }
    public function getCommissionSourceService(){
        return $this->getValueFloat('commission_source_service');
    }

    public function calcProfit($isAll = false){
        if($isAll){
            $this->setQuantity($this->getQuantity());
        }

        $this->setProfit(
            $this->getAmount()
            - $this->getAmount() / 100 * $this->getCommissionSource()
            - $this->getAmountCost()
            - $this->getAmountCost() / 100 * $this->getCommissionSupplier()
            - $this->getDeliveryAmount()
        );
    }

    public function setBankDate($value){
        $this->setValueDate('bank_date', $value);
    }
    public function getBankDate(){
        return $this->getValueDate('bank_date');
    }

    public function setShopBankAccountID($value){
        $this->setValueInt('shop_bank_account_id', $value);
    }
    public function getShopBankAccountID(){
        return $this->getValueInt('shop_bank_account_id');
    }

    public function setBarcode($value){
        $this->setValue('barcode', $value);
    }
    public function getBarcode(){
        return $this->getValue('barcode');
    }

    public function setShopPreOrderID($value){
        $this->setValueInt('shop_pre_order_id', $value);
    }
    public function getShopPreOrderID(){
        return $this->getValueInt('shop_pre_order_id');
    }

    public function setIsBuy($value){
        $this->setValueBool('is_buy', $value);

        if($this->getIsBuy()){
            if(Func::_empty($this->getBuyAt())) {
                $this->setBuyAt(Helpers_DateTime::getCurrentDateTimePHP());
            }
        }else{
            $this->setBuyAt(null);
        }
    }
    public function getIsBuy(){
        return $this->getValueBool('is_buy');
    }

    public function setNewShopCourierID($value){
        $this->setValueInt('new_shop_courier_id', $value);
    }
    public function getNewShopCourierID(){
        return $this->getValueInt('new_shop_courier_id');
    }

    public function setBuyAt($value){
        $this->setValueDateTime('buy_at', $value);
    }
    public function getBuyAt(){
        return $this->getValueDateTime('buy_at');
    }
}
