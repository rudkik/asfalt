<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ogm_ShopCar extends Controller_Ab1_Ogm_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car';
        $this->controllerName = 'shopcar';
        $this->tableID = Model_Ab1_Shop_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car::TABLE_NAME;
        $this->objectName = 'car';

        parent::__construct($request, $response);
    }

    public function action_asu()
    {
        $this->_sitePageData->url = '/ogm/shopcar/asu';
        $this->_actionASU();
    }

    public function action_asu_cars()
    {
        $this->_sitePageData->url = '/ogm/shopcar/asu_cars';
        $this->_actionASUCars();
    }
}
