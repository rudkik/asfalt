<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Attorney extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_attorneys';
	const TABLE_ID = 94;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_client_id',
                'amount',
                'block_quantity',
                'balance',
                'shop_client_contract_id',
                'delivery_amount',
                'block_delivery_amount',
                'balance_delivery',
                'attorney_update_user_id',
                'attorney_updated_at',
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
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'attorney_update_user_id':
                    $this->_dbGetElement($this->getAttorneyUpdateUserID(), 'attorney_update_user_id', new Model_User(), 0);
                    break;
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
                case 'shop_client_contract_id':
                    $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                    break;
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
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('block_amount', $validation);
        $this->isValidationFieldFloat('balance', $validation);
        $this->isValidationFieldInt('attorney_update_user_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldFloat('delivery_amount', $validation);
        $this->isValidationFieldFloat('block_delivery_amount', $validation);
        $this->isValidationFieldFloat('balance_delivery', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);
        return $arr;
    }

    public function setAttorneyUpdateUserID($value){
        $this->setValueInt('attorney_update_user_id', $value);
    }
    public function getAttorneyUpdateUserID(){
        return $this->getValueInt('attorney_update_user_id');
    }

    public function setClientName($value){
        $this->setValue('client_name', $value);
    }
    public function getClientName(){
        return $this->getValue('client_name');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setNameWeight($value){
        $this->setValue('name_weight', $value);
    }
    public function getNameWeight(){
        return $this->getValue('name_weight');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setAmount1C($value){
        $this->setValueFloat('amount_1c', $value);
        $this->setBalance($this->getAmount1C() + $this->getAmount() - $this->getBlockAmount() - $this->getBlockDeliveryAmount());
    }
    public function getAmount1C(){
        return $this->getValueFloat('amount_1c');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
        $this->setBalance($this->getAmount1C() + $this->getAmount() - $this->getBlockAmount() - $this->getBlockDeliveryAmount());
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', $value);
        $this->setBalance($this->getAmount1C() + $this->getAmount() - $this->getBlockAmount() - $this->getBlockDeliveryAmount());
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setDeliveryAmount($value){
        $this->setValueFloat('delivery_amount', $value);
        $this->setBalanceDelivery($this->getDeliveryAmount() - $this->getBlockDeliveryAmount());
    }
    public function getDeliveryAmount(){
        return $this->getValueFloat('delivery_amount');
    }

    public function setBlockDeliveryAmount($value){
        $this->setValueFloat('block_delivery_amount', $value);
        $this->setBalanceDelivery($this->getDeliveryAmount() - $this->getBlockDeliveryAmount());
        $this->setBalance($this->getAmount1C() + $this->getAmount() - $this->getBlockAmount() - $this->getBlockDeliveryAmount());
    }
    public function getBlockDeliveryAmount(){
        return $this->getValueFloat('block_delivery_amount');
    }

	public function setFromAt($value){
		$this->setValueDateTime('from_at', $value);
	}
	public function getFromAt(){
		return $this->getValueDateTime('from_at');
	}

	public function setToAt($value){
		$this->setValueDateTime('to_at', $value);
	}
	public function getToAt(){
		return $this->getValueDateTime('to_at');
	}

    public function setBalance($value){
        $this->setValueFloat('balance', $value);
    }
    public function getBalance(){
        return $this->getValueFloat('balance');
    }

    public function setBalanceDelivery($value){
        $this->setValueFloat('balance_delivery', $value);
    }
    public function getBalanceDelivery(){
        return $this->getValueFloat('balance_delivery');
    }

    // Дата обновления записи
    public function setAttorneyUpdatedAt($value)
    {
        $this->setValue('attorney_updated_at', $value);
    }

    public function getAttorneyUpdatedAt()
    {
        return $this->getValue('attorney_updated_at');
    }
}
