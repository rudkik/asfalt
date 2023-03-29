<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Account extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_accounts';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'password',
			'user_hash',
			'login',
			'link',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                 }
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

        $this->isValidationFieldStr('password', $validation);
        $this->isValidationFieldStr('user_hash', $validation);
        $this->isValidationFieldStr('login', $validation);
        $this->isValidationFieldStr('link', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setPassword($value){
        $this->setValue('password', $value);
    }
    public function getPassword(){
        return $this->getValue('password');
    }

    public function setUserHash($value){
        $this->setValue('user_hash', $value);
    }
    public function getUserHash(){
        return $this->getValue('user_hash');
    }

    public function setLogin($value){
        $this->setValue('login', $value);
    }
    public function getLogin(){
        return $this->getValue('login');
    }

    public function setLink($value){
        $this->setValue('link', $value);
    }
    public function getLink(){
        return $this->getValue('link');
    }


}
