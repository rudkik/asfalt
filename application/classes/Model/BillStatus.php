<?php  defined('SYSPATH') or die('No direct script access.');

class Model_BillStatus extends Model_Basic_Name{
	
	const BILL_STATUS_NEW=5; // новый заказ
	const BILL_STATUS_APPLY=6; // принятый заказ
	const BILL_STATUS_COLLECT=7; // собирается заказ
	const BILL_STATUS_READY=8; // собранный заказ
	const BILL_STATUS_DELIVERY=9; // доставляется заказ
	const BILL_STATUS_FINISH=10; // доставлен заказ
	const BILL_STATUS_CANCEL=11; // отменен заказ
	
	const TABLE_NAME='ct_bill_statuses';
	const TABLE_ID = 31;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}