<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopRealization extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Realization';
        $this->controllerName = 'shoprealization';
        $this->tableID = Model_Magazine_Shop_Realization::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Realization::TABLE_NAME;
        $this->objectName = 'realization';

        parent::__construct($request, $response);
    }

    public function action_print() {
        $aura3 = new Drivers_CashRegister_Aura3();
        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();

        Api_Magazine_Shop_Realization::getGoodListFiscalCheck(
            585692,  $fiscalCheck->getGoodsList(),
            $this->_sitePageData, $this->_driverDB
        );

        $aura3->printFiscalCheck(
            3000,
            $fiscalCheck
        );

       // $aura3->repeatPrint();

    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shoprealization/index';

        $this->_requestShopWorkers();

        $isSpecial = Request_RequestParams::getParamInt('is_special');
        if($isSpecial == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/list/special/index',
                )
            );

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'limit' => 200,
                    'is_special' => FALSE,
                ),
                FALSE
            );
            View_View::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID,
                "_shop/realization/list/special/index", "_shop/realization/one/special/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_worker_id' => array('name'))
            );

            $this->_putInMain('/main/_shop/realization/special/index');
        }elseif($isSpecial == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/list/write-off/index',
                )
            );

            $this->_requestShopWriteOffType();

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'is_special' => FALSE,
                ),
                FALSE
            );
            View_View::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID,
                "_shop/realization/list/write-off/index", "_shop/realization/one/write-off/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_write_off_type_id' => array('name'))
            );

            $this->_putInMain('/main/_shop/realization/write-off/index');
        }else{
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/list/index',
                )
            );

            $this->_requestShopCard();

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'is_special' => FALSE,
                ),
                FALSE
            );
            View_View::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID,
                "_shop/realization/list/index", "_shop/realization/one/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_worker_id' => array('name'))
            );

            $this->_putInMain('/main/_shop/realization/index');
        }
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shoprealization/new';

        $isSpecial = Request_RequestParams::getParamInt('is_special');
        if($isSpecial == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/special/new',
                    '_shop/realization/item/list/special/index',
                )
            );

            $dataID = new MyArray();
            $dataID->id = 0;
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/item/list/special/index'] = Helpers_View::getViewObjects($dataID,
                new Model_Magazine_Shop_Realization(), '_shop/realization/item/list/special/index',
                '_shop/realization/item/one/special/index', $this->_sitePageData, $this->_driverDB
            );

            $dataID = new MyArray();
            $dataID->id = 0;
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/special/new'] = Helpers_View::getViewObject(
                $dataID, new Model_Magazine_Shop_Realization(),
                '_shop/realization/one/special/new', $this->_sitePageData, $this->_driverDB
            );

            $this->_putInMain('/main/_shop/realization/special/new');
        }elseif($isSpecial == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/write-off/new',
                    '_shop/realization/item/list/write-off/index',
                )
            );

            $this->_requestShopWriteOffType();

            $dataID = new MyArray();
            $dataID->id = 0;
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/item/list/write-off/index'] = Helpers_View::getViewObjects($dataID,
                new Model_Magazine_Shop_Realization(), '_shop/realization/item/list/write-off/index',
                '_shop/realization/item/one/write-off/index', $this->_sitePageData, $this->_driverDB
            );

            $dataID = new MyArray();
            $dataID->id = 0;
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/write-off/new'] = Helpers_View::getViewObject(
                $dataID, new Model_Magazine_Shop_Realization(),
                '_shop/realization/one/write-off/new', $this->_sitePageData, $this->_driverDB
            );

            $this->_putInMain('/main/_shop/realization/write-off/new');
        }else{
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/new',
                    '_shop/realization/item/list/index',
                )
            );

            $dataID = new MyArray();
            $dataID->id = 0;
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/item/list/index'] = Helpers_View::getViewObjects($dataID,
                new Model_Magazine_Shop_Realization(), '_shop/realization/item/list/index',
                '_shop/realization/item/one/index', $this->_sitePageData, $this->_driverDB
            );

            $dataID = new MyArray();
            $dataID->id = 0;
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/new'] = Helpers_View::getViewObject(
                $dataID, new Model_Magazine_Shop_Realization(),
                '_shop/realization/one/new', $this->_sitePageData, $this->_driverDB
            );

            $this->_putInMain('/main/_shop/realization/new');
        }
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shoprealization/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Realization();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Realization not is found!');
        }
        $model->getElement('shop_card_id', TRUE, $this->_sitePageData->shopMainID);

        if($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/special/edit',
                    '_shop/realization/item/list/special/index',
                )
            );

            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            View_View::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID,
                '_shop/realization/item/list/special/index', '_shop/realization/item/one/special/index',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_production_id' => array('name', 'barcode'),
                    'unit_id' => array('name')
                )
            );

            $dataID = new MyArray();
            $model->getElement('shop_worker_id', TRUE);
            $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/special/edit'] = Helpers_View::getViewObject(
                $dataID, $model, '_shop/realization/one/special/edit', $this->_sitePageData, $this->_driverDB
            );
            $this->_putInMain('/main/_shop/realization/special/edit');
        }elseif($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/write-off/edit',
                    '_shop/realization/item/list/write-off/index',
                )
            );

            $this->_requestShopWriteOffType($model->getShopWriteOffTypeID());

            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            View_View::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID,
                '_shop/realization/item/list/write-off/index', '_shop/realization/item/one/write-off/index',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_production_id' => array('name', 'barcode'),
                    'unit_id' => array('name')
                )
            );

            $dataID = new MyArray();
            $model->getElement('shop_worker_id', TRUE);
            $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/write-off/edit'] = Helpers_View::getViewObject(
                $dataID, $model, '_shop/realization/one/write-off/edit', $this->_sitePageData, $this->_driverDB
            );
            $this->_putInMain('/main/_shop/realization/write-off/edit');
        }else{
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/edit',
                    '_shop/realization/item/list/index',
                )
            );

            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            View_View::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID,
                '_shop/realization/item/list/index', '_shop/realization/item/one/index',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_production_id' => array('name', 'barcode'),
                    'unit_id' => array('name')
                )
            );

            $dataID = new MyArray();
            $model->getElement('shop_worker_id', TRUE);
            $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/edit'] = Helpers_View::getViewObject(
                $dataID, $model, '_shop/realization/one/edit', $this->_sitePageData, $this->_driverDB
            );
            $this->_putInMain('/main/_shop/realization/edit');

        }
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shoprealization/save';
        Helpers_Token::checkAccess($this->_sitePageData->url);

        $result = Api_Magazine_Shop_Realization::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shoprealization/del';
        $result = Api_Magazine_Shop_Realization::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_period_total()
    {
        $this->_sitePageData->url = '/accounting/shoprealization/period_total';

        $shopRealization =  Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sum_amount' => TRUE,
                    'is_special' => array(
                        Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                        Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                    ),
                    'group_by' => array(
                        'shop_worker_id',
                        'shop_worker_id.name',
                    ),
                ),
                FALSE
            ),
            0, TRUE,
            array(
                'shop_worker_id' => array('name')
            )
        );

        $amount = 0;
        foreach ($shopRealization->childs as $child){
            $name = $child->getElementValue('shop_worker_id');
            if(empty($name)){
                $name = 'Наличные';
            }

            echo $name.': '.$child->values['amount'].'<br>';
            $amount += $child->values['amount'];
        }
        echo 'Итого: '.$amount.'<br>';

        die;
    }
}
