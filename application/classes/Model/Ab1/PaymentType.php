<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_PaymentType extends Model_Basic_Name{
    const PAYMENT_TYPE_CASH = 1; // Наличные
    const PAYMENT_TYPE_BANK_CARD = 2; // Оплата банковской карточкой

	const TABLE_NAME = 'ab_payment_types';
	const TABLE_ID = 307;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
