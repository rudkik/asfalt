<?php defined('SYSPATH') or die('No direct script access.');

class Model_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Shop_Comment::TABLE_ID:
                $result = new Model_Shop_Comment();
                break;
            case Model_Shop_Table_Hashtag::TABLE_ID:
                $result = new Model_Shop_Table_Hashtag();
                break;
            case Model_Shop_Table_Rubric::TABLE_ID:
                $result = new Model_Shop_Table_Rubric();
                break;
            case Model_Shop_Table_Filter::TABLE_ID:
                $result = new Model_Shop_Table_Filter();
                break;
            case Model_Shop_Table_Unit::TABLE_ID:
                $result = new Model_Shop_Table_Unit();
                break;
            case Model_Shop_Table_Select::TABLE_ID:
                $result = new Model_Shop_Table_Select();
                break;
            case Model_Shop_Table_Child::TABLE_ID:
                $result = new Model_Shop_Table_Child();
                break;
            case Model_Shop_Good::TABLE_ID:
                $result = new Model_Shop_Good();
                break;
            case Model_Shop_New::TABLE_ID:
                $result = new Model_Shop_New();
                break;
            case Model_Shop_File::TABLE_ID:
                $result = new Model_Shop_File();
                break;
            case Model_Shop_Calendar::TABLE_ID:
                $result = new Model_Shop_Calendar();
                break;
            case Model_Shop_Operation::TABLE_ID:
                $result = new Model_Shop_Operation();
                break;
            case Model_Shop_PaidType::TABLE_ID:
                $result = new Model_Shop_PaidType();
                break;
            case Model_Shop_Gallery::TABLE_ID:
                $result = new Model_Shop_Gallery();
                break;
            case Model_Shop_Coupon::TABLE_ID:
                $result = new Model_Shop_Coupon();
                break;
            case Model_Shop_Client::TABLE_ID:
                $result = new Model_Shop_Client();
                break;
            case Model_Shop::TABLE_ID:
                $result = new Model_Shop();
                break;
            case Model_Shop_Question::TABLE_ID:
                $result = new Model_Shop_Question();
                break;
            case Model_Shop_EMail::TABLE_ID:
                $result = new Model_Shop_EMail();
                break;
            case Model_Shop_AddressContact::TABLE_ID:
                $result = new Model_Shop_AddressContact();
                break;
            case Model_Shop_Address::TABLE_ID:
                $result = new Model_Shop_Address();
                break;
            case Model_Shop_Table_Stock::TABLE_ID:
                $result = new Model_Shop_Table_Stock();
                break;
            case Model_Shop_Table_Revision::TABLE_ID:
                $result = new Model_Shop_Table_Revision();
                break;
            case Model_City::TABLE_ID:
                $result = new Model_City();
                break;
            case Model_Land::TABLE_ID:
                $result = new Model_Land();
                break;
            case Model_Region::TABLE_ID:
                $result = new Model_Region();
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