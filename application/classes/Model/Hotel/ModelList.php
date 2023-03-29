<?php defined('SYSPATH') or die('No direct script access.');

class Model_Hotel_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Hotel_Shop_Room::TABLE_ID:
                $result = new Model_Hotel_Shop_Room();
                break;
            case Model_Hotel_Shop_Bill::TABLE_ID:
                $result = new Model_Hotel_Shop_Bill();
                break;
            case Model_Hotel_Shop_Client::TABLE_ID:
                $result = new Model_Hotel_Shop_Client();
                break;
            case Model_Hotel_Shop_Floor::TABLE_ID:
                $result = new Model_Hotel_Shop_Floor();
                break;
            case Model_Hotel_Shop_Building::TABLE_ID:
                $result = new Model_Hotel_Shop_Building();
                break;
            case Model_Hotel_Shop_Bill_Item::TABLE_ID:
                $result = new Model_Hotel_Shop_Bill_Item();
                break;
            case Model_Hotel_Shop_Bill_Service::TABLE_ID:
                $result = new Model_Hotel_Shop_Bill_Service();
                break;
            case Model_Hotel_Shop_Room_Type::TABLE_ID:
                $result = new Model_Hotel_Shop_Room_Type();
                break;
            case Model_Shop_Operation::TABLE_ID:
                $result = new Model_Shop_Operation();
                break;
            case Model_Hotel_Shop_Feast::TABLE_ID:
                $result = new Model_Hotel_Shop_Feast();
                break;
            case Model_Hotel_Shop_Feast_Day::TABLE_ID:
                $result = new Model_Hotel_Shop_Feast_Day();
                break;
            case Model_Hotel_Shop_Service::TABLE_ID:
                $result = new Model_Hotel_Shop_Service();
                break;
            case Model_Hotel_Shop_Payment::TABLE_ID:
                $result = new Model_Hotel_Shop_Payment();
                break;
            case Model_Hotel_Shop_Consumable::TABLE_ID:
                $result = new Model_Hotel_Shop_Consumable();
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