<?php defined('SYSPATH') or die('No direct script access.');


class Model_Sladushka_Shop_Worker_Good_Item extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'sl_shop_worker_good_items';
	const TABLE_ID = 174;

	public function __construct(){
		parent::__construct(
			array(
                'shop_worker_id',
                'shop_worker_good_id',
                'shop_good_id',
                'amount',
                'price',
                'quantity',
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
            ->rule('shop_worker_good_id', 'max_length', array(':value', 11))
            ->rule('shop_good_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('quantity', 'max_length', array(':value', 12))
            ->rule('weight', 'max_length', array(':value', 12))
            ->rule('took', 'max_length', array(':value', 12))
            ->rule('return', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setShopGoodID($value){
        $this->setValueInt('shop_good_id', $value);
    }
    public function getShopGoodID(){
        return $this->getValueInt('shop_good_id');
    }

    public function setShopWorkerGoodID($value){
        $this->setValueInt('shop_worker_good_id', $value);
    }
    public function getShopWorkerGoodID(){
        return $this->getValueInt('shop_worker_good_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setTook($value){
        $this->setValueFloat('took', $value);
    }
    public function getTook(){
        return $this->getValueFloat('took');
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
