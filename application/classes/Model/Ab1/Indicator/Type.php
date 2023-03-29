<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Indicator_Type extends Model_Basic_Name{
    const INDICATOR_TYPE_MILAGE = 1; // Пробег
    const INDICATOR_TYPE_COUTN_TRIP = 2; // Количество ездок
    const INDICATOR_TYPE_MILAGE_GARGO = 3; // Пробег с грузом
    const INDICATOR_TYPE_ALL_TIME = 4; // Общее время работы
    const INDICATOR_TYPE_NORM_TIME = 5; // Норма времени, явка (для водителей)
    const INDICATOR_TYPE_WEIGHT = 6; // Масса груза, полная
    const INDICATOR_TYPE_HOLIDAY_TIME = 7; // Отработано часов в выходные
    const INDICATOR_TYPE_NIGHT_TIME = 8; // Отработано часов ночных
    const INDICATOR_TYPE_OVERTIME = 9; // Отработано часов сверхурочно
    const INDICATOR_TYPE_WEIGHT_HOLIDAY = 10; // Количество перевезенного груза в выходные

	const TABLE_NAME = 'ab_indicator_types';
	const TABLE_ID = 364;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}