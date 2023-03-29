<?php defined('SYSPATH') or die('No direct script access.');

/** Фиксация всех денежных операция магазина **/
class Model_Tax_Shop_Payment_Book extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_payment_books';
	const TABLE_ID = 180;

	public function __construct(){
		parent::__construct(
			array(
                'amount',
                'shop_paid_type_id',
                'is_coming',
                'date',
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
                    case 'shop_paid_type_id':
                        $this->_dbGetElement($this->getShopPaidTypeID(), 'shop_paid_type_id', new Model_Shop_PaidType());
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
        $validation->rule('amount', 'max_length', array(':value', 12))
            ->rule('shop_paid_type_id', 'max_length', array(':value', 11))
            ->rule('is_coming', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopPaidTypeID($value){
        $this->setValueInt('shop_paid_type_id', $value);
    }
    public function getShopPaidTypeID(){
        return $this->getValueInt('shop_paid_type_id');
    }

    public function getIsComing(){
        $this->getValueBool('is_coming');
    }
    public function setIsComing($value){
        return $this->setValueBool('is_coming', $value);
    }
}
