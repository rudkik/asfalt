<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportRepair extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Repair';
        $this->controllerName = 'shoptransportrepair';
        $this->tableID = Model_Ab1_Shop_Transport_Repair::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Repair::TABLE_NAME;
        $this->objectName = 'transportrepair';

        parent::__construct($request, $response);
        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportrepair/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Repair');
        $this->_requestShopTransports();
        $this->_requestShopListDB(DB_Ab1_Shop_Subdivision::NAME);

        parent::_actionIndex(
            array(
                'shop_transport_driver_id' => array('name'),
                'shop_transport_id' => array('name'),
                'update_user_id' => array('name'),
                'create_user_id' => array('name'),
            ),
            [], $this->_sitePageData->shopID
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/atc/shoptransportrepair/new';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestShopTransports();
        $this->_requestShopListDB(DB_Ab1_Shop_Subdivision::NAME, [442007, 442662, 442661]);

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shoptransportrepair/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Repair();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver', $model->getShopTransportDriverID());
        $this->_requestListDB('DB_Ab1_Shop_Transport', $model->getShopTransportID());
        $this->_requestShopListDB(DB_Ab1_Shop_Subdivision::NAME, $model->getShopSubdivisionID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

