<?php defined('SYSPATH') or die('No direct script access.');


class Model_Sladushka_Shop_Worker_Good extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'sl_shop_worker_goods';
	const TABLE_ID = 173;

	public function __construct(){
		parent::__construct(
			array(
                'shop_worker_id',
                'date',
                'amount',
                'took',
                'return',
                'weight',
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
        $validation->rule('shop_worker_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('took', 'max_length', array(':value', 12))
            ->rule('weight', 'max_length', array(':value', 12))
            ->rule('return', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setTook($value){
        $this->setValueFloat('took', $value);
    }
    public function getTook(){
        return $this->getValueFloat('took');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setReturn($value){
        $this->setValueFloat('return', $value);
    }
    public function getReturn(){
        return $this->getValueFloat('return');
    }

    public function setWeight($value){
        $this->setValueFloat('weight', $value);
    }
    public function getWeight(){
        return $this->getValueFloat('weight');
    }
}
