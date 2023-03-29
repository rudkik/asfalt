<?php  defined('SYSPATH') or die('No direct script access.');

class  Model_GoodPriceType extends Model_Basic_Name{

	const GOOD_PRICE_TYPE_DEFAULT = 700;
	const GOOD_PRICE_TYPE_SUPPLIER = 701;
	const GOOD_PRICE_TYPE_LAND_TWO = 702; // зависимость откуда брать цены от страны (price - тенге, price_old - рубль)
	const GOOD_PRICE_TYPE_PLUS_MARKUP_AND_BONUS = 703; // цена формируется price + options[markup] от магазина или от товара + options[bonus] от магазина или от товара
	const GOOD_PRICE_TYPE_GOOD_TO_OPERATION = 704; // Цена завист от оператора таблица ct_shop_good_to_operations

	const TABLE_NAME='ct_good_price_types';
	const TABLE_ID = 41;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
