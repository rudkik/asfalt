<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Message extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_messages';
	const TABLE_ID = 90;

	public function __construct(){
		parent::__construct(
			array(
				'shop_client_id',
				'shop_message_chat_id',
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
                    case 'shop_message_chat_id':
                        $this->_dbGetElement($this->getShopMessageChatID(), 'shop_message_chat_id', new Model_Shop_Message_Chat());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopMessageChatID($value){
        $this->setValueInt('shop_message_chat_id', $value);
    }
    public function getShopMessageChatID(){
        return $this->getValueInt('shop_message_chat_id');
    }
}
