<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Calendar extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_calendars';
	const TABLE_ID = 187;

	public function __construct(){
		parent::__construct(
			array(
                'is_holiday',
                'date',
            ),
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
        $validation->rule('is_holiday', 'is_holiday', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsHoliday($value){
        $this->setValueBool('is_holiday', $value);
    }
    public function getIsHoliday(){
        return $this->getValueBool('is_holiday');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }
}
