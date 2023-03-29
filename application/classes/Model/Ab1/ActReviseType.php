<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ActReviseType extends Model_Basic_Name{
    const BANK_PAYMENT = 'Выписка с расчетного счета';

	const TABLE_NAME = 'ab_act_revise_types';
	const TABLE_ID = 301;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}