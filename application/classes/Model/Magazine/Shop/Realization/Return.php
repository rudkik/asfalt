<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_Shop_Realization_Return extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_realization_returns';
    const TABLE_ID = 300;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'quantity',
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
        $this->isValidationFieldStr('fiscal_check', $validation, 50);
        $this->isValidationFieldBool('is_fiscal_check', $validation);
        $this->isValidationFieldInt('shop_cashbox_id', $validation);
        $this->isValidationFieldStr('number', $validation, 50);

        return $this->_validationFields($validation, $errorFields);
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

    public function setFiscalCheck($value){
        $this->setValue('fiscal_check', $value);

        if(!$this->getIsFiscalCheck()){
            $this->setIsFiscalCheck(Func::_empty($this->getFiscalCheck()));
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

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }
}
