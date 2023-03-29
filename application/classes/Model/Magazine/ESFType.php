<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_ESFType extends Model_Basic_Name{

    const ESF_TYPE_ELECTRONIC = 1; // электронная
    const ESF_TYPE_PAPER = 2; // бумажная
    const ESF_TYPE_AWAITING_RECEIPT = 3; // ожидаем получение
    const ESF_TYPE_RETURN = 4; // возврат
    const ESF_TYPE_CORRECT = 5; // Исправленная
	
	const TABLE_NAME = 'sp_esf_types';
	const TABLE_ID = 302;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}