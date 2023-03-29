<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopRubricSource extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Rubric_Source';
        $this->controllerName = 'shoprubricsource';
        $this->tableID = Model_AutoPart_Shop_Rubric_Source::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Rubric_Source::TABLE_NAME;
        $this->objectName = 'rubric';

        parent::__construct($request, $response);
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/market/shoprubricsource/index';

        $this->_requestListDB('DB_AutoPart_Shop_Rubric_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Source');

        parent::_actionIndex(
            array(
                'root_id' => array('name'),
                'shop_source_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/market/shoprubricsource/new';

        $this->_requestListDB('DB_AutoPart_Shop_Rubric_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Source');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/market/shoprubricsource/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Rubric_Source();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Rubric_Source', $model->getRootID(), 0, array('id_not' => $model->id));
        $this->_requestListDB('DB_AutoPart_Shop_Source', $model->getShopSourceID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}
