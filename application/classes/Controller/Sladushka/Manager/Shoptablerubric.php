<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopTableRubric extends Controller_Sladushka_Manager_File {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptablerubric';
        $this->tableID = Model_Shop_Table_Rubric::TABLE_ID;
        $this->tableName = Model_Shop_Table_Rubric::TABLE_NAME;
        $this->objectName = 'rubric';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/manager/shoptablerubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/index',
            )
        );

        $tableID = intval(Request_RequestParams::getParamInt('table_id'));

        $typeID = intval(Request_RequestParams::getParamInt('type'));
        if ($typeID > 0) {
            // получаем товары
            $model = new Model_Shop_Table_Catalog();
            $model->setDBDriver($this->_driverDB);
            if(! $this->getDBObject($model,$typeID)){
                throw new HTTP_Exception_404('Table rubric not is found!');
            }
            $this->_sitePageData->replaceDatas['view::type'] = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        }else{
            $this->_sitePageData->replaceDatas['view::type'] = array();
        }

        // получаем список
        View_View::find('DB_Shop_Table_Rubric', $this->_sitePageData->shopID,
            "_shop/_table/rubric/list/index", "_shop/_table/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, array('type' => $typeID, 'table_id' => $tableID, 'is_list' => TRUE));

        $this->_putInMain('/main/_shop/_table/rubric/index');
    }
}
