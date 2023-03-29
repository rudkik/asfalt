<?php defined('SYSPATH') or die('No direct script access.');


class Model_Language extends Model_Basic_Name{
	
	const LANGUAGE_RUSSIAN = 35;
	const LANGUAGE_ENGLISH = 36;
    const LANGUAGE_KAZAKH = 800;
    const LANGUAGE_POLISH = 801;
    const LANGUAGE_ARABIC = 802;

	const TABLE_NAME='ct_languages';
	const TABLE_ID = 44;
	
	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

	// Код языка
	public function setCode($value){
		$this->setValue('code', $value);
	}
	public function getCode(){
		return $this->getValue('code');
	}
}

