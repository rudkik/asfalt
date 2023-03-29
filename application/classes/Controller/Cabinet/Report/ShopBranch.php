<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Report_ShopBranch extends Controller_Cabinet_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'report';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

	public function action_paid() {
		$this->_sitePageData->url = '/cabinet/shopreport/branch/paid';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::_report/shop/paid/list/branch/paid',
			)
		);

		// тип объекта
		$type = $this->_getType();
        $this->_requestShopTableRubric($type['id']);
        $this->_requestShopOperation();
        $this->_requestShopBranch();

        $params = array('limit_page' => 25);
        if(key_exists('group_by', $_GET)){
            $_GET['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
        }
        if(key_exists('group_by', $_POST)){
            $_POST['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
        }

		// получаем список
        View_View::find('DB_Shop_Paid', $this->_sitePageData->shopID, "_report/shop/paid/list/branch/paid", "_report/shop/paid/one/branch/paid",
			$this->_sitePageData, $this->_driverDB, $params, array('paid_shop_id', 'shop_operation_id'));

		$this->_putInMain('/_report/main/shop/branch/paid/index');
	}

    public function action_bill(){
        $this->_sitePageData->url = '/cabinet/shopreport/branch/bill';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_report/shop/bill/list/branch/bill',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopBillStatus();
        $this->_requestShopBranch();
        $this->_requestShopOperation(NULL, TRUE);

        $params = array('limit_page' => 25);
        if(key_exists('group_by', $_GET)){
            $_GET['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
        }
        if(key_exists('group_by', $_POST)){
            $_POST['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
        }

        View_View::find('DB_Shop_Bill', $this->_sitePageData->shopID, '_report/shop/bill/list/branch/bill', '_report/shop/bill/one/branch/bill',
            $this->_sitePageData, $this->_driverDB, $params, array('shop_root_id', 'create_user_id'));

        $this->_putInMain('/_report/main/shop/branch/bill/index');
    }

    public function action_return(){
        $this->_sitePageData->url = '/cabinet/shopreport/branch/return';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_report/shop/return/list/branch/return',
            )
        );

        // тип объекта
        $type = $this->_getType();
        $this->_requestShopBranch();
        $this->_requestShopOperation(NULL, TRUE);

        $params = array('limit_page' => 25);
        if(key_exists('group_by', $_GET)){
            $_GET['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
        }
        if(key_exists('group_by', $_POST)){
            $_POST['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
        }

        View_View::find('DB_Shop_Return', $this->_sitePageData->shopID, '_report/shop/return/list/branch/return', '_report/shop/return/one/branch/return',
            $this->_sitePageData, $this->_driverDB, $params, array('shop_root_id', 'create_user_id'));

        $this->_putInMain('/_report/main/shop/branch/return/index');
    }


    /**
     * Делаем запрос на список брендов
     * @param array $type
     * @return string
     */
    protected function _requestShopBillStatus($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/status/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Bill_Status', $this->_sitePageData->shopID,
            "_shop/bill/status/list/list", "_shop/bill/status/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/bill/status/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список филиалов
     * @param array $type
     * @return string
     */
    protected function _requestShopBranch($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/list',
            )
        );

        $data = View_View::find('DB_Shop', $this->_sitePageData->shopID,
            "_shop/branch/list/list", "_shop/branch/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('order' => 'asc', 'name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список операторов
     * @param array $type
     * @return string
     */
    protected function _requestShopOperation($currentID = NULL, $isUserID = FALSE){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/list',
            )
        );

        if($isUserID){
            $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
                "_shop/operation/list/user", "_shop/operation/one/user", $this->_sitePageData, $this->_driverDB,
                array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        }else {
            $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
                "_shop/operation/list/list", "_shop/operation/one/list", $this->_sitePageData, $this->_driverDB,
                array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        }

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
        }

        return $data;
    }
}
