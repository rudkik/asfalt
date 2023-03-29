<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Consumable extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'hc_shop_consumables';
	const TABLE_ID = 178;

	public function __construct(){
		parent::__construct(
			array(
                'from_at',
                'to_at',
                'number',
                'amount',
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

        return $this->_validationFields($validation, $errorFields);
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
