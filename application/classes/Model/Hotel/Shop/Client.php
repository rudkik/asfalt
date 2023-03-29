<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Client extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'hc_shop_clients';
	const TABLE_ID = 138;

	public function __construct(){
		parent::__construct(
			array(
                'phone',
                'email',
                'bank',
                'account',
                'address',
                'bik',
                'bin',
                'bank_id',
                'block_amount',
                'amount',
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
                    case 'bank_id':
                        $this->_dbGetElement($this->getBankID(), 'bank_id', new Model_Bank());
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
        $validation->rule('phone', 'max_length', array(':value', 50))
            ->rule('bin', 'max_length', array(':value', 12))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('block_amount', 'max_length', array(':value', 12))
            ->rule('bank_id', 'max_length', array(':value', 11))
            ->rule('bik', 'max_length', array(':value', 8))
            ->rule('address', 'max_length', array(':value', 250))
            ->rule('account', 'max_length', array(':value', 250))
            ->rule('bank', 'max_length', array(':value', 250))
            ->rule('email', 'max_length', array(':value', 100));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setPhone($value){
        $this->setValue('phone', $value);
    }
    public function getPhone(){
        return $this->getValue('phone');
    }

    public function setEmail($value){
        $this->setValue('email', $value);
    }
    public function getEmail(){
        return $this->getValue('email');
    }

    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }

    public function setBIK($value){
        $this->setValue('bik', $value);
    }
    public function getBIK(){
        return $this->getValue('bik');
    }

    public function setAddress($value){
        $this->setValue('address', $value);
    }
    public function getAddress(){
        return $this->getValue('address');
    }

    public function setAccount($value){
        $this->setValue('account', $value);
    }
    public function getAccount(){
        return $this->getValue('account');
    }

    public function setBank($value){
        $this->setValue('bank', $value);
    }
    public function getBank(){
        return $this->getValue('bank');
    }

    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', $value);
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }
}
