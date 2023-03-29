<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sladushka_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Shop_Good::TABLE_ID:
                $result = new Model_Shop_Good();
                break;
            case Model_Shop_Operation::TABLE_ID:
                $result = new Model_Shop_Operation();
                break;
            case Model_Sladushka_Shop_Worker::TABLE_ID:
                $result = new Model_Sladushka_Shop_Worker();
                break;
            case Model_Sladushka_Shop_Worker_Good::TABLE_ID:
                $result = new Model_Sladushka_Shop_Worker_Good();
                break;
            case Model_Sladushka_Shop_Worker_Good_Item::TABLE_ID:
                $result = new Model_Sladushka_Shop_Worker_Good_Item();
                break;
            default:
                $result = NULL;
        }

        if($result !== NULL){
            $result->setDBDriver($driver);
        }

        return $result;
    }

}