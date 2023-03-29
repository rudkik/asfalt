<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Comment extends Model_Shop_Basic_Collations{
	
	const TABLE_NAME='ct_shop_comments';
	const TABLE_ID = 11;


	public function __construct(){
		parent::__construct(
			array(
				'comment_type_id',
				'user_id',
				'is_work',
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
					case 'comment_type_id':
						$this->_dbGetElement($this->getCommentTypeID(), 'comment_type_id', new Model_CommentType());
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
	public function validationFields(array &$errorFields)
	{
		$validation = new Validation($this->getValues());

		$validation->rule('is_work', 'max_length', array(':value', 1))
			->rule('comment_type_id', 'max_length', array(':value', 11))
			->rule('user_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('is_work')) {
			$validation->rule('is_work', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('comment_type_id')) {
			$validation->rule('comment_type_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('user_id')) {
			$validation->rule('user_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

	// Группа ли
	public function setIsWork($value){
		$this->setValueBool('is_work', $value);
	}

	public function getIsWork(){
		return $this->getValueBool('is_work');
	}

	public function setCommentTypeID($value){
		$this->setValueBool('comment_type_id', $value);
	}

	public function getCommentTypeID(){
		return $this->getValueBool('comment_type_id');
	}

	public function setUserID($value){
		$this->setValueBool('user_id', $value);
	}

	public function getUserID(){
		return $this->getValueBool('user_id');
	}
}
