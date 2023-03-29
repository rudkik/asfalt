<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Magazine_Shop_Product::TABLE_ID:
                $result = new Model_Magazine_Shop_Product();
                break;
            case Model_Magazine_Shop_Production::TABLE_ID:
                $result = new Model_Magazine_Shop_Production();
                break;
            case Model_Magazine_Shop_Product_Rubric::TABLE_ID:
                $result = new Model_Magazine_Shop_Product_Rubric();
                break;
            case Model_Magazine_Shop_Production_Rubric::TABLE_ID:
                $result = new Model_Magazine_Shop_Production_Rubric();
                break;
            case Model_Magazine_Shop_Card::TABLE_ID:
                $result = new Model_Magazine_Shop_Card();
                break;
            case Model_Ab1_Shop_Worker::TABLE_ID:
                $result = new Model_Ab1_Shop_Worker();
                break;
            case Model_Magazine_Shop_Operation::TABLE_ID:
                $result = new Model_Magazine_Shop_Operation();
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