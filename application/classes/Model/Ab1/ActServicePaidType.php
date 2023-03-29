<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ActServicePaidType extends Model_Basic_Name{
	const TABLE_NAME='ab_act_service_paid_types';
	const TABLE_ID = 274;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = false;
	}

}