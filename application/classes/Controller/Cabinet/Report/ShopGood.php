<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Report_ShopGood extends Controller_Cabinet_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->tableID = Model_Shop_Good::TABLE_ID;
        $this->tableName = Model_Shop_Good::TABLE_NAME;
        $this->objectName = 'report';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_bill(){
        $this->_sitePageData->url = '/cabinet/shopreport/good/bill';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_report/shop/bill/item/list/good/bill',
            )
        );
        // тип объекта
        $this->_getType();
        $this->_requestShopBranch();
        $this->_requestShopOperation(NULL, TRUE);

        $params = array('limit_page' => 25);
        if(key_exists('group_by', $_GET)){
            $_GET['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
            $params['sum_count'] = TRUE;
        }
        if(key_exists('group_by', $_POST)){
            $_POST['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
            $params['sum_count'] = TRUE;
        }
        View_View::find('DB_Shop_Bill_Item', $this->_sitePageData->shopID, '_report/shop/bill/item/list/good/bill',
            '_report/shop/bill/item/one/good/bill', $this->_sitePageData, $this->_driverDB, $params,
            array('shop_good_id', 'create_user_id', 'shop_root_id'));


        $this->_putInMain('/_report/main/shop/good/bill/index');
    }

    public function action_return(){
        $this->_sitePageData->url = '/cabinet/shopreport/good/return';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_report/shop/return/item/list/good/return',
            )
        );
        // тип объекта
        $this->_getType();
        $this->_requestShopBranch();
        $this->_requestShopOperation(NULL, TRUE);

        $params = array('limit_page' => 25);
        if(key_exists('group_by', $_GET)){
            $_GET['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
            $params['sum_count'] = TRUE;
        }
        if(key_exists('group_by', $_POST)){
            $_POST['group_by'][] = 'shop_table_catalog_id';
            $params['sum_amount'] = TRUE;
            $params['sum_count'] = TRUE;
        }
        View_View::find('DB_Shop_Return_Item', $this->_sitePageData->shopID, '_report/shop/return/item/list/good/return',
            '_report/shop/return/item/one/good/return', $this->_sitePageData, $this->_driverDB, $params,
            array('shop_good_id', 'create_user_id', 'shop_root_id'));


        $this->_putInMain('/_report/main/shop/good/return/index');
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
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
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
