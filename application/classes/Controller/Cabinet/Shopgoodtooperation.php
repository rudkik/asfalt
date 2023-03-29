<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopGoodToOperation extends Controller_Cabinet_File {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Good_To_Operation';
        $this->controllerName = 'shopgoodtooperation';
        $this->tableID = Model_Shop_Good_To_Operation::TABLE_ID;
        $this->tableName = Model_Shop_Good_To_Operation::TABLE_NAME;
        $this->objectName = 'goodtooperation';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopgoodtooperation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/to/operation/list/index',
            )
        );

        $this->_requestShopGood();
        $this->_requestShopOperation();

        // получаем список
        View_View::find('DB_Shop_Good_To_Operation', $this->_sitePageData->shopID, "_shop/good/to/operation/list/index", "_shop/good/to/operation/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('shop_good_id', 'shop_operation_id'));

        $this->_putInMain('/main/_shop/good/to/operation/index');
    }

    public function action_new_operation()
    {
        $this->_sitePageData->url = '/cabinet/shopgoodtooperation/new_operation';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/to/operation/one/new/operation',
                'view::_shop/good/list/price/operation',
            )
        );

        $this->_requestShopOperation();

        // получаем список
        View_View::find('DB_Shop_Good', $this->_sitePageData->shopID, "_shop/good/list/price/operation", "_shop/good/one/price/operation",
            $this->_sitePageData, $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/good/to/operation/one/new/operation'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/to/operation/one/new/operation', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/to/operation/new/operation');
    }

    public function action_new_good()
    {
        $this->_sitePageData->url = '/cabinet/shopgoodtooperation/new_good';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/to/operation/one/new/good',
                'view::_shop/operation/list/price/good',
            )
        );

        $this->_requestShopGood();

        // получаем список
        View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID, "_shop/operation/list/price/good", "_shop/operation/one/price/good",
            $this->_sitePageData, $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/good/to/operation/one/new/good'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/to/operation/one/new/good', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/to/operation/new/good');
    }

    public function action_edit_operation()
    {
        $this->_sitePageData->url = '/cabinet/shopgoodtooperation/edit_operation';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/to/operation/one/edit/operation',
                '_shop/good/list/price/operation',
            )
        );

        $shopOperationID = Request_RequestParams::getParamInt('id');

        $this->_requestShopOperation($shopOperationID);

        // получаем список
        $goodToOperationIDs = Request_Request::find('DB_Shop_Good_To_Operation', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_operation_id' => $shopOperationID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $shopGoodIDs = Request_Request::find('DB_Shop_Good',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        foreach($shopGoodIDs->childs as $shopGoodID){
            $tmp = $goodToOperationIDs->findChildValue('shop_good_id', $shopGoodID->id);
            if($tmp !== FALSE){
                $shopGoodID->additionDatas['price'] = $tmp->values['price'];
            }
        }

        $model = new Model_Shop_Good();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/good/list/price/operation'] =
            Helpers_View::getViewObjects($shopGoodIDs, $model, "_shop/good/list/price/operation", "_shop/good/one/price/operation",
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/good/to/operation/one/edit/operation'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/to/operation/one/edit/operation', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/to/operation/edit/operation');
    }

    public function action_edit_good()
    {
        $this->_sitePageData->url = '/cabinet/shopgoodtooperation/edit_good';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/to/operation/one/edit/good',
                '_shop/operation/list/price/good',
            )
        );

        $shopGoodID = Request_RequestParams::getParamInt('id');

        $this->_requestShopGood($shopGoodID);

        // получаем список
        $goodToOperationIDs = Request_Request::find('DB_Shop_Good_To_Operation', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_good_id' => $shopGoodID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $shopOperationIDs = Request_Request::find('DB_Shop_Operation',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        foreach($shopOperationIDs->childs as $shopOperationID){
            $tmp = $goodToOperationIDs->findChildValue('shop_operation_id', $shopOperationID->id);
            if($tmp !== FALSE){
                $shopOperationID->additionDatas['price'] = $tmp->values['price'];
            }
        }

        $model = new Model_Shop_Operation();
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::_shop/operation/list/price/good'] =
            Helpers_View::getViewObjects($shopOperationIDs, $model, "_shop/operation/list/price/good", "_shop/operation/one/price/good",
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/good/to/operation/one/edit/good'] = Helpers_View::getViewObject($dataID, new Model_Shop_Good(),
            '_shop/good/to/operation/one/edit/good', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/good/to/operation/edit/good');
    }

    public function action_save_operation()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/save_operation';
        $result = Api_Shop_Good_To_Operation::saveOperation($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_good()
    {
        $this->_sitePageData->url = '/cabinet/shopgood/save_good';
        $result = Api_Shop_Good_To_Operation::saveGood($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Делаем запрос на список товаров
     * @param null $currentID
     */
    protected function _requestShopGood($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/good/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Good', $this->_sitePageData->shopID,
            "_shop/good/list/list", "_shop/good/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/good/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список операторов
     * @param null $currentID
     */
    protected function _requestShopOperation($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/list',
            )
        );

        $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
            "_shop/operation/list/list", "_shop/operation/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
        }
    }
}
