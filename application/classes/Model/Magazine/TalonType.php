<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_TalonType extends Model_Basic_Name{

	const TALON_TYPE_MILK = 1; // спец молоко
	
	const TABLE_NAME = 'sp_talon_types';
	const TABLE_ID = 270;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}