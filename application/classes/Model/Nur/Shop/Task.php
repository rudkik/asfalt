<?php defined('SYSPATH') or die('No direct script access.');


class Model_Nur_Shop_Task extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'nr_shop_tasks';
	const TABLE_ID = 261;

	private $basicQuantity = 0;

	public function __construct(){
		parent::__construct(
			array(
                'date_from',
                'date_to',
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

    public function setOriginalValue($name, $value)
    {
        if ($name == 'quantity') {
            $this->basicQuantity = floatval($value);
        }
        parent::setOriginalValue($name, $value);
    }

    public function setDateFrom($value){
        $value = date('2003-m-d', strtotime($value));
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDate('date_from');
    }

    public function setDayFrom($value){
        $value = date('2003-'.Helpers_DateTime::getMonth($this->getDateFrom()).'-d', strtotime($value));
        $this->setDateFrom($value);
    }
    public function getDayFrom(){
        return Helpers_DateTime::getDay($this->getDateFrom());
    }
    public function setMonthFrom($value){
        $value = date('2003-m-'.Helpers_DateTime::getDay($this->getDateFrom()), strtotime($value));
        $this->setDateFrom($value);
    }
    public function getMonthFrom(){
        return Helpers_DateTime::getMonth($this->getDateFrom());
    }

    public function setDateTo($value){
        $value = date('2003-m-d', strtotime($value));
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDate('date_to');
    }

    public function setDayTo($value){
        $value = date('2003-'.Helpers_DateTime::getMonth($this->getDateTo()).'-d', strtotime($value));
        $this->setDateTo($value);
    }
    public function getDayTo(){
        return Helpers_DateTime::getDay($this->getDateTo());
    }
    public function setMonthTo($value){
        $value = date('2003-m-'.Helpers_DateTime::getDay($this->getDateTo()), strtotime($value));
        $this->setDateTo($value);
    }
    public function getMonthTo(){
        return Helpers_DateTime::getMonth($this->getDateTo());
    }

}
