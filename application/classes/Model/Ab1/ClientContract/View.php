<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_ClientContract_View extends Model_Basic_Name{
    const CLIENT_CONTRACT_VIEW_BASIC = 1; // Основной договор
    const CLIENT_CONTRACT_VIEW_ADDITIONAL_AGREEMENT = 2; // Дополнительное соглашение

	const TABLE_NAME = 'ab_client_contract_views';
	const TABLE_ID = 338;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
