<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Turn_Type extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_turn_types';
	const TABLE_ID = 65;

    const TYPE = 1;

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
        $validation->rule('is_skip_weighted', 'max_length', array(':value', 1))
            ->rule('is_skip_asu', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsSkipWeighted($value){
        $this->setValueBool('is_skip_weighted', $value);
    }
    public function getIsSkipWeighted(){
        return $this->getValueBool('is_skip_weighted');
    }

    public function setIsSkipAsu($value){
        $this->setValueBool('is_skip_asu', $value);
    }
    public function getIsSkipAsu(){
        return $this->getValueBool('is_skip_asu');
    }
}
