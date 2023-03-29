<?php defined('SYSPATH') or die('No direct script access.');

class Model_DiscountType extends Model_Basic_Name{

	const DISCOUNT_TYPE_CATALOGS = 26;
	const DISCOUNT_TYPE_BILL_AMOUNT = 27;
	const DISCOUNT_TYPE_GOODS = 29;
	const DISCOUNT_TYPE_GOOD = 201;
	
	const TABLE_NAME='ct_discount_types';
	const TABLE_ID = 38;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}