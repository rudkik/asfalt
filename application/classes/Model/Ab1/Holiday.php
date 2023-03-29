<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Holiday extends Model_Basic_Name{

	const TABLE_NAME = 'ab_holidays';
	const TABLE_ID = 344;

	public function __construct(){
		parent::__construct(
			array(
                'year',
                'day',
                'is_free',
                'holiday_year_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    public function setYear($value){
        $this->setValueInt('year', $value);
    }
    public function getYear(){
        return $this->getValueInt('year');
    }

    public function setDay($value){
        $this->setValueDate('day', Helpers_DateTime::changeDateYear($value, $this->getYear()));
    }
    public function getDay(){
        return $this->getValueDate('day');
    }

    public function setIsFree($value){
        $this->setValueBool('is_free', $value);
    }
    public function getIsFree(){
        return $this->getValueBool('is_free');
    }

    public function setHolidayYearID($value){
        $this->setValueInt('holiday_year_id', $value);
    }
    public function getHolidayYearID(){
        return $this->getValueInt('holiday_year_id');
    }

}