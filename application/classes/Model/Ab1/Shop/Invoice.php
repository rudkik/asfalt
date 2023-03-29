<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Invoice extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_invoices';
	const TABLE_ID = 230;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'amount',
                'date',
                'number',
                'shop_client_attorney_id',
                'shop_client_contract_id',
                'date_from',
                'date_to',
                'is_delivery',
                'product_type_id',
                'is_give_to_client',
                'date_give_to_client',
                'date_received_from_client',
                'date_give_to_bookkeeping',
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
                    case 'product_type_id':
                        $this->_dbGetElement($this->getProductTypeID(), 'product_type_id', new Model_Ab1_ProductType(), $shopID);
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

        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_client_attorney_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('product_type_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldBool('is_delivery', $validation);
        $this->isValidationFieldBool('is_give_to_client', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        $arr['is_act_give_to_client'] = $this->getIsActGiveToClient();
        $arr['is_invoice_give_to_client'] = $this->getIsInvoiceGiveToClient();
        $arr['is_registry_give_to_client'] = $this->getIsRegistryGiveToClient();

        return $arr;
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientAttorneyID($value){
        $this->setValueInt('shop_client_attorney_id', $value);
        if($this->getShopClientAttorneyID() < 1){
            $this->setShopClientContractID(0);
        }
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

    public function setDateGiveToClient($value){
        $tmp = $this->getDateGiveToClient();
        $this->setValueDateTime('date_give_to_client', $value);

        if(!empty($tmp) && $tmp != $this->getDateGiveToClient()){
            $arr = $this->getOptionsValue('date_give_to_clients');
            if(!is_array($arr)){
                $arr = array();
            }
            $arr[] = $tmp;
            $this->setOptionsValue('date_give_to_clients', $arr);
        }
    }
    public function getDateGiveToClient(){
        return $this->getValueDateTime('date_give_to_client');
    }

    public function setDateReceivedFromClient($value){
        $tmp = $this->getDateReceivedFromClient();
        $this->setValueDateTime('date_received_from_client', $value);

        if(!empty($tmp) && $tmp != $this->getDateReceivedFromClient()){
            $arr = $this->getOptionsValue('date_received_from_clients');
            if(!is_array($arr)){
                $arr = array();
            }
            $arr[] = $tmp;
            $this->setOptionsValue('date_received_from_clients', $arr);
        }
    }
    public function getDateReceivedFromClient(){
        return $this->getValueDateTime('date_received_from_client');
    }

    public function setDateGiveToBookkeeping($value){
        $tmp = $this->getDateGiveToBookkeeping();
        $this->setValueDateTime('date_give_to_bookkeeping', $value);

        if(!empty($tmp) && $tmp != $this->getDateGiveToBookkeeping()){
            $arr = $this->getOptionsValue('date_give_to_bookkeepings');
            if(!is_array($arr)){
                $arr = array();
            }
            $arr[] = $tmp;
            $this->setOptionsValue('date_give_to_bookkeepings', $arr);
        }
    }
    public function getDateGiveToBookkeeping(){
        return $this->getValueDateTime('date_give_to_bookkeeping');
    }

    public function setIsActGiveToClient($value){
        $options = $this->getOptionsArray();
        $options['give_to_client']['is_act'] = Func::boolToInt($value);
        $this->setOptionsArray($options);
    }
    public function getIsActGiveToClient(){
        return intval(Arr::path($this->getOptionsArray(), 'give_to_client.is_act', 0)) == 1;
    }

    public function setIsRegistryGiveToClient($value){
        $options = $this->getOptionsArray();
        $options['give_to_client']['is_registry'] = Func::boolToInt($value);
        $this->setOptionsArray($options);
    }
    public function getIsRegistryGiveToClient(){
        return intval(Arr::path($this->getOptionsArray(), 'give_to_client.is_registry', 0)) == 1;
    }

    public function setIsInvoiceGiveToClient($value){
        $options = $this->getOptionsArray();
        $options['give_to_client']['is_invoice'] = Func::boolToInt($value);
        $this->setOptionsArray($options);
    }
    public function getIsInvoiceGiveToClient(){
        return intval(Arr::path($this->getOptionsArray(), 'give_to_client.is_invoice', 0)) == 1;
    }

    public function setIsGiveToClient($value){
        $this->setValueBool('is_give_to_client', $value);

        if($this->getIsGiveToClient()){
            $this->setDateGiveToClient(date('Y-m-d H:i:s'));
        }
    }
    public function getIsGiveToClient(){
        return $this->getValueBool('is_give_to_client');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setDateTo($value){
        $this->setValueDateTime('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }

    public function setDateFrom($value){
        $this->setValueDateTime('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setIsDelivery($value){
        $this->setValueBool('is_delivery', $value);
    }
    public function getIsDelivery(){
        return $this->getValueBool('is_delivery');
    }

    public function setProductTypeID($value){
        $this->setValueInt('product_type_id', $value);
    }
    public function getProductTypeID(){
        return $this->getValueInt('product_type_id');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
