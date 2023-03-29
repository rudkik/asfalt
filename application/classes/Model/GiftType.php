<?php defined('SYSPATH') or die('No direct script access.');

class Model_GiftType extends Model_Basic_Name
{
	const GIFT_TYPE_BILL_COMMENT = 3164;
	const GIFT_TYPE_BILL_GIFT = 3165;
	const GIFT_TYPE_BILL_DISCOUNT = 3166;
	const GIFT_TYPE_BILL_DISCOUNT_AND_COMMENT = 3167;

	const TABLE_NAME = 'ct_gift_types';
	const TABLE_ID = 40;

	public function __construct()
	{
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}