<?php  defined('SYSPATH') or die('No direct script access.');

class  Model_WorkType extends Model_Basic_Name{

    // не обработан
	const WORK_TYPE_NOT_WORK = 210;
	// обработан
	const WORK_TYPE_FINISH = 211;

	const TABLE_NAME='ct_work_types';
	const TABLE_ID = 80;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}