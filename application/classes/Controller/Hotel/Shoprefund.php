<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopRefund extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Refund';
        $this->controllerName = 'shoprefund';
        $this->tableID = Model_Hotel_Shop_Refund::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Refund::TABLE_NAME;
        $this->objectName = 'refund';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shoprefund/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/refund/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, "_shop/refund/list/index",
            "_shop/refund/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/refund/index');
    }

    public function action_json() {
        $this->_getJSONList(
            $this->_sitePageData->shopID,
            [],
            array(
                'shop_client_id' => array('name'),
                'update_user_id' => array('name'),
                'refund_type_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shoprefund/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/refund/one/new',
            )
        );

        $this->_requestShopClients();
        $this->_requestRefundTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/refund/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Refund(),
            '_shop/refund/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shoprefund/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/refund/one/edit',
            )
        );

        // id записи
        $shopRefundID = Request_RequestParams::getParamInt('id');
        if ($shopRefundID === NULL) {
            throw new HTTP_Exception_404('Refund order not is found!');
        }else {
            $model = new Model_Hotel_Shop_Refund();
            if (! $this->dublicateObjectLanguage($model, $shopRefundID)) {
                throw new HTTP_Exception_404('Refund order not is found!');
            }
        }
        $this->_requestShopClients($model->getShopClientID());
        $this->_requestRefundTypes($model->getRefundTypeID());

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, "_shop/refund/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopRefundID), array('gov_client_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shoprefund/save';

        $result = Api_Hotel_Shop_Refund::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'shop_client_name' => array(
                    'id' => 'shop_client_id',
                    'model' => new Model_Hotel_Shop_Client(),
                ),
                'update_user_name' => array(
                    'id' => 'update_user_id',
                    'model' => new Model_User(),
                ),
                'refund_type_name' => array(
                    'id' => 'refund_type_id',
                    'model' => new Model_Hotel_RefundType(),
                ),
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/hotel/shoprefund/del';

        Api_Hotel_Shop_Refund::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
