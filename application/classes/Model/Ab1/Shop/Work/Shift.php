<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Work_Shift extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_work_shifts';
	const TABLE_ID = 234;

	public function __construct(){
		parent::__construct(
			array(
                'time_from',
                'time_to',
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

    public function setTimeFrom($value){
        $this->setValueTime('time_from', $value);
    }
    public function getTimeFrom(){
        return $this->getValueDateTime('time_from');
    }

    public function setTimeTo($value){
        $this->setValueTime('time_to', $value);
    }
    public function getTimeTo(){
        return $this->getValueDateTime('time_to');
    }
}
