<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_FormulaType extends Model_Basic_Name{

    const FORMULA_PRODUCT_TYPE_ASPHALT = 1; // Асфальт
    const FORMULA_PRODUCT_TYPE_ZHBI = 2; // ЖБИ
    const FORMULA_PRODUCT_TYPE_EMULSION = 3; // Эмульсия
    const FORMULA_MATERIAL_TYPE_BITUMEN_FUEL_OIL = 4; // Битум с диапозоном процентов + топливный компонент
    const FORMULA_PRODUCT_TYPE_CONCRETE = 5; // Бетон
    const FORMULA_PRODUCT_TYPE_ASPHALT_BUNKER = 6; // Асфальт с учетом бункерного рассева
    const FORMULA_MATERIAL_TYPE_CONCRETE = 7; // Бетон материала
    const FORMULA_MATERIAL_TYPE_BITUMEN = 8; // Битум
    const FORMULA_MATERIAL_TYPE_SYSTEM = 98; // Системные материалы
    const FORMULA_PRODUCT_TYPE_SYSTEM = 99; // Системные продукты

    const PARTICLE_TYPE_PRODUCT = 1; // Продукт
    const PARTICLE_TYPE_MATERIAL = 2; // Материал

	const TABLE_NAME = 'ab_formula_types';
	const TABLE_ID = 320;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}