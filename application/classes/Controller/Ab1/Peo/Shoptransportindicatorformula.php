<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportIndicatorFormula extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Indicator_Formula';
        $this->controllerName = 'shoptransportindicatorformula';
        $this->tableID = Model_Ab1_Shop_Transport_Indicator_Formula::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Indicator_Formula::TABLE_NAME;
        $this->objectName = 'transportindicatorformula';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shoptransportindicatorformula/index';

        $this->_requestListDB('DB_Ab1_Indicator_FormulaType');

        parent::_actionIndex(
            array(
                'indicator_formula_type_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/peo/shoptransportindicatorformula/new';

        $this->_requestListDB('DB_Ab1_Indicator_FormulaType');

        $this->_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shoptransportindicatorformula/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Indicator_Formula();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }
        $this->_requestListDB('DB_Ab1_Indicator_FormulaType', $model->getIndicatorFormulaTypeID());

        $this->_actionEdit($model, $this->_sitePageData->shopMainID);
    }
}

