<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Worker_Wage_Month extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_worker_wage_months';
	const TABLE_ID = 159;

	public function __construct(){
		parent::__construct(
			array(
                'opv',
                'so',
                'ipn',
                'osms',
                'wage',
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
        $validation->rule('opv', 'max_length', array(':value', 12))
            ->rule('so', 'max_length', array(':value', 12))
            ->rule('ipn', 'max_length', array(':value', 12))
            ->rule('osms', 'max_length', array(':value', 12))
            ->rule('wage', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setWage($value){
        $this->setValueFloat('wage', $value);
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
                $value = '0'.$value;
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
}
