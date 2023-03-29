<?php defined('SYSPATH') or die('No direct script access.');

class Model_Calendar_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Calendar_Shop_Operation::TABLE_ID:
                $result = new Model_Calendar_Shop_Operation();
                break;
            case Model_Calendar_Shop_Partner::TABLE_ID:
                $result = new Model_Calendar_Shop_Partner();
                break;
            case Model_Calendar_Shop_Product::TABLE_ID:
                $result = new Model_Calendar_Shop_Product();
                break;
            case Model_Calendar_Shop_Result::TABLE_ID:
                $result = new Model_Calendar_Shop_Result();
                break;
            case Model_Calendar_Shop_Rubric::TABLE_ID:
                $result = new Model_Calendar_Shop_Rubric();
                break;
            case Model_Calendar_Shop_Task::TABLE_ID:
                $result = new Model_Calendar_Shop_Task();
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