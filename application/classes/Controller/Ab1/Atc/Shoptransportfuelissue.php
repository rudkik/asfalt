<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportFuelIssue extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Fuel_Issue';
        $this->controllerName = 'shoptransportfuelissue';
        $this->tableID = Model_Ab1_Shop_Transport_Fuel_Issue::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Fuel_Issue::TABLE_NAME;
        $this->objectName = 'transportfuelissue';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportfuelissue/index';
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestShopBranches(null, true);

        $this->_actionIndex(
            array(
                'fuel_id' => array('name'),
                'shop_id' => array('name'),
                'shop_client_id' => array('name'),
            ),
            array(),
            0
        );
    }

    public function action_new() {
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Shop_Client');
        $this->_requestShopBranches($this->_sitePageData->shopID, true);
        $this->_actionNew();
    }

    public function action_edit() {
        $this->_sitePageData->url = '/atc/shoptransportfuelissue/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Fuel_Issue();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Fuel', $model->getFuelID());
        $this->_requestListDB('DB_Ab1_Shop_Client', $model->getShopClientID());
        $this->_requestShopBranches($model->shopID, true);

        $this->_actionEdit($model, $model->shopID);
    }
}

