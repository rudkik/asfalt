<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transportation_Place extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transportation_places';
	const TABLE_ID = 349;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
