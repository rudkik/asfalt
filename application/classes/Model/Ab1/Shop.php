<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop extends Model_Shop{

    const SHOP_TABLE_RUBRIC_BRANCH = 1;
    const SHOP_TABLE_RUBRIC_MAGAZINE = 2;


    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }
}
