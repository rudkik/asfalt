<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_ShopModel extends Controller_BasicAdmin{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Model';
        $this->controllerName = 'shopmodel';
        $this->tableID = Model_AutoPart_Shop_Model::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Model::TABLE_NAME;
        $this->objectName = 'model';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'smg/_all';
    }
    public function action_index() {
        $this->_sitePageData->url = '/shopmodel/index';

        $this->_requestListDB('DB_AutoPart_Shop_Mark');

        parent::_actionIndex(
            array(
                'shop_mark_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/shopmodel/new';

        $this->_requestListDB('DB_AutoPart_Shop_Mark');
        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/shopmodel/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Model();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Mark', $model->getShopMarkID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

