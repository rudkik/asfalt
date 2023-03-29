<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Transport_Fuel_Department extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transport_fuel_departments';
	const TABLE_ID = 358;

	public function __construct(){
		parent::__construct(
			array(
                'number',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}
}
