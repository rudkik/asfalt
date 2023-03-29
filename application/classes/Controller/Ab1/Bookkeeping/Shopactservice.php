<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopActService extends Controller_Ab1_Bookkeeping_BasicAb1 {

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
        $this->_sitePageData->url = '/bookkeeping/shopactservice/index';

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

    public function action_add() {
        $this->_sitePageData->url = '/bookkeeping/shopactservice/add';

        $date = Request_RequestParams::getParamDateTime('date');
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');

        $result = Api_Ab1_Shop_Act_Service::addActService(
            $shopClientID, $shopClientContractID, $shopClientAttorneyID, $date, $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB
        );

        if($result === FALSE) {
            throw new HTTP_Exception_500('Cars not found.');
        }

        self::redirect(
            '/bookkeeping/shopactservice/edit'
            . URL::query(
                array(
                    'id' => $result->id,
                ), FALSE
            )
        );
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shopactservice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/service/one/edit',
                'view::_shop/act/service/item/list/index',
                'view::_shop/act/service/item/list/addition-service',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Act_Service();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Act service not is found!');
        }

        $this->_requestShopClientAttorney($model->getShopClientID());
        $this->_requestActServicePaidTypes($model->getActServicePaidTypeID());
        $this->_requestShopClientContract($model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);
        $this->_requestShopClientAttorney($model->getShopClientID(), $model->getShopClientAttorneyID(), 'option');
        $this->_requestShopDeliveryDepartments($model->getShopDeliveryDepartmentID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_service_id' => $id,
            )
        );

        // получаем список реализации
        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_delivery_id' => array('name'),
            )
        );
        $shopCarIDs->addAdditionDataChilds(array('is_car' => TRUE));

        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_delivery_id' => array('name'),
            )
        );
        $shopPieceIDs->addAdditionDataChilds(array('is_piece' => TRUE));

        if (empty($shopCarIDs->childs)) {
            $shopCarIDs->childs = $shopPieceIDs->childs;
        } elseif (!empty($shopPieceIDs->childs)) {
            $shopCarIDs->childs = array_merge($shopCarIDs->childs, $shopPieceIDs->childs);
        }

        $shopCarIDs->childsSortBy(array(Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.name', 'quantity'));

        $this->_sitePageData->replaceDatas['view::_shop/act/service/item/list/index'] = Helpers_View::getViewObjects(
            $shopCarIDs, new Model_Ab1_Shop_Car(),
            '_shop/act/service/item/list/index', '_shop/act/service/item/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        // список дополнительный услуг
        View_View::find('DB_Ab1_Shop_Addition_Service_Item',
            $this->_sitePageData->shopID,
            '_shop/act/service/item/list/addition-service', '_shop/act/service/item/one/addition-service',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_id' => array('name'),
                'shop_car_id' => array('ticket', 'name', 'id'),
                'shop_piece_id' => array('ticket', 'name', 'id'),
            )
        );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID, "_shop/act/service/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id),
            array(
                'shop_client_id',
                'shop_client_contract_id'
            )
        );

        $this->_putInMain('/main/_shop/act/service/edit');
    }

    /**
     * Заново перестраиваем Акт выполненных работ, добавляем за выбранный период дополнительные услуги
     * @throws HTTP_Exception_404
     */
    public function action_rebuild()
    {
        $this->_sitePageData->url = '/bookkeeping/shopactservice/rebuild';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        Api_Ab1_Shop_Act_Service::rebuild($id, $this->_sitePageData, $this->_driverDB);

        self::redirect(
            '/bookkeeping/shopactservice/edit'
            . URL::query(
                array(
                    'id' => $id,
                ), FALSE
            )
        );
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopactservice/save';

        $result = Api_Ab1_Shop_Act_Service::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bookkeeping/shopactservice/del';
        $result = Api_Ab1_Shop_Act_Service::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => !$result)));
    }
}