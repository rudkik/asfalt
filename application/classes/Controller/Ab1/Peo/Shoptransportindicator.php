<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportIndicator extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Indicator';
        $this->controllerName = 'shoptransportindicator';
        $this->tableID = Model_Ab1_Shop_Transport_Indicator::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Indicator::TABLE_NAME;
        $this->objectName = 'transportindicator';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shoptransportindicator/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Work');

        parent::_actionIndex(
            array(
                'shop_worker_id' => array('name'),
                'shop_branch_from_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/peo/shoptransportindicator/new';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Work');

        $this->_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shoptransportindicator/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Indicator();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Transport_Work', $model->getShopTransportWorkID());

        $this->_actionEdit($model, $this->_sitePageData->shopMainID);
    }
}

