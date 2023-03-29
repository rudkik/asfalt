<?php defined('SYSPATH') or die('No direct script access.');

class Model_Table extends Model_Basic_Name{

	const TABLE_NAME="ct_tables";
	const TABLE_ID = 48;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
