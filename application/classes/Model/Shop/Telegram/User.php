<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Telegram_User extends Model_Shop_Table_Basic_Object{

	const TABLE_NAME = 'ct_shop_telegram_users';
	const TABLE_ID = 316;

	public function __construct(){
		parent::__construct(
			array(
				'telegram_chat_id',
                'telegram_language_id',
                'telegram_last_command',
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
					case 'telegram_language_id':
						$this->_dbGetElement($this->id, 'telegram_language_id', new Model_Language());
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

		$this->isValidationFieldInt('telegram_language_id', $validation);

		return $this->_validationFields($validation, $errorFields);
	}

    // ID телеграм чата
    public function setTelegramChatID($value){
        $this->setValue('telegram_chat_id', $value);
    }
    public function getTelegramChatID(){
        return $this->getValue('telegram_chat_id');
    }

    // ID телеграмм языка
    public function setTelegramLanguageID($value){
        $this->setValueInt('telegram_language_id', $value);
    }
    public function getTelegramLanguageID(){
        return $this->getValueInt('telegram_language_id');
    }

    // Последняя команда телеграм чата
    public function setTelegramLastCommand($value){
        $this->setValue('telegram_last_command', $value);
    }
    public function getTelegramLastCommand(){
        return $this->getValue('telegram_last_command');
    }

    // Оператор телеграм бота
    public function setTelegramIsOperation($value){
        $this->setValueBool('telegram_is_operation', $value);
    }
    public function getTelegramIsOperation(){
        return $this->getValueBool('telegram_is_operation');
    }
}
