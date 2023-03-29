<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopPlanItem extends Controller_Ab1_Sales_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Plan_Item';
        $this->controllerName = 'shopplanitem';
        $this->tableID = Model_Ab1_Shop_Plan_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Plan_Item::TABLE_NAME;
        $this->objectName = 'planitem';

        parent::__construct($request, $response);
    }

    public function action_table()
    {
        $this->_sitePageData->url = '/sales/shopplanitem/table';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/item/list/table',
            )
        );

        $clients = Api_Ab1_Shop_Plan_Item::getPlanItemClients(Request_RequestParams::getParamDateTime('date'),
            $this->_sitePageData, $this->_driverDB);

        //Путь для вью шаблона
        $tmp = Helpers_View::getViewPath('_shop/plan/item/list/table', $this->_sitePageData);
        $view = View::factory($tmp);
        $view->clients = $clients;
        $view->siteData = $this->_sitePageData;
        $this->_sitePageData->replaceDatas['view::_shop/plan/item/list/table'] = Helpers_View::viewToStr($view);

        $this->_putInMain('/main/_shop/plan/item/table');
    }

    public function action_reason()
    {
        $this->_sitePageData->url = '/sales/shopplanitem/reason';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/item/list/reason',
            )
        );

        $this->_requestPlanReasonTypes();

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'date' => 'desc',
                    'shop_client_id.name' => 'asc',
                ),
                'limit_page' => 25,
            ),
            FALSE
        );
        $elements = array('shop_client_id' => array('name'), 'shop_product_id' => array('name'));
        $shopPlanItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Plan_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );

        $this->_sitePageData->replaceDatas['view::_shop/plan/item/list/reason'] = Helpers_View::getViewObjects(
            $shopPlanItemIDs, new Model_Ab1_Shop_Plan_Item(),
            '_shop/plan/item/list/reason', '_shop/plan/item/one/reason',
            $this->_sitePageData, $this->_driverDB, 0,
            TRUE, $elements
        );

        $this->_putInMain('/main/_shop/plan/item/reason');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopplanitem/save';

        $result = Api_Ab1_Shop_Plan_Item::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_quantity_fact()
    {
        $this->_sitePageData->url = '/sales/shopplanitem/calc_quantity_fact';

        $date = Request_RequestParams::getParamDateTime('date');
        Api_Ab1_Shop_Plan_Item::calcQuantityFact($date, $this->_sitePageData, $this->_driverDB);

        self::redirect('/sales/shopplanitem/reason?date='.$date);
    }
}
