<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Branch extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_client_branches';
	const TABLE_ID = 380;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_client_id',
                'date',
                'amount',
                'block_amount',
                'balance',
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
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('block_amount', $validation);
        $this->isValidationFieldFloat('balance', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
        $this->setBalance($this->getAmount() - $this->getBlockAmount());
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', $value);
        $this->setBalance($this->getAmount() - $this->getBlockAmount());
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setBalance($value){
        $this->setValueFloat('balance', $value);
    }
    public function getBalance(){
        return $this->getValueFloat('balance');
    }

}
