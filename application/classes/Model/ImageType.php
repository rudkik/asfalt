<?php defined('SYSPATH') or die('No direct script access.');


class Model_ImageType extends Model_Basic_Name{
    const IMAGE_TYPE_IMAGE = 3167;
    const IMAGE_TYPE_FILE = 3168;

	const TABLE_NAME = 'ct_image_types';
	const TABLE_ID = 42;

	public function __construct()
    {
        parent::__construct(
            array(),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }
}

