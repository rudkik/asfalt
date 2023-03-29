<?php defined('SYSPATH') or die('No direct script access.');


class Model_Nur_Shop_Task_Group extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'nr_shop_task_groups';
	const TABLE_ID = 262;

	public function __construct(){
		parent::__construct(
			array(
                'shop_task_ids',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldStr('shop_task_ids', $validation, 650000);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTaskIDsArray(array $value){
        $this->setValueArray('shop_task_ids', $value);
    }
    public function getShopTaskIDsArray(){
        return $this->getValueArray('shop_task_ids');
    }
    public function setShopTaskIDs($value){
        $this->setValueStr('shop_task_ids', $value);
    }
    public function getShopTaskIDs(){
        return $this->getValueStr('shop_task_ids');
    }
}
