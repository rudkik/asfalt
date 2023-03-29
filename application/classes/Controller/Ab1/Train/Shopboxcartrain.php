<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopBoxcarTrain extends Controller_Ab1_Train_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar_Train';
        $this->controllerName = 'shopboxcartrain';
        $this->tableID = Model_Ab1_Shop_Boxcar_Train::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar_Train::TABLE_NAME;
        $this->objectName = 'boxcartrain';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/train/shopboxcartrain/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/train/list/index',
            )
        );

        $this->_requestShopRaws();
        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        // получаем список
        View_View::find('DB_Ab1_Shop_Boxcar_Train',
            $this->_sitePageData->shopID,
            "_shop/boxcar/train/list/index", "_shop/boxcar/train/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
                'shop_boxcar_departure_station_id' => array('name'),
                'shop_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/boxcar/train/index');
    }

    public function action_contract()
    {
        $this->_sitePageData->url = '/train/shopboxcartrain/contract';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/train/list/contract',
            )
        );

        $this->_requestShopRaws();
        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);
        $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_LESSEE);

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if($dateFrom == null){
            $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y'));
        }
        $dateTo = Helpers_DateTime::getDateFormatRus('date_to');
        if($dateTo == null){
            $dateTo = Helpers_DateTime::getYearBeginStr(date('Y-m-d'));
        }

        $params = Request_RequestParams::setParams(
            array(
                'date_shipment_from_equally' => $dateFrom,
                'date_shipment_to' => $dateTo,
                'date_arrival_empty' => false,
            )
        );

        $shopBoxcarTrainIDs = Request_Request::find(
            'DB_Ab1_Shop_Boxcar_Train', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'shop_boxcar_client_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_raw_id' => array('name'),
            )
        );

        $shopBoxcarTrains = new MyArray();
        foreach ($shopBoxcarTrainIDs->childs as $child){
            $key = $child->values['shop_boxcar_client_id']
                . '_' . $child->values['shop_client_id']
                . '_' . $child->values['shop_client_contract_id']
                . '_' . $child->values['shop_raw_id'];

            if(!key_exists($key, $shopBoxcarTrains->childs)){
                $shopBoxcarTrains->childs[$key] = $child;
                $child->values['paid_quantity'] = 0;
                $child->values['received_quantity'] = 0;
                $child->values['in_way_quantity'] = 0;
                $child->values['balance_quantity'] = 0;
            }

            if(empty($child->values['date_drain_from'])){
                $shopBoxcarTrains->childs[$key]->values['in_way_quantity'] += $child->values['quantity'];
            }else{
                $shopBoxcarTrains->childs[$key]->values['received_quantity'] += $child->values['quantity'];
            }
        }

        $shopClientContracts = $shopBoxcarTrainIDs->getChildArrayInt('shop_client_contract_id', true);
        if(!empty($shopClientContracts)){
            $params = Request_RequestParams::setParams(
                array(
                    'basic_or_contract' => $shopClientContracts,
                )
            );

            $shopClientContractItemIDs = Request_Request::find(
                'DB_Ab1_Shop_Client_Contract_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_client_id' => array('name'),
                    'shop_raw_id' => array('name'),
                )
            );
            $shopClientContractItemIDs->runIndex();

            $shopClientContractItems = array();
            foreach ($shopClientContractItemIDs->childs as $child) {
                if(!key_exists($child->id, $shopClientContractItems)){
                    $shopClientContractItems[$child->id] = array();
                }
                $shopClientContractItems[$child->id][$child->values['shop_raw_id']] = $child;
            }
        }else{
            $shopClientContractItems = array();
        }

        foreach ($shopBoxcarTrains->childs as $child){
            $contract = $child->values['shop_client_contract_id'];
            $raw = $child->values['shop_raw_id'];
            if(key_exists($contract, $shopClientContractItems) && key_exists($raw, $shopClientContractItems[$contract])){
                if($child->values['basic_shop_client_contract_id'] == 0 || $child->values['is_add_basic_contract'] == 1){
                    $child->values['paid_quantity'] += $shopClientContractItemIDs[$contract][$raw]->values['quantity'];
                }
            }
        }

        foreach ($shopClientContractItems as $shopClientContractItem){
            foreach ($shopClientContractItem as $child){
                $key = $child->values['shop_client_id']
                    . '_' . 0
                    . '_' . $child->values['shop_client_contract_id']
                    . '_' . $child->values['shop_raw_id'];

                if(!key_exists($key, $shopBoxcarTrains->childs)){
                    $shopBoxcarTrains->childs[$key] = $child;
                    $child->values['paid_quantity'] = 0;
                    $child->values['received_quantity'] = 0;
                    $child->values['in_way_quantity'] = 0;
                    $child->values['balance_quantity'] = 0;

                    $child->values['shop_boxcar_client_id'] = $child->values['shop_client_id'];
                    $child->values[Model_Basic_DBObject::FIELD_ELEMENTS]['shop_boxcar_client_id']['name'] = $child->getElementValue('shop_client_id');
                }

                $child->values['paid_quantity'] += $child->values['quantity'];
            }
        }

        $result = Helpers_View::getViewObjects(
            $shopBoxcarTrains, new Model_Ab1_Shop_Boxcar_Train(),
            "_shop/boxcar/train/list/contract", "_shop/boxcar/train/one/contract",
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->replaceDatas['view::_shop/boxcar/train/list/contract'] = $result;

        $this->_putInMain('/main/_shop/boxcar/train/contract');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/train/shopboxcartrain/edit';
        $this->_actionShopBoxcarTrainEdit();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/train/shopboxcartrain/new';
        $this->_actionShopBoxcarTrainNew();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/train/shopboxcartrain/save';

        $result = Api_Ab1_Shop_Boxcar_Train::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/train/shopboxcartrain/del';
        $result = Api_Ab1_Shop_Boxcar_Train::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
