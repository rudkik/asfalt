<?php defined('SYSPATH') or die('No direct script access.');

class Model_OperationType extends Model_Basic_Name{

	const ATC_MECHANIC = 2; // механик
	const ATC_CHIEF = 3; // Начальник

	const TABLE_NAME='ct_operation_types';
	const TABLE_ID = 420;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}