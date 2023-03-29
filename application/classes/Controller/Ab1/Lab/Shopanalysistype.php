<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopAnalysisType extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Analysis_Type';
        $this->controllerName = 'shopanalysistype';
        $this->tableID = Model_Ab1_Shop_Analysis_Type::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Analysis_Type::TABLE_NAME;
        $this->objectName = 'analysistype';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
    }

    public function action_new() {
        $this->_sitePageData->url = '/lab/shopanalysistype/new';

        $this->_requestListDB('DB_Table', NULL, 0, array(), null, 'list', 'title');

        parent::_actionNew();
    }

    public function action_edit() {
        $this->_sitePageData->url = '/lab/shopanalysistype/edit';

        $this->_requestListDB('DB_Table', NULL, 0, array(), null, 'list', 'title');

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Analysis_Type();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    /**
     * Задать формулу
     */
    public function action_formula_edit()
    {
        $this->_sitePageData->url = '/lab/shopanalysistype/formula_edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Analysis_Type();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_actionFormulaEdit($model, $this->_sitePageData->shopID);

    }

    /**
     * Редактирование записи
     * @param $model
     * @param $shopID
     */
    public function _actionFormulaEdit($model, $shopID)
    {
        $id = $model->id;

        $viewPath = DB_Basic::getViewPath($this->dbObject);

        // получаем данные
        $ids = new MyArray();
        $ids->setValues($model, $this->_sitePageData);

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);

        // выводим связанные записи 1коМногим
        foreach ($this->dbObject::ITEMS as $name => $field) {
            if(!Arr::path($field, 'is_view', false)){
                continue;
            }

            $params = Request_RequestParams::setParams(
                array(
                    $field['field_id'] => $id,
                    'sort_by' => array(
                        'id' => 'asc'
                    ),
                )
            );

            $viewItemPath = DB_Basic::getViewPath($field['table']);
            if(!key_exists('view::' . $viewItemPath . 'list/index', $this->_sitePageData->replaceDatas)) {
                View_View::find(
                    $field['table'], $shopID,
                    $viewItemPath . 'list/index', $viewItemPath . 'one/index',
                    $this->_sitePageData, $this->_driverDB, $params
                );
            }
        }

        $result = Helpers_View::getViewObject(
            $ids, $model, $viewPath . 'one/formula_edit', $this->_sitePageData, $this->_driverDB, $shopID
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::' . $viewPath . 'one/formula_edit',  $result);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/' . $viewPath . 'formula_edit');
    }
}

