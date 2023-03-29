<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopInvoice extends Controller_Magazine_Accounting_BasicMagazine {

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
        $this->_sitePageData->url = '/accounting/shopinvoice/index';

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
            array('limit_page' => 25, 'is_find_branch' => FALSE),
            array('shop_invoice_id' => array('number'))
        );

        $this->_putInMain('/main/_shop/invoice/index');
    }

    public function action_days()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/days';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/list/days',
            )
        );

        $days = new MyArray();
        for ($i = 0; $i < 16; $i++){
            $date = Helpers_DateTime::minusDays(date('Y-m-d'), $i);

            $params = Request_RequestParams::setParams(
                array(
                    'created_at_from' => $date,
                    'created_at_to' => Helpers_DateTime::plusDays($date, 1),
                    'not_shop_write_off_type_id' => array(
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                        Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                    ),
                    'sum_amount' => TRUE,
                    'sum_quantity' => TRUE,
                    'group_by' => array(
                        'shop_invoice_id',
                    ),
                )
            );
            $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item', 
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params
            );

            $shopRealizationItemIDs->setIsFind(true);
            $shopRealizationItemIDs->addAdditionDataChilds(['date' => $date]);
            $days->addChilds($shopRealizationItemIDs);
        }

        $this->_sitePageData->replaceDatas['view::_shop/invoice/list/days'] = Helpers_View::getViewObjects(
            $days, new Model_Magazine_Shop_Invoice(),
            '_shop/invoice/list/days', '_shop/invoice/one/days',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/invoice/days');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/new';

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
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'shop_invoice_id' => 0,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'sum_esf_receive_quantity' => TRUE,
                'sort_by' => array('shop_production_id.name' => 'asc'),
                'not_shop_write_off_type_id' => array(
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION,
                ),
                'group_by' => array(
                    'price',
                    'shop_production_id', 'shop_production_id.name', 'shop_production_id.barcode', 'shop_production_id.shop_product_id',
                ),
            )
        );
        $shopRealizationItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Item', 
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_production_id' => array('name', 'barcode', 'shop_product_id'))
        );

        $amount = 0;
        $quantity = 0;
        foreach ($shopRealizationItemIDs->childs as $child){
            $amount += $child->values['amount'];
            $quantity += $child->values['quantity'];
        }
        $shopRealizationItemIDs->additionDatas = array('quantity' => $quantity, 'amount' => $amount);

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

    public function action_return_new()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/return_new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/return-new',
                'view::_shop/realization/return/item/list/invoice',
            )
        );

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        // Получаем список реализации сгруппированной по цене продукции, у которой удалось определить ЭСФ приемки
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => Helpers_DateTime::plusDays($dateTo, 1),
                'shop_invoice_id' => 0,
            )
        );
        $shopRealizationReturnItemIDs = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item', 
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array('shop_production_id' => array('name'))
        );
        // считаем итоги
        $amount = 0;
        $quantity = 0;
        foreach ($shopRealizationReturnItemIDs->childs as $child){
            $amount += $child->values['amount'];
            $quantity += $child->values['quantity'];
        }
        $shopRealizationReturnItemIDs->additionDatas = array('amount' => $amount, 'quantity' => $quantity);


        $this->_sitePageData->replaceDatas['view::_shop/realization/return/item/list/invoice'] = Helpers_View::getViewObjects(
            $shopRealizationReturnItemIDs, new Model_Magazine_Shop_Realization_Return_Item(),
            '_shop/realization/return/item/list/invoice-new', '_shop/realization/return/item/one/invoice-new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->setIsFind(TRUE);
        $dataID->additionDatas = array('amount' => $amount, 'quantity' => $quantity);

        $this->_sitePageData->replaceDatas['view::_shop/invoice/one/return-new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Invoice(), '_shop/invoice/one/return-new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/invoice/return-new');
    }

    public function action_save_new()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/save_new';

        $result = Api_Magazine_Shop_Invoice::saveNew($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_return_new()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/save_return_new';

        $ids = Api_Magazine_Shop_Invoice::saveReturnNewList($this->_sitePageData, $this->_driverDB);

        $this->redirect('/'.$this->_sitePageData->actionURLName.'/'.$this->controllerName.'/index'.URL::query(array('id' => $ids), false));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/edit',
                'view::_shop/invoice/item/list/invoice',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Invoice();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $isNotGroup = Request_RequestParams::getParamBoolean('is_not_group');

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        $dateTo = Request_RequestParams::getParamDate('date_to');

        if($dateFrom !== NULL && $dateTo !== NULL){
            $params = Request_RequestParams::setParams(
                array(
                    'created_at_from_equally' => $dateFrom,
                    'created_at_to' => $dateTo.' 23:59:59',
                    'shop_invoice_id' => array(0, $id),
                    'sort_by' => array(
                        'shop_product_id.name' => 'asc',
                        'shop_production_id.name' => 'asc',
                    ),
                )
            );

            if(!$isNotGroup){
                $params['sum_amount'] = TRUE;
                $params['sum_quantity'] = TRUE;
                $params['sum_esf_receive_quantity'] = TRUE;
                $params['group_by'] = array(
                    'price',
                    'shop_product_id.id', 'shop_product_id.name', 'shop_product_id.barcode',
                    'shop_production_id', 'shop_production_id.name', 'shop_production_id.barcode',
                );

            }

            $model->setDateFrom($dateFrom);
            $model->setDateTo($dateTo);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_invoice_id' => $id,
                    'sort_by' => array(
                        'shop_product_id.name' => 'asc',
                        'shop_production_id.name' => 'asc',
                    ),
                )
            );

            if(!$isNotGroup){
                $params['sum_amount'] = TRUE;
                $params['sum_quantity'] = TRUE;
                $params['group_by'] = array(
                    'is_esf', 'price',
                    'shop_product_id.id', 'shop_product_id.name', 'shop_product_id.barcode',
                    'shop_production_id.id', 'shop_production_id.name', 'shop_production_id.barcode',
                );

            }
        }

        if($model->getESFTypeID() == Model_Magazine_ESFType::ESF_TYPE_RETURN){
            $this->_sitePageData->replaceDatas['view::_shop/invoice/item/list/invoice'] =
                View_View::find('DB_Magazine_Shop_Invoice_Item',
                    $this->_sitePageData->shopID,
                    '_shop/realization/return/item/list/invoice', '_shop/realization/return/item/one/invoice',
                    $this->_sitePageData, $this->_driverDB, $params,
                    array(
                        'shop_product_id' => array('name', 'barcode'),
                    )
                );
        }else {
            View_View::find('DB_Magazine_Shop_Invoice_Item',
                $this->_sitePageData->shopID,
                '_shop/invoice/item/list/invoice', '_shop/invoice/item/one/invoice',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_product_id' => array('id', 'name', 'barcode'),
                    'shop_production_id' => array('id', 'name', 'barcode'),
                )
            );
        }

        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData, array());

        $this->_sitePageData->replaceDatas['view::_shop/invoice/one/edit'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Invoice(), '_shop/invoice/one/edit', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_putInMain('/main/_shop/invoice/edit');
    }

    public function action_edit_gtd()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/edit_gtd';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/one/edit-gtd',
                'view::_shop/invoice/item/gtd/list/invoice',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Invoice();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $id,
                'sort_by' => array(
                    'shop_product_id.name' => 'asc',
                    'shop_production_id.name' => 'asc',
                ),
                'sum_amount_realization' => TRUE,
                'sum_quantity' => TRUE,
                'sum_esf_receive_quantity' => TRUE,
                'group_by' => array(
                    'price_realization',
                    'shop_product_id.id', 'shop_product_id.name', 'shop_product_id.barcode',
                    'shop_production_id', 'shop_production_id.name', 'shop_production_id.barcode',
                    'catalog_tru_id', 'tru_origin_code', 'product_declaration', 'product_number_in_declaration',
                    'is_esf',
                    'shop_product_id.unit_id.name',
                    'shop_production_id.unit_id.name',
                ),
            )
        );

        View_View::find('DB_Magazine_Shop_Invoice_Item_GTD',
            $this->_sitePageData->shopID,
            '_shop/invoice/item/gtd/list/invoice', '_shop/invoice/item/gtd/one/invoice',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_id' => array('name', 'barcode'),
                'shop_production_id' => array('name', 'barcode'),
                'shop_product_id.unit_id' => array('name'),
                'shop_production_id.unit_id' => array('name'),
            )
        );

        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData, array());

        $this->_sitePageData->replaceDatas['view::_shop/invoice/one/edit-gtd'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Invoice(), '_shop/invoice/one/edit-gtd', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopID
        );
        $this->_putInMain('/main/_shop/invoice/edit-gtd');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/save';

        $result = Api_Magazine_Shop_Invoice::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/del';
        $result = Api_Magazine_Shop_Invoice::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_import_esf()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/import_esf';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $fileName = Arr::path($_FILES, 'file.tmp_name', '');
        Api_Magazine_Shop_Invoice::loadESF($id, $fileName, $this->_sitePageData, $this->_driverDB);

        self::redirect('/accounting/shopinvoice/edit?id='.$id);
    }

    public function action_save_item_price()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/save_item_price';

        $shopInvoiceID = Request_RequestParams::getParamInt('shop_invoice_id');
        $shopInvoiceItemID = Request_RequestParams::getParamInt('shop_invoice_item_id');
        if($shopInvoiceItemID < 1){
            $shopInvoiceItemID = null;
        }
        $shopProductionID = Request_RequestParams::getParamInt('shop_production_id');
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        $price = round(Request_RequestParams::getParamFloat('price'), 2);

        $params = Request_RequestParams::setParams(
            [
                'shop_invoice_id' => $shopInvoiceID,
                'id' => $shopInvoiceItemID,
                'shop_production_id' => $shopProductionID,
                'shop_product_id' => $shopProductID,
            ]
        );
        $shopInvoiceItemIDs = Request_Request::find(
            'DB_Magazine_Shop_Invoice_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );

        $model = new Model_Magazine_Shop_Invoice_Item();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopInvoiceItemIDs->childs as $child){
            $child->setModel($model);
            $model->setPrice($price);
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        $shopInvoiceItems = $shopInvoiceItemIDs->getChildArrayID();
        if(count($shopInvoiceItems) > 0){
            $params = Request_RequestParams::setParams(
                [
                    'shop_invoice_item_id' => $shopInvoiceItems,
                ]
            );
            $shopInvoiceItemGTDIDs = Request_Request::find(
                'DB_Magazine_Shop_Invoice_Item_GTD',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            $model = new Model_Magazine_Shop_Invoice_Item_GTD();
            $model->setDBDriver($this->_driverDB);
            foreach ($shopInvoiceItemGTDIDs->childs as $child){
                $child->setModel($model);
                $model->setPriceRealization($price);
                Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
            }
        }

        // посчитаем общее количество
        $totalInvoice = Api_Magazine_Shop_Invoice_Item::calcTotal($shopInvoiceID, $this->_sitePageData, $this->_driverDB);

        $model = new Model_Magazine_Shop_Invoice();
        $model->setDBDriver($this->_driverDB);
        if(Helpers_DB::getDBObject($model, $shopInvoiceID, $this->_sitePageData)){
            $model->setAmount($totalInvoice['amount']);
            $model->setQuantity($totalInvoice['quantity']);
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        $this->response->body(Json::json_encode($totalInvoice));
    }

    public function action_save_item_gtd_tru_origin_code()
    {
        $this->_sitePageData->url = '/accounting/shopinvoice/save_item_gtd_tru_origin_code';

        $shopInvoiceID = Request_RequestParams::getParamInt('shop_invoice_id');
        $priceRealization = Request_RequestParams::getParamFloat('price_realization');
        $shopProductionID = Request_RequestParams::getParamInt('shop_production_id');
        $truOriginCode = Request_RequestParams::getParamStr('tru_origin_code');
        $productDeclaration = Request_RequestParams::getParamStr('product_declaration');
        $productNumberInDeclaration = Request_RequestParams::getParamStr('product_number_in_declaration');
        $isEsf = Request_RequestParams::getParamBoolean('is_esf');

        $newTruOriginCode = Request_RequestParams::getParamStr('new_tru_origin_code');

        $params = Request_RequestParams::setParams(
            [
                'shop_invoice_id' => $shopInvoiceID,
                'price_realization' => $priceRealization,
                'shop_production_id' => $shopProductionID,
                'tru_origin_code' => $truOriginCode,
                'product_declaration' => $productDeclaration,
                'product_number_in_declaration' => $productNumberInDeclaration,
                'is_esf' => $isEsf,
            ]
        );

        $shopInvoiceItemIDs = Request_Request::find(
            'DB_Magazine_Shop_Invoice_Item_GTD',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );

        $model = new Model_Magazine_Shop_Invoice_Item_GTD();
        $model->setDBDriver($this->_driverDB);
        foreach ($shopInvoiceItemIDs->childs as $child){
            $child->setModel($model);
            $model->setTruOriginCode($newTruOriginCode);
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        $this->response->body(Json::json_encode($newTruOriginCode));
    }
}
