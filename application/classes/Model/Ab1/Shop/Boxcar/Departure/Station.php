<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Boxcar_Departure_Station extends Model_Shop_Basic_Options{

    const TABLE_NAME = 'ab_shop_boxcar_departure_stations';
    const TABLE_ID = 209;

    public function __construct(){
        parent::__construct(
            array(),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }
}
