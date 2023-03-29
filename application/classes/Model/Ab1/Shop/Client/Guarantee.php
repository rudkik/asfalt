<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Guarantee extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_guarantees';
	const TABLE_ID = 255;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_client_id',
                'amount'
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
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
        $validation->rule('number', 'max_length', array(':value', 50))
            ->rule('amount', 'max_length', array(':value', 14))
            ->rule('shop_client_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
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
}
