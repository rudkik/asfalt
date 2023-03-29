<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Client extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ct_shop_clients';
	const TABLE_ID = 56;

	public function __construct(){
		parent::__construct(
			array(),
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
        $validation->rule('email', 'max_length', array(':value', 250))
            ->rule('last_name', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['contacts'] = $this->getContactsArray();
        }

        return $arr;
    }

	public function setLastName($value){
		$this->setValue('last_name', $value);
	}
	public function getLastName(){
		return $this->getValue('last_name');
	}

    // JSON настройки списка контактов
    public function setContacts($value){
        $this->setValue('contacts', $value);
    }
    public function getContacts(){
        return $this->getValue('contacts');
    }
    public function setContactsArray(array $value){
        $this->setValueArray('contacts', $value);
    }
    public function getContactsArray(){
        return $this->getValueArray('contacts');
    }

    /**
     * Добавить новый контакт
     * @param $contact
     * @param $clientContactTypeID
     */
    public function addContact($contact, $clientContactTypeID){
        $contacts = $this->getContactsArray();
        if (key_exists($clientContactTypeID, $contacts)){
            $contacts[$clientContactTypeID][] = $contact;
        }else{
            $contacts[$clientContactTypeID][] = array(
                $contact
            );
        }
        $this->setContactsArray($contacts);
    }
}
