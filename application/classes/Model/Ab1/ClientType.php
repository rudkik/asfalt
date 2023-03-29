<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ClientType extends Model_Basic_Name{

    const CLIENT_TYPE_LESSEE = 1; // Ответ.хранение
    const CLIENT_TYPE_BUY_RAW = 2; // Поставки сырья

	const TABLE_NAME='ab_client_types';
	const TABLE_ID = 315;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = false;
	}

}