<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Payment_Return extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_payment_returns';
	const TABLE_ID = 304;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_cashbox_id',
                'fiscal_check',
                'is_fiscal_check',
                'shop_consumable_id',
                'shop_client_contract_id',
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
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_cashbox_id':
                        $this->_dbGetElement($this->getShopCashboxID(), 'shop_cashbox_id', new Model_Ab1_Shop_Cashbox(), $shopID);
                        break;
                    case 'shop_consumable_id':
                        $this->_dbGetElement($this->getShopConsumableID(), 'shop_consumable_id', new Model_Ab1_Shop_Consumable());
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client(), $shopID);
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
			->rule('number', 'max_length', array(':value', 250))
			->rule('amount', 'max_length', array(':value', 14));
        $this->isValidationFieldStr('fiscal_check', $validation, 50);
        $this->isValidationFieldBool('is_fiscal_check', $validation);
        $this->isValidationFieldInt('shop_cashbox_id', $validation);
        $this->isValidationFieldInt('shop_consumable_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopConsumableID($value){
        $this->setValueInt('shop_consumable_id', $value);
    }
    public function getShopConsumableID(){
        return $this->getValueInt('shop_consumable_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopCashboxID($value){
        $this->setValueInt('shop_cashbox_id', $value);
    }
    public function getShopCashboxID(){
        return $this->getValueInt('shop_cashbox_id');
    }

	public function setShopClientID($value){
		$this->setValueInt('shop_client_id', $value);
	}
	public function getShopClientID(){
		return $this->getValueInt('shop_client_id');
	}

    public function setNumber($value){
		$this->setValue('number', $value);
	}
	public function getNumber(){
		return $this->getValue('number');
	}

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

    public function setFiscalCheck($value){
        $this->setValue('fiscal_check', $value);

        if(!$this->getIsFiscalCheck()){
            $this->setIsFiscalCheck(!Func::_empty($this->getFiscalCheck()));
        }
    }
    public function getFiscalCheck(){
        return $this->getValue('fiscal_check');
    }

    public function setIsFiscalCheck($value){
        $this->setValueBool('is_fiscal_check', $value);
    }
    public function getIsFiscalCheck(){
        return $this->getValueBool('is_fiscal_check');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
