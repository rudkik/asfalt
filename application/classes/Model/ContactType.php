<?php  defined('SYSPATH') or die('No direct script access.');

class  Model_ContactType extends Model_Basic_Name{

	const CONTACT_TYPE_EMAIL = 98;
	const CONTACT_TYPE_PHONE = 13;
	const CONTACT_TYPE_MOBILE = 14;
	const CONTACT_TYPE_SKYPE = 15;
    const CONTACT_TYPE_ICQ = 16;
    const CONTACT_TYPE_FAX = 100;

	const TABLE_NAME='ct_contact_types';
	const TABLE_ID = 34;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}