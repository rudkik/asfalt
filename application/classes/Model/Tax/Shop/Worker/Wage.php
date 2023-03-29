<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Worker_Wage extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_worker_wages';
	const TABLE_ID = 146;

	public function __construct(){
		parent::__construct(
			array(
                'shop_worker_id',
                'opv',
                'so',
                'ipn',
                'osms',
                'wage',
                'wage_basic',
                'worker_status_id',
                'is_owner',
                'shop_worker_wage_month_id',
                'date',
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
                    case 'worker_status_id':
                        $this->_dbGetElement($this->getWorkerStatusID(), 'worker_status_id', new Model_Tax_WorkerStatus());
                        break;
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Tax_Shop_Worker());
                        break;
                    case 'shop_worker_wage_month_id':
                        $this->_dbGetElement($this->getShopWorkerWageMonthID(), 'shop_worker_wage_month_id', new Model_Tax_Shop_Worker_Wage_Month());
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
            ->rule('shop_worker_wage_month_id', 'max_length', array(':value', 11))
            ->rule('days', 'max_length', array(':value', 11))
            ->rule('work_days', 'max_length', array(':value', 11))
            ->rule('opv', 'max_length', array(':value', 12))
            ->rule('so', 'max_length', array(':value', 12))
            ->rule('ipn', 'max_length', array(':value', 12))
            ->rule('osms', 'max_length', array(':value', 12))
            ->rule('wage', 'max_length', array(':value', 12))
            ->rule('wage_basic', 'max_length', array(':value', 12))
            ->rule('is_owner', 'max_length', array(':value', 1))
            ->rule('worker_status_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDays($value){
        $this->setValueFloat('days', $value);
    }
    public function getDays(){
        return $this->getValueFloat('days');
    }

    public function setWorkDays($value){
        $this->setValueFloat('work_days', $value);
    }
    public function getWorkDays(){
        return $this->getValueFloat('work_days');
    }

    public function setIsOwner($value){
        $this->setValueBool('is_owner', $value);
    }
    public function getIsOwner(){
        return $this->getValueBool('is_owner');
    }

    public function setWageBasic($value){
        $this->setValueFloat('wage_basic', $value);
    }
    public function getWageBasic(){
        return $this->getValueFloat('wage_basic');
    }

    public function setWage($value){
        $this->setValueFloat('wage', $value);

        if(Func::_empty($this->getWageBasic())){
            $this->setWageBasic($value);
        }
    }
    public function getWage(){
        return $this->getValueFloat('wage');
    }

    public function setOSMS($value){
        $this->setValueFloat('osms', $value);
    }
    public function getOSMS(){
        return $this->getValueFloat('osms');
    }

    public function setIPN($value){
        $this->setValueFloat('ipn', $value);
    }
    public function getIPN(){
        return $this->getValueFloat('ipn');
    }

    public function setSN($value){
        $this->setValueFloat('sn', $value);
    }
    public function getSN(){
        return $this->getValueFloat('sn');
    }

    public function setSO($value){
        $this->setValueFloat('so', $value);
    }
    public function getSO(){
        return $this->getValueFloat('so');
    }

    public function setOPV($value){
        $this->setValueFloat('opv', $value);
    }
    public function getOPV(){
        return $this->getValueFloat('opv');
    }

    public function setYear($value){
        if (empty($this->getDate())){
            $this->setDate($value.'-01-01');
        }else{
            $tmp = $this->getMonth();
            if(strlen($tmp) < 2){
                $tmp = '0'.$tmp;
            }
            $this->setDate($value.'-'.$tmp.'-01');
        }
    }
    public function getYear(){
        return Helpers_DateTime::getYear($this->getDate());
    }

    public function getHalfYear(){
        if ($this->getMonth() > 6){
            return 2;
        }else{
            return 1;
        }

    }

    public function setMonth($value){
        $date = $this->getDate();
        if (empty($date)){
            $this->setDate(date('Y').'-'.$value.'-01');
        }else{
            if(strlen($value) < 2){
                $tmp = '0'.$value;
            }
            $this->setDate($this->getYear().'-'.$value.'-01');
        }
    }
    public function getMonth(){
        return Helpers_DateTime::getMonth($this->getDate());
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setWorkerStatusID($value){
        $this->setValueInt('worker_status_id', $value);
    }
    public function getWorkerStatusID(){
        return $this->getValueInt('worker_status_id');
    }

    public function setShopWorkerWageMonthID($value){
        $this->setValueInt('shop_worker_wage_month_id', $value);
    }
    public function getShopWorkerWageMonthID(){
        return $this->getValueInt('shop_worker_wage_month_id');
    }
}
