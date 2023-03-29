<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_DeliveryType extends Model_Basic_Name{

    const DELIVERY_TYPE_WEIGHT = 1; // Оплата за вес
    const DELIVERY_TYPE_WEIGHT_AND_KM = 2; // Оплата за вес и км
    const DELIVERY_TYPE_KM = 3; // Оплата за км
    const DELIVERY_TYPE_TREATY = 4; // Договорная цена

	const TABLE_NAME='ab_delivery_types';
	const TABLE_ID = 149;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}