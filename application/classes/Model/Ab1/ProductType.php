<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ProductType extends Model_Basic_Name{

    const PRODUCT_TYPE_PRODUCT = 1; // продукт
    const PRODUCT_TYPE_MATERIAL = 2; // материал

	const TABLE_NAME='ab_product_types';
	const TABLE_ID = 268;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}