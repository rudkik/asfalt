<?php defined('SYSPATH') or die('No direct script access.');

class Model_CouponType extends Model_Basic_Name{

	const COUPON_TYPE_CATALOGS = 1;
	const COUPON_TYPE_BILL_AMOUNT = 2;
	const COUPON_TYPE_GOODS = 3;
	
	const TABLE_NAME='ct_coupon_types';
	const TABLE_ID = 36;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}