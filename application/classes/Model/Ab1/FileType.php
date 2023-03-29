<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_FileType extends Model_Basic_Name{

	const TABLE_NAME='ed_file_types';
	const TABLE_ID = 126;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

}