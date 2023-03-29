<?php defined('SYSPATH') or die('No direct script access.');


class Model_Pyramid_Shop_Expense_Type extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'np_shop_expense_types';
	const TABLE_ID = 239;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
        $this->isValidationFieldFloat('amount', $validation, 20);

        return $this->_validationFields($validation, $errorFields);
    }

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }
}
