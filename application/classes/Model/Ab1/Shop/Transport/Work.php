<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Work extends Model_Shop_Table_Basic_Table{
    const WORK_NORM_ID = 1458614; // по норме
    const WORK_REPAIR_ID = 1458624; // в ремонте
    const WORK_HOLIDAY_ID = 1458618; // Отработано часов в выходные

	const TABLE_NAME = 'ab_shop_transport_works';
	const TABLE_ID = 399;

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
        return $this->_validationFields($validation, $errorFields);
    }


    public function setIndicatorTypeID($value){
        $this->setValueInt('indicator_type_id', $value);
    }
    public function getIndicatorTypeID(){
        return $this->getValueInt('indicator_type_id');
    }
}
