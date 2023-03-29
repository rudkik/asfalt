<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_PlanReasonType extends Model_Basic_Name{

	const TABLE_NAME='ab_plan_reason_types';
	const TABLE_ID = 279;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}