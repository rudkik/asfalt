<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopProductionRubric extends Controller_Magazine_Accounting_BasicMagazine
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Production_Rubric';
        $this->controllerName = 'shopproductionrubric';
        $this->tableID = Model_Magazine_Shop_Production_Rubric::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Production_Rubric::TABLE_NAME;
        $this->objectName = 'productionrubric';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/accounting/shopproductionrubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/rubric/list/index',
            )
        );
        $this->_requestShopProductionRubrics();

        // получаем список
        View_View::find('DB_Magazine_Shop_Production_Rubric', $this->_sitePageData->shopMainID, "_shop/production/rubric/list/index", "_shop/production/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/production/rubric/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/accounting/shopproductionrubric/list';

        // получаем список
        $this->response->body(View_View::find('DB_Magazine_Shop_Production_Rubric', $this->_sitePageData->shopMainID,
            "_shop/production/rubric/list/list", "_shop/production/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopproductionrubric/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/rubric/one/new',
            )
        );

        $this->_requestShopProductionRubrics();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/production/rubric/one/new'] = Helpers_View::getViewObject($dataID, new Model_Magazine_Shop_Production_Rubric(),
            '_shop/production/rubric/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/production/rubric/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopproductionrubric/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/rubric/one/edit',
            )
        );

        // id записи
        $shopProductionRubricID = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Production_Rubric();
        if (!$this->dublicateObjectLanguage($model, $shopProductionRubricID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Rubric production not is found!');
        }

        $this->_requestShopProductionRubrics();

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Production_Rubric', $this->_sitePageData->shopMainID, "_shop/production/rubric/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/production/rubric/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopproductionrubric/save';

        $result = Api_Magazine_Shop_Production_Rubric::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
