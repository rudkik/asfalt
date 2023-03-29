<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Bookkeeping_ShopOperation extends Controller_Nur_Bookkeeping_BasicNur {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopoperation';
        $this->tableID = Model_Shop_Operation::TABLE_ID;
        $this->tableName = Model_Shop_Operation::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nur-bookkeeping/shopoperation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/index',
            )
        );

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'is_main_shop' => FALSE,
                'limit_page' => 25,
                'shop_table_rubric_id' => Model_Nur_Shop_Operation::RUBRIC_ADMIN,
            ),
            TRUE
        );
        View_View::findBranch('DB_Shop_Operation',
            $this->_sitePageData->shopMainID,
            "_shop/operation/list/index", "_shop/operation/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_table_rubric_id' => array('name')),
            TRUE, TRUE

        );

        $this->_putInMain('/main/_shop/operation/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/json';

        $this->_actionJSON(
            'Request_Shop_Operation',
            'findBranchShopOperationIDs',
            array(
                'shop_table_rubric_id' => array('name'),
            ),
            new Model_Nur_Shop_Operation(),
            TRUE
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopoperation/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/new',
            )
        );

        $this->_requestShopTableRubric(Model_Shop_Operation::TABLE_ID);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/operation/one/new'] = Helpers_View::getViewObject($dataID, new Model_Shop_Operation(),
            '_shop/operation/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/operation/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopoperation/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop_Operation();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Operation not is found!');
        }
        $this->_requestShopTableRubric(Model_Shop_Operation::TABLE_ID, $model->getShopTableRubricID());

        // получаем данные
        View_View::findOne('DB_Shop_Operation',
            $this->_sitePageData->shopID, "_shop/operation/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/operation/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopoperation/save';

        $result = Api_Shop_Operation::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
