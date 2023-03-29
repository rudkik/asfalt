<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_TareType extends Model_Basic_Name{
    const TARE_TYPE_OUR = 1; // Наши машины
    const TARE_TYPE_CLIENT = 2; // Машины клиентов
    const TARE_TYPE_OTHER = 3; // Прочие машины

	const TABLE_NAME = 'ab_tare_types';
	const TABLE_ID = 326;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
