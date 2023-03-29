<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopAnalysisActType extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Analysis_Act_Type';
        $this->controllerName = 'shopanalysisacttype';
        $this->tableID = Model_Ab1_Shop_Analysis_Act_Type::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Analysis_Act_Type::TABLE_NAME;
        $this->objectName = 'analysisacttype';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
    }

    /**
     * Задать формулу
     */
    public function action_formula_edit()
    {
        $this->_sitePageData->url = '/lab/shopanalysisacttype/formula_edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Analysis_Act_Type();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_actionFormulaEdit($model, $this->_sitePageData->shopID);

    }
}

