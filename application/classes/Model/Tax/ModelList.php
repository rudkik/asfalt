<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tax_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Tax_Shop_Bank_Account::TABLE_ID:
                $result = new Model_Tax_Shop_Bank_Account();
                break;
            case Model_Tax_Shop_Contractor::TABLE_ID:
                $result = new Model_Tax_Shop_Contractor();
                break;
            case Model_Tax_Shop_Contract::TABLE_ID:
                $result = new Model_Tax_Shop_Contract();
                break;
            case Model_Tax_Shop_Attorney::TABLE_ID:
                $result = new Model_Tax_Shop_Attorney();
                break;
            case Model_Tax_Shop_Invoice_Commercial::TABLE_ID:
                $result = new Model_Tax_Shop_Invoice_Commercial();
                break;
            case Model_Tax_Shop_Invoice_Proforma::TABLE_ID:
                $result = new Model_Tax_Shop_Invoice_Proforma();
                break;
            case Model_Tax_Shop_Product::TABLE_ID:
                $result = new Model_Tax_Shop_Product();
                break;
            case Model_Tax_Shop_Worker::TABLE_ID:
                $result = new Model_Tax_Shop_Worker();
                break;
            case Model_Tax_Shop_Worker_Wage::TABLE_ID:
                $result = new Model_Tax_Shop_Worker_Wage();
                break;
            case Model_Tax_Shop_Tax_Return_910::TABLE_ID:
                $result = new Model_Tax_Shop_Tax_Return_910();
                break;
            case Model_Tax_Shop_Invoice_Commercial_Item::TABLE_ID:
                $result = new Model_Tax_Shop_Invoice_Commercial_Item();
                break;
            case Model_Tax_Shop_Invoice_Proforma_Item::TABLE_ID:
                $result = new Model_Tax_Shop_Invoice_Proforma_Item();
                break;
            case Model_Tax_Shop_My_Attorney::TABLE_ID:
                $result = new Model_Tax_Shop_My_Attorney();
                break;
            case Model_Tax_Shop_Payment_Order::TABLE_ID:
                $result = new Model_Tax_Shop_Payment_Order();
                break;
            case Model_Tax_Shop_Payment_Order_Item::TABLE_ID:
                $result = new Model_Tax_Shop_Payment_Order_Item();
                break;
            case Model_Tax_Shop_My_Invoice::TABLE_ID:
                $result = new Model_Tax_Shop_My_Invoice();
                break;
            case Model_Tax_Shop_My_Invoice_Item::TABLE_ID:
                $result = new Model_Tax_Shop_My_Invoice_Item();
                break;
            case Model_Tax_Shop_Act_Revise::TABLE_ID:
                $result = new Model_Tax_Shop_Act_Revise();
                break;
            case Model_Tax_Shop_Money::TABLE_ID:
                $result = new Model_Tax_Shop_Money();
                break;
            case Model_Tax_Shop_Bill::TABLE_ID:
                $result = new Model_Tax_Shop_Bill();
                break;
            case Model_Tax_Shop_Work_Time::TABLE_ID:
                $result = new Model_Tax_Shop_Work_Time();
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