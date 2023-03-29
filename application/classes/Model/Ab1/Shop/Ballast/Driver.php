<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Ballast_Driver extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_ballast_drivers';
	const TABLE_ID = 190;

	public function __construct(){
		parent::__construct(
			array(
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
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueFloat('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueFloat('shop_worker_id');
    }
}
