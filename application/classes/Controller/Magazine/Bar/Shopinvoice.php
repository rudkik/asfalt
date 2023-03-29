<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopInvoice extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Invoice';
        $this->controllerName = 'shopinvoice';
        $this->tableID = Model_Magazine_Shop_Invoice::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Invoice::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopinvoice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Shop_Invoice',
            $this->_sitePageData->shopID, "_shop/invoice/list/index", "_shop/invoice/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 25, 'is_find_branch' => FALSE, 'shop_id' => $this->_sitePageData->branchID),
            array('shop_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/invoice/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopinvoice/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/new',
                'view::_shop/realization/item/list/invoice',
            )
        );

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        // Получаем список реализации сгруппированной по цене продукции, у которой удалось определить ЭСФ приемки
        $shopRealizationItemIDs = Api_Magazine_Shop_Invoice::getShopRealizationItemsByReceiveESFGroupProduction(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB,
            array(Model_Magazine_ESFType::ESF_TYPE_ELECTRONIC, Model_Magazine_ESFType::ESF_TYPE_PAPER)
        );

        $this->_sitePageData->replaceDatas['view::_shop/realization/item/list/invoice'] = Helpers_View::getViewObjects(
            $shopRealizationItemIDs, new Model_Magazine_Shop_Realization_Item(),
            '_shop/realization/item/list/invoice-new', '_shop/realization/item/one/invoice-new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->setIsFind(TRUE);
        $dataID->additionDatas = $shopRealizationItemIDs->additionDatas;

        $this->_sitePageData->replaceDatas['view::_shop/invoice/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Invoice(), '_shop/invoice/one/new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/invoice/new');
    }

    public function action_save_new()
    {
        $this->_sitePageData->url = '/bar/shopinvoice/save_new';

        $result = Api_Magazine_Shop_Invoice::saveNew($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopinvoice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/edit',
                'view::_shop/realization/item/list/invoice',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Invoice();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        if($dateFrom !== NULL && $dateTo !== NULL){
            $params = Request_RequestParams::setParams(
                array(
                    'created_at_from_equally' => $dateFrom,
                    'created_at_to' => $dateTo.' 23:59:59',
                    'shop_invoice_id' => array(0, $id),
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                    'sum_amount' => TRUE,
                    'sum_quantity' => TRUE,
                    'sum_esf_receive_quantity' => TRUE,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                    'group_by' => array(
                        'price',
                        'shop_production_id', 'shop_production_id.name', 'shop_production_id.barcode',
                    ),
                )
            );

            $model->setDateFrom($dateFrom);
            $model->setDateTo($dateTo);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                    'sum_amount' => TRUE,
                    'sum_quantity' => TRUE,
                    'sum_esf_receive_quantity' => TRUE,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                    'group_by' => array(
                        'price',
                        'shop_production_id', 'shop_production_id.name', 'shop_production_id.barcode',
                    ),
                )
            );
        }

        View_View::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID,
            '_shop/realization/item/list/invoice', '_shop/realization/item/one/invoice',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_production_id' => array('name', 'barcode'),
            )
        );

        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData, array());

        $this->_sitePageData->replaceDatas['view::_shop/invoice/one/edit'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Invoice(), '_shop/invoice/one/edit', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_putInMain('/main/_shop/invoice/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopinvoice/save';

        $result = Api_Magazine_Shop_Invoice::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bar/shopinvoice/del';
        $result = Api_Magazine_Shop_Invoice::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
