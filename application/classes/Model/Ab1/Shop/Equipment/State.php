<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Equipment_State extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_equipment_states';
	const TABLE_ID = 382;

    public function __construct(){
        parent::__construct(
            array(),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

}
