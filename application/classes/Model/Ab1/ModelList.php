<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_ModelList {

    public static function createModel($tableID, $driver = NULL){
        switch($tableID){
            case Model_Ab1_Shop_Car::TABLE_ID:
                $result = new Model_Ab1_Shop_Car();
                break;
            case Model_Ab1_Shop_Client::TABLE_ID:
                $result = new Model_Ab1_Shop_Client();
                break;
            case Model_Ab1_Shop_Driver::TABLE_ID:
                $result = new Model_Ab1_Shop_Driver();
                break;
            case Model_Ab1_Shop_Operation::TABLE_ID:
                $result = new Model_Ab1_Shop_Operation();
                break;
            case Model_Ab1_Shop_Payment::TABLE_ID:
                $result = new Model_Ab1_Shop_Payment();
                break;
            case Model_Ab1_Shop_Pricelist::TABLE_ID:
                $result = new Model_Ab1_Shop_Pricelist();
                break;
            case Model_Ab1_Shop_Product::TABLE_ID:
                $result = new Model_Ab1_Shop_Product();
                break;
            case Model_Ab1_Shop_Product_Price::TABLE_ID:
                $result = new Model_Ab1_Shop_Product_Price();
                break;
            case Model_Ab1_Shop_Product_Turn::TABLE_ID:
                $result = new Model_Ab1_Shop_Product_Turn();
                break;
            case Model_Ab1_Shop_Turn::TABLE_ID:
                $result = new Model_Ab1_Shop_Turn();
                break;
            case Model_Ab1_Shop_Turn_Place::TABLE_ID:
                $result = new Model_Ab1_Shop_Turn_Place();
                break;
            case Model_Ab1_Shop_Turn_Type::TABLE_ID:
                $result = new Model_Ab1_Shop_Turn_Type();
                break;
            case Model_Ab1_Shop_Daughter::TABLE_ID:
                $result = new Model_Ab1_Shop_Daughter();
                break;
            case Model_Ab1_Shop_Car_To_Material::TABLE_ID:
                $result = new Model_Ab1_Shop_Car_To_Material();
                break;
            case Model_Ab1_Shop_Material::TABLE_ID:
                $result = new Model_Ab1_Shop_Material();
                break;
            case Model_Ab1_Shop_Move_Car::TABLE_ID:
                $result = new Model_Ab1_Shop_Move_Car();
                break;
            case Model_Ab1_Shop_Defect_Car::TABLE_ID:
                $result = new Model_Ab1_Shop_Defect_Car();
                break;
            case Model_Ab1_Shop_Car_Tare::TABLE_ID:
                $result = new Model_Ab1_Shop_Car_Tare();
                break;
            case Model_Ab1_Shop_Product_Rubric::TABLE_ID:
                $result = new Model_Ab1_Shop_Product_Rubric();
                break;
            case Model_Ab1_Shop_Consumable::TABLE_ID:
                $result = new Model_Ab1_Shop_Consumable();
                break;
            case Model_Ab1_Shop_Competitor::TABLE_ID:
                $result = new Model_Ab1_Shop_Competitor();
                break;
            case Model_Ab1_Shop_Competitor_Price::TABLE_ID:
                $result = new Model_Ab1_Shop_Competitor_Price();
                break;
            case Model_Ab1_Shop_Supplier::TABLE_ID:
                $result = new Model_Ab1_Shop_Supplier();
                break;
            case Model_Ab1_Shop_Supplier_Price::TABLE_ID:
                $result = new Model_Ab1_Shop_Supplier_Price();
                break;
            case Model_Ab1_Shop_Piece::TABLE_ID:
                $result = new Model_Ab1_Shop_Piece();
                break;
            case Model_Ab1_Shop_Piece_Item::TABLE_ID:
                $result = new Model_Ab1_Shop_Piece_Item();
                break;
            case Model_Ab1_Shop_Ballast_Driver::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast_Driver();
                break;
            case Model_Ab1_Shop_Ballast_Car::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast_Car();
                break;
            case Model_Ab1_Shop_Ballast::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast();
                break;
            case Model_Ab1_Shop_Raw::TABLE_ID:
                $result = new Model_Ab1_Shop_Raw();
                break;
            case Model_Ab1_Shop_Formula_Material::TABLE_ID:
                $result = new Model_Ab1_Shop_Formula_Material();
                break;
            case Model_Ab1_Shop_Formula_Product::TABLE_ID:
                $result = new Model_Ab1_Shop_Formula_Product();
                break;
            case Model_Ab1_Shop_Boxcar::TABLE_ID:
                $result = new Model_Ab1_Shop_Boxcar();
                break;
            case Model_Ab1_Shop_Boxcar_Client::TABLE_ID:
                $result = new Model_Ab1_Shop_Boxcar_Client();
                break;
            case Model_Ab1_Shop_Boxcar_Departure_Station::TABLE_ID:
                $result = new Model_Ab1_Shop_Boxcar_Departure_Station();
                break;
            case Model_Ab1_Shop_Move_Other::TABLE_ID:
                $result = new Model_Ab1_Shop_Move_Other();
                break;
            case Model_Ab1_Shop_Move_Place::TABLE_ID:
                $result = new Model_Ab1_Shop_Move_Place();
                break;
            case Model_Ab1_Shop_Move_Client::TABLE_ID:
                $result = new Model_Ab1_Shop_Move_Client();
                break;
            case Model_Ab1_Shop_Ballast_Crusher::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast_Crusher();
                break;
            case Model_Ab1_Shop_Ballast_Car_To_Driver::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast_Car_To_Driver();
                break;
            case Model_Ab1_Shop_Ballast_Distance::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast_Distance();
                break;
            case Model_Ab1_Shop_Ballast_Distance_Tariff::TABLE_ID:
                $result = new Model_Ab1_Shop_Ballast_Distance_Tariff();
                break;
            case Model_Ab1_Shop_Delivery_Group::TABLE_ID:
                $result = new Model_Ab1_Shop_Delivery_Group();
                break;
            case Model_Ab1_Shop_Delivery_Department::TABLE_ID:
                $result = new Model_Ab1_Shop_Delivery_Department();
                break;
            case Model_Ab1_Shop_Transport_Company::TABLE_ID:
                $result = new Model_Ab1_Shop_Transport_Company();
                break;
            case Model_Ab1_Shop_Heap::TABLE_ID:
                $result = new Model_Ab1_Shop_Heap();
                break;
            case Model_Ab1_Shop_Subdivision::TABLE_ID:
                $result = new Model_Ab1_Shop_Subdivision();
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