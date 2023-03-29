<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_HolidayYear extends Model_Basic_Name{

	const TABLE_NAME = 'ab_holiday_years';
	const TABLE_ID = 345;

	public function __construct(){
		parent::__construct(
			array(
                'year',
                'free',
                'holiday',
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

    public function setFree($value){
        $this->setValueInt('free', $value);
    }
    public function getFree(){
        return $this->getValueInt('free');
    }

    public function setHoliday($value){
        $this->setValueInt('holiday', $value);
    }
    public function getHoliday(){
        return $this->getValueInt('holiday');
    }

}