<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Realization extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_realizations';
    const TABLE_ID = 251;

    const SPECIAL_TYPE_BASIC = 0; // основная реазилация
    const SPECIAL_TYPE_PRODUCT = 1; // реализация спецпродукта
    const SPECIAL_TYPE_WRITE_OFF = 2; // списание

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'quantity',
                'shop_worker_id',
                'is_special',
                'shop_write_off_type_id',
                'fiscal_check',
                'is_fiscal_check',
                'shop_cashbox_id',
                'number',
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
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                        break;
                    case 'shop_card_id':
                        $this->_dbGetElement($this->getShopCardID(), 'shop_card_id', new Model_Magazine_Shop_Card(), $shopID);
                        break;
                    case 'shop_write_off_type_id':
                        $this->_dbGetElement($this->getShopWriteOffTypeID(), 'shop_write_off_type_id', new Model_Magazine_Shop_WriteOff_Type());
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

        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldInt('shop_card_id', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldInt('is_special', $validation);
        $this->isValidationFieldInt('shop_write_off_type_id', $validation);
        $this->isValidationFieldStr('fiscal_check', $validation, 50);
        $this->isValidationFieldBool('is_fiscal_check', $validation);
        $this->isValidationFieldInt('shop_cashbox_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setShopCardID($value){
        $this->setValueInt('shop_card_id', $value);
    }
    public function getShopCardID(){
        return $this->getValueInt('shop_card_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setIsSpecial($value){
        $this->setValueInt('is_special', $value);
        return $this;
    }
    public function getIsSpecial(){
        return $this->getValueInt('is_special');
    }

    public function setShopWriteOffTypeID($value){
        $this->setValueInt('shop_write_off_type_id', $value);
    }
    public function getShopWriteOffTypeID(){
        return $this->getValueInt('shop_write_off_type_id');
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

    public function setShopCashboxID($value){
        $this->setValueInt('shop_cashbox_id', $value);
    }
    public function getShopCashboxID(){
        return $this->getValueInt('shop_cashbox_id');
    }
}
