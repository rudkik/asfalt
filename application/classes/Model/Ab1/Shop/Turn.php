<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Turn extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_turns';
	const TABLE_ID = 66;

    const TURN_CASH = 1;
    const TURN_WEIGHTED_ENTRY = 2;
	const TURN_ASU = 3;
    const TURN_WEIGHTED_EXIT = 4;
    const TURN_EXIT = 5;
    const TURN_CASH_EXIT = 6;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
