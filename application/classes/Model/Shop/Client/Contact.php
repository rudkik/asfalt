<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Client_Contact extends Model_Shop_Basic_Object
{
    const TABLE_NAME = 'ct_shop_client_contacts';
    const TABLE_ID = 21;

    public function __construct(){
        parent::__construct(
            array(
                'client_contact_type_id',
                'shop_client_id',
                'user_id',
                'email',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL)
    {
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'client_contact_type_id':
                        $this->_dbGetElement($this->getClientContactTypeID(), 'client_contact_type_id', new Model_ClientContactType());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Shop_Client());
                        break;
                    case 'user_id':
                        $this->_dbGetElement($this->getUserID(), 'user_id', new Model_User());
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
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        $validation->rule('shop_client_id', 'max_length', array(':value', 11))
            ->rule('user_id', 'max_length', array(':value', 11))
            ->rule('client_contact_type_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('shop_client_id')){
            $validation->rule('shop_client_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('client_contact_type_id')){
            $validation->rule('client_contact_type_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('user_id')){
            $validation->rule('user_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    // ID контакта магазина
    public function setUserID($value){
        $this->setValueInt('user_id', $value);
    }

    public function getUserID(){
        return $this->getValueInt('user_id');
    }

    // ID контакта магазина
    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }

    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    // Тип контакта (телефона, e-mail, vk  и т.д.)
    public function setClientContactTypeID($value){
        $this->setValueInt('client_contact_type_id', $value);
    }

    public function getClientContactTypeID(){
        return $this->getValueInt('client_contact_type_id');
    }
}
