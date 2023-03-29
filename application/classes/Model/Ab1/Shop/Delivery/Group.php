<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Delivery_Group extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_delivery_groups';
	const TABLE_ID = 272;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
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
        return $this->_validationFields($validation, $errorFields);
    }
}
