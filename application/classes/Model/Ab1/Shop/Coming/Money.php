<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Coming_Money extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_coming_moneys';
	const TABLE_ID = 309;

	public function __construct(){
		parent::__construct(
			array(
                'number',
                'amount',
                'shop_cashbox_id',
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
        $validation->rule('number', 'max_length', array(':value', 250))
			->rule('amount', 'max_length', array(':value', 14));

        $this->isValidationFieldInt('shop_cashbox_id', $validation);

        return $this->_validationFields($validation, $errorFields);
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

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}
}
