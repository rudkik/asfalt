<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Pricelist extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_pricelists';
	const TABLE_ID = 220;

	public function __construct(){
		parent::__construct(
			array(
                'date_from',
                'date_to',
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

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }
}
