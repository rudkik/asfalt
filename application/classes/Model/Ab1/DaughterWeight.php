<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_DaughterWeight extends Model_Basic_Name{
    const DAUGHTER_WEIGHT_INVOICE = 1; // Вес накладной
    const DAUGHTER_WEIGHT_DAUGHTER = 2; // Вес отправителя
    const DAUGHTER_WEIGHT_RECEIVER = 3; // Вес получателя

	const TABLE_NAME = 'ab_daughter_weights';
	const TABLE_ID = 317;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
