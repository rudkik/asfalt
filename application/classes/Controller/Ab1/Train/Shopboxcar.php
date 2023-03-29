<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopBoxcar extends Controller_Ab1_Train_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar';
        $this->controllerName = 'shopboxcar';
        $this->tableID = Model_Ab1_Shop_Boxcar::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar::TABLE_NAME;
        $this->objectName = 'boxcar';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/train/shopboxcar/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/index',
            )
        );

        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopRaws();

        // получаем список
        View_View::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID,
            "_shop/boxcar/list/index", "_shop/boxcar/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
                'shop_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/boxcar/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/train/shopboxcar/edit';
        $this->_actionShopBoxcarEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/train/shopboxcar/save';

        $result = Api_Ab1_Shop_Boxcar::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics_total()
    {
        $this->_sitePageData->url = '/train/shopboxcar/statistics_total';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/list/statistics',
            )
        );

        $clients = new MyArray();

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y'));

        $params = Request_RequestParams::setParams(
            array(
                'date_departure_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'sort_by' => array('shop_boxcar_client_id.name' => 'asc'),
                'group_by' => array(
                    'shop_boxcar_client_id', 'shop_boxcar_client_id.name',
                    'shop_raw_id', 'shop_raw_id.name'
                ),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_boxcar_client_id' => array('name'),
                'shop_raw_id' => array('name')
            )
        );

        foreach ($ids->childs as $child){
            $child->values['quantity_year'] = $child->values['quantity'];
            $clients->childs[$child->values['shop_boxcar_client_id'].'_'.$child->values['shop_raw_id']] = $child;
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y'));

        $params = Request_RequestParams::setParams(
            array(
                'date_departure_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'sort_by' => array('shop_boxcar_client_id.name' => 'asc'),
                'group_by' => array('shop_boxcar_client_id', 'shop_raw_id', 'shop_boxcar_client_id.name', 'shop_raw_id.name'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Boxcar',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_boxcar_client_id' => array('name'), 'shop_raw_id' => array('name'))
        );

        foreach ($ids->childs as $child){
            $shopBoxcarClientID = $child->values['shop_boxcar_client_id'].'_'.$child->values['shop_raw_id'];

            if(key_exists($shopBoxcarClientID, $clients->childs)){
                $clients->childs[$shopBoxcarClientID]->values['quantity_month'] = $child->values['quantity'];
            }else {
                $child->values['quantity_month'] = $child->values['quantity'];
                $clients->childs[$shopBoxcarClientID] = $child;
            }
        }

        $this->_sitePageData->countRecord = count($clients->childs);
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/list/statistics'] = Helpers_View::getViewObjects(
            $clients, new Model_Ab1_Shop_Boxcar(),
            '_shop/boxcar/list/statistics','_shop/boxcar/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/boxcar/statistics-total');
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopboxcar/statistics';
        $this->_actionShopBoxcarStatistics();
    }
}
