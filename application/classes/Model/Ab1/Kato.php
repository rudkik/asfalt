<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Kato extends Model_Basic_Name{

	const TABLE_NAME='ab_katos';
	const TABLE_ID = 84;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}