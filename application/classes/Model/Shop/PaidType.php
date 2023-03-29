<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_PaidType extends Model_Shop_Basic_SEO{
	
	const TABLE_NAME='ct_shop_paid_types';
	const TABLE_ID = 28;

	public function __construct(){
		parent::__construct(
			array(
				'paid_type_id',
				'price'
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
		$this->isCreateUser = TRUE;
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
					case 'paid_type_id':
						$this->_dbGetElement($this->getPaidTypeID(), 'paid_type_id', new Model_PaidType());
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

		$validation->rule('price', 'max_length', array(':value', 13))
			->rule('paid_type_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('paid_type_id')){
			$validation->rule('paid_type_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	public function setPrice($value){
		$this->setValueFloat('price', $value);
	}

	public function getPrice(){
		return $this->getValueFloat('price');
	}

	public function setPaidTypeID($value){
		$this->setValueInt('paid_type_id', $value);
	}
	public function getPaidTypeID(){
		return $this->getValueInt('paid_type_id');
	}
}
