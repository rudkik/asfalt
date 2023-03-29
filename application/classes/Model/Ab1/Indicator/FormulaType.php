<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Indicator_FormulaType extends Model_Basic_Name{
    const FORMULA_TYPE_WAGE = 1; // Для расчета зарплаты
    const FORMULA_TYPE_FUEL = 2; // Для расчета расхода ГСМ
    const FORMULA_TYPE_OTHER = 3; // Произвольная

	const TABLE_NAME = 'ab_indicator_formula_types';
	const TABLE_ID = 360;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}