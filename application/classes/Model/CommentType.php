<?php  defined('SYSPATH') or die('No direct script access.');

class  Model_CommentType extends Model_Basic_Name{

	const COMMENT_TYPE_PLUS = 22;
	const COMMENT_TYPE_MINUS = 23;
	const COMMENT_TYPE_NEUTRAL = 25;

	const TABLE_NAME='ct_comment_types';
	const TABLE_ID = 33;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}
}