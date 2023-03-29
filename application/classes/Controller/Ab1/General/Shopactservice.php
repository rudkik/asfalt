<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopActService extends Controller_Ab1_General_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Act_Service';
        $this->controllerName = 'shopactservice';
        $this->tableID = Model_Ab1_Shop_Act_Service::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Act_Service::TABLE_NAME;
        $this->objectName = 'actservice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/general/shopactservice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/service/list/index',
            )
        );

        $this->_requestShopProducts();
        $this->_requestActServicePaidTypes();
        $this->_requestCheckTypes(Request_RequestParams::getParamInt('check_type_id'));

        if(Request_RequestParams::getParamBoolean('is_last_day')){
            $params = Request_RequestParams::setParams(
                array(
                    'limit' => 1000, 'limit_page' => 25,
                    'date' => Helpers_DateTime::minusDays(date('Y-m-d'), 9),
                    'is_send_esf' => Request_RequestParams::getParamBoolean('is_send_esf'),
                ),
                FALSE
            );
        }else{
            $params = array('limit' => 1000, 'limit_page' => 25);
        }

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopMainID,
            "_shop/act/service/list/index", "_shop/act/service/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_client_attorney_id' => array('number'),
                'shop_client_contract_id' => array('number'),
                'act_service_paid_type_id' => array('name'),
                'shop_delivery_department_id' => array('name'),
                'product_type_id' => array('name'),
                'check_type_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/act/service/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/general/shopactservice/edit';
        $this->_actionShopActServiceEdit();
    }

    /**
     * Заново перестраиваем Акт выполненных работ, добавляем за выбранный период дополнительные услуги
     * @throws HTTP_Exception_404
     */
    public function action_rebuild()
    {
        $this->_sitePageData->url = '/general/shopactservice/rebuild';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        Api_Ab1_Shop_Act_Service::rebuild($id, $this->_sitePageData, $this->_driverDB);

        self::redirect(
            '/sbyt/shopactservice/edit'
            . URL::query(
                array(
                    'id' => $id,
                ), FALSE
            )
        );
    }
}