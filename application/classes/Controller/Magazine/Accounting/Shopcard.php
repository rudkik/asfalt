<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopCard extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Card';
        $this->controllerName = 'shopcard';
        $this->tableID = Model_Magazine_Shop_Card::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Card::TABLE_NAME;
        $this->objectName = 'card';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopcard/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/card/list/index',
            )
        );

        $this->_requestShopWorkers();

        // получаем список
        View_View::find('DB_Magazine_Shop_Card',
            $this->_sitePageData->shopID, "_shop/card/list/index", "_shop/card/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array('shop_worker_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/card/index');
    }

    public function action_find_barcode() {
        $this->_sitePageData->url = '/accounting/shopcard/find_barcode';

        $params = Request_RequestParams::setParams(
            array(
                'barcode_number_full' => Request_RequestParams::getParamStr('barcode_number'),
            )
        );
        $shopCards = Request_Request::find('DB_Magazine_Shop_Card',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 1, TRUE, array('shop_worker_id' => array('name'))
        );

        $result = array(
            'is_find' => count($shopCards->childs) > 0,
            'values' => array(),
        );
        if($result['is_find']){
            $shopCard = $shopCards->childs[0];

            $result['values'] = array(
                'id' => $shopCard->values['id'],
                'barcode' => $shopCard->values['barcode'],
                'number' => $shopCard->values['number'],
                'name' => $shopCard->getElementValue('shop_worker_id'),
                'quantity_balance' => 0,
            );

            // лимит талонов
            $params = Request_RequestParams::setParams(
                array(
                    'sum_quantity_balance' => true,
                    'shop_worker_id' => $shopCard->values['shop_worker_id'],
                    'validity' => date('Y-m-d'),
                )
            );
            $shopTalons = Request_Request::find('DB_Magazine_Shop_Talon',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params
            );

            if(count($shopTalons->childs) > 0){
                $result['values']['quantity_balance'] = floatval($shopTalons->childs[0]->values['quantity_balance']);
            }

            // лимит суммы реализации
            $params = Request_RequestParams::setParams(
                array(
                    'shop_worker_id' => $shopCard->values['shop_worker_id'],
                    'year' => date('Y'),
                    'month' => date('m'),
                )
            );
            $shopWorkerLimits = Request_Request::findBranch('DB_Magazine_Shop_Worker_Limit',
                array(), $this->_sitePageData, $this->_driverDB, $params
            );

            if(count($shopWorkerLimits->childs) > 0){
                $result['values']['amount_balance'] = floatval($shopWorkerLimits->childs[0]->values['amount_balance']);
            }else{
                $result['values']['amount_balance'] = 100000000;
            }
        }

        $this->response->body(Json::json_encode($result));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopcard/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/card/one/new',
            )
        );

        $this->_requestShopWorkers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/card/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Card(),
            '_shop/card/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/card/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopcard/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/card/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Card();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Card not is found!');
        }

        $this->_requestShopWorkers($model->getShopWorkerID());

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Card', $this->_sitePageData->shopID, "_shop/card/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/card/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopcard/save';

        $result = Api_Magazine_Shop_Card::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
