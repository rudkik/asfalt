<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Contract extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_contracts';
	const TABLE_ID = 224;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'amount',
                'quantity',
                'block_quantity',
                'balance',
                'is_basic',
                'client_contract_type_id',
                'client_contract_status_id',
                'is_prolongation',
                'is_redaction_client',
                'executor_shop_worker_id',
                'number_company',
                'is_fixed_price',
                'is_fixed_contract',
                'basic_shop_client_contract_id',
                'is_add_basic_contract',
                'currency_id',
                'shop_client_contract_storage_id',
                'is_perpetual',
                'paid_amount',
                'shop_department_id',
                'client_contract_kind_id',
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
                case 'shop_department_id':
                    $this->_dbGetElement($this->getShopDepartmentID(), 'shop_department_id', new Model_Ab1_Shop_Department(), $shopID);
                    break;
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
                case 'basic_shop_client_contract_id':
                    $this->_dbGetElement($this->getBasicShopClientContractID(), 'basic_shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                    break;
                case 'client_contract_type_id':
                    $this->_dbGetElement($this->getClientContractTypeID(), 'client_contract_type_id', new Model_Ab1_ClientContract_Type(), 0);
                    break;
                case 'client_contract_status_id':
                    $this->_dbGetElement($this->getClientContractStatusID(), 'client_contract_status_id', new Model_Ab1_ClientContract_Status(), 0);
                    break;
                case 'executor_shop_worker_id':
                    $this->_dbGetElement($this->getExecutorShopWorkerID(), 'executor_shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                    break;
                case 'client_contract_kind_id':
                    $this->_dbGetElement($this->getClientContractKindID(), 'client_contract_kind_id', new Model_Ab1_ClientContract_Kind(), $shopID);
                    break;
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);
        $arr['balance'] = $this->getAmount() - $this->getBlockAmount();

        if($isParseArray === TRUE) {
            $arr['contract_templates'] = $this->getContractTemplatesArray();
        }

        return $arr;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('number', 'max_length', array(':value', 50))
            ->rule('amount', 'max_length', array(':value', 14))
            ->rule('shop_client_id', 'max_length', array(':value', 11));

        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('block_quantity', $validation);
        $this->isValidationFieldFloat('balance', $validation);
        $this->isValidationFieldBool('is_fixed_price', $validation);
        $this->isValidationFieldBool('is_fixed_contract', $validation);
        $this->isValidationFieldInt('basic_shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_storage_id', $validation);
        $this->isValidationFieldBool('is_add_basic_contract', $validation);
        $this->isValidationFieldBool('is_perpetual', $validation);
        $this->isValidationFieldFloat('paid_amount', $validation);
        $this->isValidationFieldInt('shop_department_id', $validation);

        $this->isValidationFieldStr('subject', $validation);
        $this->isValidationFieldBool('is_basic', $validation);
        $this->isValidationFieldInt('client_contract_type_id', $validation);
        $this->isValidationFieldInt('client_contract_status_id', $validation);
        $this->isValidationFieldBool('is_prolongation', $validation);
        $this->isValidationFieldBool('is_redaction_client', $validation);
        $this->isValidationFieldInt('executor_shop_worker_id', $validation);
        $this->isValidationFieldInt('client_contract_kind_id', $validation);
        $this->isValidationFieldStr('number_company', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * изменяет значение по имени
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value) {
        parent::setValue($name, $value);
        if ($name == 'basic_shop_client_contract_id'){
            $this->setIsBasic($this->getBasicShopClientContractID() < 1);
        }elseif ($name == 'is_perpetual'){
            if($this->getIsPerpetual()){
                $this->setToAt(null);
            }
        }elseif ($name == 'to_at'){
            if(!Func::_empty($this->getToAt())){
                $this->setIsPerpetual(false);
            }
        }elseif ($name == 'client_contract_view_id'){
            $tmp = $this->getClientContractViewID() == Model_Ab1_ClientContract_View::CLIENT_CONTRACT_VIEW_BASIC;
            if($this->getIsBasic() != $tmp){
                $this->setIsBasic($tmp);
            }
        }
    }

    public function setSubject($value){
        $this->setValue('subject', $value);
    }
    public function getSubject(){
        return $this->getValue('subject');
    }

    public function setIsBasic($value){
        $this->setValueBool('is_basic', $value);

        if($this->getIsBasic() && $this->getClientContractViewID() != Model_Ab1_ClientContract_View::CLIENT_CONTRACT_VIEW_BASIC){
            $this->setClientContractViewID(Model_Ab1_ClientContract_View::CLIENT_CONTRACT_VIEW_BASIC);
        }
    }
    public function getIsBasic(){
        return $this->getValueBool('is_basic');
    }

    public function setIsPerpetual($value){
        $this->setValueBool('is_perpetual', $value);
        if($this->getIsPerpetual()){
            $this->setToAt(null);
        }
    }
    public function getIsPerpetual(){
        return $this->getValueBool('is_perpetual');
    }

    public function setIsProlongation($value){
        $this->setValueBool('is_prolongation', $value);
    }
    public function getIsProlongation(){
        return $this->getValueBool('is_prolongation');
    }

    public function setIsRedactionClient($value){
        $this->setValueBool('is_redaction_client', $value);
    }
    public function getIsRedactionClient(){
        return $this->getValueBool('is_redaction_client');
    }

    public function setNumberCompany($value){
        $this->setValue('number_company', $value);
    }
    public function getNumberCompany(){
        return $this->getValue('number_company');
    }

    public function setBasicShopClientContractID($value){
        $this->setValueInt('basic_shop_client_contract_id', $value);
        $this->setIsBasic($this->getBasicShopClientContractID() < 1);
    }
    public function getBasicShopClientContractID(){
        return $this->getValueInt('basic_shop_client_contract_id');
    }

    public function setIsAddBasicContract($value){
        $this->setValueInt('is_add_basic_contract', $value);
    }
    public function getIsAddBasicContract(){
        return $this->getValueInt('is_add_basic_contract');
    }

    public function setExecutorShopWorkerID($value){
        $this->setValueInt('executor_shop_worker_id', $value);
    }
    public function getExecutorShopWorkerID(){
        return $this->getValueInt('executor_shop_worker_id');
    }

    public function setClientContractStatusID($value){
        $this->setValueInt('client_contract_status_id', $value);
    }
    public function getClientContractStatusID(){
        return $this->getValueInt('client_contract_status_id');
    }

    public function setClientContractTypeID($value){
        $this->setValueInt('client_contract_type_id', $value);
    }
    public function getClientContractTypeID(){
        return $this->getValueInt('client_contract_type_id');
    }

    public function setClientContractKindID($value){
        $this->setValueInt('client_contract_kind_id', $value);
    }
    public function getClientContractKindID(){
        return $this->getValueInt('client_contract_kind_id');
    }

    public function setClientContractViewID($value){
        $this->setValueInt('client_contract_view_id', $value);

        $tmp = $this->getClientContractViewID() == Model_Ab1_ClientContract_View::CLIENT_CONTRACT_VIEW_BASIC;
        if($this->getIsBasic() != $tmp){
            $this->setIsBasic($tmp);
        }
    }
    public function getClientContractViewID(){
        return $this->getValueInt('client_contract_view_id');
    }

    public function setShopClientContractStorageID($value){
        $this->setValueInt('shop_client_contract_storage_id', $value);
    }
    public function getShopClientContractStorageID(){
        return $this->getValueInt('shop_client_contract_storage_id');
    }

    public function setShopDepartmentID($value){
        $this->setValueInt('shop_department_id', $value);
    }
    public function getShopDepartmentID(){
        return $this->getValueInt('shop_department_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
		$this->setBalanceAmount($this->getAmount() - $this->getBlockAmount());
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', $value);
        $this->setBalanceAmount($this->getAmount() - $this->getBlockAmount());
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setBalanceAmount($value){
        $this->setValueFloat('balance_amount', $value);
    }
    public function getBalanceAmount(){
        return $this->getValueFloat('balance_amount');
    }

    public function setPaidAmount($value){
        $this->setValueFloat('paid_amount', $value);
    }
    public function getPaidAmount(){
        return $this->getValueFloat('paid_amount');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

	public function setFromAt($value){
		$this->setValueDateTime('from_at', $value);
	}
	public function getFromAt(){
		return $this->getValueDateTime('from_at');
	}

	public function setToAt($value){
		$this->setValueDateTime('to_at', $value);

        if(!Func::_empty($this->getToAt())){
            $this->setIsPerpetual(false);
        }
	}
	public function getToAt(){
		return $this->getValueDateTime('to_at');
	}

    public function setIsFixedPrice($value){
        $this->setValueBool('is_fixed_price', $value);
    }
    public function getIsFixedPrice(){
        return $this->getValueBool('is_fixed_price');
    }

    public function setIsFixedContract($value){
        $this->setValueBool('is_fixed_contract', $value);
    }
    public function getIsFixedContract(){
        return $this->getValueBool('is_fixed_contract');
    }

    public function setCurrencyID($value){
        $this->setValueInt('currency_id', $value);
    }
    public function getCurrencyID(){
        return $this->getValueInt('currency_id');
    }

    public function setContractTemplates($value){
        $this->setValue('contract_templates', $value);
    }
    public function getContractTemplates(){
        return $this->getValue('contract_templates');
    }
    public function setContractTemplatesArray(array $value){
        $this->setValueArray('contract_templates', $value);
    }
    public function getContractTemplatesArray($template = null){
        return $this->getValueArray('contract_templates', $template);
    }

    public function setAdditionalAgreementCount($value){
        $this->setValueInt('additional_agreement_count', $value);
    }
    public function getAdditionalAgreementCount(){
        return $this->getValueInt('additional_agreement_count');
    }

    // Дата обновления записи
    public function setOperationUpdatedAt($value){
        $this->setValueDateTime('operation_updated_at', $value);
    }
    public function getOperationUpdatedAt(){
        return $this->getValueDateTime('operation_updated_at');
    }

    public function setUpdatedOperationID($value){
        $this->setValueInt('update_operation_id', $value);
    }
    public function getUpdatedOperationID(){
        return $this->getValueInt('update_operation_id');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
