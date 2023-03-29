<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Act_Service extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_act_services';
	const TABLE_ID = 245;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'amount',
                'date',
                'number',
                'shop_client_contract_id',
                'shop_client_attorney_id',
                'date_from',
                'date_to',
                'act_service_paid_type_id',
                'shop_delivery_department_id',
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
                    case 'shop_delivery_department_id':
                        $this->_dbGetElement($this->getShopDeliveryDepartmentID(), 'shop_delivery_department_id', new Model_Ab1_Shop_Delivery_Department(), $shopID);
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                        break;
                    case 'shop_client_attorney_id':
                        $this->_dbGetElement($this->getShopClientAttorneyID(), 'shop_client_attorney_id', new Model_Ab1_Shop_Client_Attorney());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'act_service_paid_type_id':
                        $this->_dbGetElement($this->getActServicePaidTypeID(), 'act_service_paid_type_id', new Model_Ab1_ActServicePaidType(), $shopID);
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
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_client_attorney_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldInt('act_service_paid_type_id', $validation);
        $this->isValidationFieldInt('shop_delivery_department_id', $validation);

        return $this->_validationFields($validation, $errorFields);
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

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopDeliveryDepartmentID($value){
        $this->setValueInt('shop_delivery_department_id', $value);
    }
    public function getShopDeliveryDepartmentID(){
        return $this->getValueInt('shop_delivery_department_id');
    }

    public function setActServicePaidTypeID($value){
        $this->setValueInt('act_service_paid_type_id', $value);
    }
    public function getActServicePaidTypeID(){
        return $this->getValueInt('act_service_paid_type_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopClientAttorneyID($value){
        $this->setValueInt('shop_client_attorney_id', $value);
    }
    public function getShopClientAttorneyID(){
        return $this->getValueInt('shop_client_attorney_id');
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

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
