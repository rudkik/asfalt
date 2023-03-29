<?php defined('SYSPATH') or die('No direct script access.');

class Model_ActionType extends Model_Basic_Name{

	const ACTION_TYPE_CATALOGS = 1;
	const ACTION_TYPE_BILL_AMOUNT = 2;
	const ACTION_TYPE_GOODS = 3;
	
	const TABLE_NAME='ct_action_types';
	const TABLE_ID = 30;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}