<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ProductView extends Model_Basic_Name{

    const PRODUCT_TYPE_CAR = 1; // реализация
    const PRODUCT_TYPE_PIECE = 2; // штучный товар
    const PRODUCT_TYPE_ADDITION_SERVICE = 3; // дополнительные услуги
    const PRODUCT_TYPE_CAR_AND_PIECE = 4; // реализация и штучный товар

	const TABLE_NAME='ab_product_views';
	const TABLE_ID = 312;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}