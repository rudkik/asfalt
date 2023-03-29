<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Rubric_Object extends Model_Shop_Basic_Remarketing{

	const TABLE_NAME = 'ct_shop_table_rubric_objects';
	const TABLE_ID = 12;

	public function __construct(){
		parent::__construct(
			array(
                'shop_table_rubric_id',
				'shop_object_id',
                'object_table_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

        $this->isValidationFieldInt('shop_object_id', $validation);
        $this->isValidationFieldInt('shop_table_rubric_id', $validation);
        $this->isValidationFieldInt('object_table_id', $validation);

		return $this->_validationFields($validation, $errorFields);
	}

	public function setShopTableRubricID($value){
		$this->setValueInt('shop_table_rubric_id', $value);
	}
	public function getShopTableRubricID(){
		return $this->getValueInt('shop_table_rubric_id');
	}

	public function setShopObjectID($value){
		$this->setValueInt('shop_object_id', $value);
	}
	public function getShopObjectID(){
		return $this->getValueInt('shop_object_id');
	}

    public function setObjectTableID($value){
        $this->setValueInt('object_table_id', $value);
    }
    public function getObjectTableID(){
        return $this->getValueInt('object_table_id');
    }
}
