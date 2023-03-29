<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ads_Shop_Client extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ads_shop_clients';
	const TABLE_ID = 180;

	public function __construct(){
		parent::__construct(
			array(
                'email',
                'first_name',
                'last_name',
                'address_code',
                'addresses',
                'phone',
                'user_id',
                'delivery_amount',
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
        $validation->rule('phone', 'max_length', array(':value', 50))
            ->rule('first_name', 'max_length', array(':value', 100))
            ->rule('last_name', 'max_length', array(':value', 100))
            ->rule('addresses', 'max_length', array(':value', 650000))
            ->rule('address_code', 'max_length', array(':value', 11))
            ->rule('user_id', 'max_length', array(':value', 11))
            ->rule('bank', 'max_length', array(':value', 250))
            ->rule('delivery_amount', 'max_length', array(':value', 12))
            ->rule('email', 'max_length', array(':value', 100));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['addresses'] = $this->getAddressesArray();
        }

        return $arr;
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

    public function setFirstName($value){
        $this->setValue('first_name', $value);

        $this->setName(trim($this->getFirstName().' '.$this->getLastName()));
    }
    public function getFirstName(){
        return $this->getValue('first_name');
    }

    public function setLastName($value){
        $this->setValue('last_name', $value);

        $this->setName(trim($this->getFirstName().' '.$this->getLastName()));
    }
    public function getLastName(){
        return $this->getValue('last_name');
    }

    public function setAddresses($value){
        $this->setValue('addresses', $value);
    }
    public function getAddresses(){
        return $this->getValue('addresses');
    }
    public function setAddressesArray($value){
        $this->setValueArray('addresses', $value);
    }
    public function getAddressesArray(){
        return $this->getValueArray('addresses');
    }

    public function setAddressCode($value){
        $this->setValueInt('address_code', $value);
    }
    public function getAddressCode(){
        return $this->getValueInt('address_code');
    }

    public function setUserID($value){
        $this->setValueInt('user_id', $value);
    }
    public function getUserID(){
        return $this->getValueInt('user_id');
    }

    public function setDeliveryAmount($value){
        $this->setValueFloat('delivery_amount', $value);
    }
    public function getDeliveryAmount(){
        return $this->getValueFloat('delivery_amount');
    }
}
