<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Payment_Plan extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_payment_plans';
	const TABLE_ID = 110;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'amount',
                'date',
                'is_presumably',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
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
			->rule('amount', 'max_length', array(':value', 12))
			->rule('is_presumably', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsPresumably($value){
        $this->setValueBool('is_presumably', $value);
    }
    public function getIsPresumably(){
        return $this->getValueBool('is_presumably');
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }
}
