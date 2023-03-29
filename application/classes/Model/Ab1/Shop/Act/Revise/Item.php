<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Act_Revise_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_act_revise_items';
	const TABLE_ID = 299;

	public function __construct(){
		parent::__construct(
			array(
                'date',
                'amount',
                'act_revise_type_id',
                'shop_client_id',
                'shop_act_revise_id',
                'is_receive',
                'is_cache',
                'shop_client_balance_day_id',
                'shop_client_contract_id',
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
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
                case 'act_revise_type_id':
                    $this->_dbGetElement($this->getActReviseTypeID(), 'act_revise_type_id', new Model_Ab1_ActReviseType(), $shopID);
                    break;
                case 'shop_client_balance_day_id':
                    $this->_dbGetElement($this->getShopClientBalanceDayID(), 'shop_client_balance_day_id', new Model_Ab1_Shop_Client_Balance_Day(), $shopID);
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
        $this->isValidationFieldStr('act_revise_type_id', $validation);
        $this->isValidationFieldInt('shop_act_revise_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldBool('is_receive', $validation);
        $this->isValidationFieldBool('is_cache', $validation);
        $this->isValidationFieldInt('shop_client_balance_day_id', $validation);
        $this->isValidationFieldInt('shop_client_client_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopActReviseID($value){
        $this->setValueInt('shop_act_revise_id', $value);
    }
    public function getShopActReviseID(){
        return $this->getValueInt('shop_act_revise_id');
    }

    public function setActReviseTypeID($value){
        $this->setValue('act_revise_type_id', $value);
    }
    public function getActReviseTypeID(){
        return $this->getValue('act_revise_type_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setIsReceive($value){
        $this->setValueBool('is_receive', $value);
    }
    public function getIsReceive(){
        return $this->getValueBool('is_receive');
    }

    public function setIsCache($value){
        $this->setValueBool('is_cache', $value);
    }
    public function getIsCache(){
        return $this->getValueBool('is_cache');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientBalanceDayID($value){
        $this->setValueInt('shop_client_balance_day_id', $value);
    }
    public function getShopClientBalanceDayID(){
        return $this->getValueInt('shop_client_balance_day_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }
}
