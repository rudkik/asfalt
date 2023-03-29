<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_CheckType extends Model_Basic_Name{
    const CHECK_TYPE_NOT_CHECK = 0; // Не проверенно
    const CHECK_TYPE_CHECK = 1; // Проверено
    const CHECK_TYPE_PRINT = 2; // Разрешено к печати

	const TABLE_NAME = 'ab_check_types';
	const TABLE_ID = 310;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
