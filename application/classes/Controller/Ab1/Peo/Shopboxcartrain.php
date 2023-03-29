<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopBoxcarTrain extends Controller_Ab1_Peo_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar_Train';
        $this->controllerName = 'shopboxcartrain';
        $this->tableID = Model_Ab1_Shop_Boxcar_Train::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar_Train::TABLE_NAME;
        $this->objectName = 'boxcartrain';

        parent::__construct($request, $response);
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shopboxcartrain/edit';
        $this->_actionShopBoxcarTrainEdit();
    }
}
