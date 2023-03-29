<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Message_Chat extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_message_chats';
	const TABLE_ID = 89;

	public function __construct(){
		parent::__construct(
			array(
				'shop_client_id',
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
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Shop_Client());
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

		$validation->rule('shop_client_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('shop_client_id')) {
            $validation->rule('shop_client_id', 'digit');
        }

		return $this->_validationFields($validation, $errorFields);
	}

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }
}
