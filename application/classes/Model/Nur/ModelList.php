<?php defined('SYSPATH') or die('No direct script access.');

class Model_Nur_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Nur_Shop_Task::TABLE_ID:
                $result = new Model_Nur_Shop_Task();
                break;
            case Model_Nur_Shop_Task_Group::TABLE_ID:
                $result = new Model_Nur_Shop_Task_Group();
                break;
            case Model_Nur_Shop_Company_View::TABLE_ID:
                $result = new Model_Nur_Shop_Company_View();
                break;
            case Model_Nur_Shop_Operation::TABLE_ID:
                $result = new Model_Nur_Shop_Operation();
                break;
            case Model_Nur_Shop_Task_Current::TABLE_ID:
                $result = new Model_Nur_Shop_Task_Current();
                break;
            case Model_Nur_Shop_Task_Group_Item::TABLE_ID:
                $result = new Model_Nur_Shop_Task_Group_Item();
                break;
            case Model_Nur_Shop_Tax_View::TABLE_ID:
                $result = new Model_Nur_Shop_Tax_View();
                break;
            default:
                $result = Model_ModelList::createModel($tableID, $driver);
        }

        if($result !== NULL){
            $result->setDBDriver($driver);
        }

        return $result;
    }

}