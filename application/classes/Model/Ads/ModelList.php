<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ads_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Ads_Shop_Client::TABLE_ID:
                $result = new Model_Ads_Shop_Client();
                break;
            case Model_Ads_ParcelStatus::TABLE_ID:
                $result = new Model_Ads_ParcelStatus();
                break;
            case Model_Ads_Shop_Invoice::TABLE_ID:
                $result = new Model_Ads_Shop_Invoice();
                break;
            case Model_Ads_Shop_Parcel::TABLE_ID:
                $result = new Model_Ads_Shop_Parcel();
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