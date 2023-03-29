<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_EMail extends Model_Shop_Basic_Options{

	const TABLE_NAME='ct_shop_emails';
	const TABLE_ID = 25;

	public function __construct(){
		parent::__construct(
			array(
                'email_type_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
					case 'email_type_id':
						$this->_dbGetElement($this->getEmailTypeID(), 'email_type_id', new Model_EMailType());
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

        $validation->rule('email_type_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('email_type_id')) {
            $validation->rule('email_type_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

	public function setEmailTypeID($value){
		$this->setValue('email_type_id', intval($value));
	}

	public function getEmailTypeID(){
		return intval($this->getValue('email_type_id'));
	}
}
