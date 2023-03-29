<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_ClientContract_Status extends Model_Basic_Name{
    const CLIENT_CONTRACT_STATUS_WORK = 1; // Действует
    const CLIENT_CONTRACT_STATUS_ON_APPROVAL = 4772256; // На согласовании

	const TABLE_NAME = 'ab_client_contract_statuses';
	const TABLE_ID = 372;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}
