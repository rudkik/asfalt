<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Work_Time extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_work_times';
	const TABLE_ID = 192;

	public function __construct(){
		parent::__construct(
			array(
                'shop_worker_id',
                'wage',
                'work_time_type_id',
                'date_from',
                'date_to',
                'days',
                'work_days',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'work_time_type_id':
                        $this->_dbGetElement($this->getWorkTimeTypeID(), 'work_time_type_id', new Model_Tax_WorkTimeType());
                        break;
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Tax_Shop_Worker());
                        break;
                }
            }
        }

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
        $validation->rule('shop_worker_id', 'max_length', array(':value', 11))
            ->rule('work_time_type_id', 'max_length', array(':value', 11))
            ->rule('wage', 'max_length', array(':value', 12))
            ->rule('days', 'max_length', array(':value', 11))
            ->rule('work_days', 'max_length', array(':value', 11));

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

    public function setWage($value){
        $this->setValueFloat('wage', $value);
    }
    public function getWage(){
        return $this->getValueFloat('wage');
    }

    public function setDays($value){
        $this->setValueInt('days', $value);
    }
    public function getDays(){
        return $this->getValueInt('days');
    }

    public function setWorkDays($value){
        $this->setValueInt('work_days', $value);
    }
    public function getWorkDays(){
        return $this->getValueInt('work_days');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setWorkTimeTypeID($value){
        $this->setValueInt('work_time_type_id', $value);
    }
    public function getWorkTimeTypeID(){
        return $this->getValueInt('work_time_type_id');
    }
}
