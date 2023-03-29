<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopPaymentMaterial extends Controller_Ab1_Tunable_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Payment_Material';
        $this->controllerName = 'shoppaymentmaterial';
        $this->tableID = Model_Ab1_Shop_Payment_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Payment_Material::TABLE_NAME;
        $this->objectName = 'paymentmaterial';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/material/list/index',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopSuppliers();

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment_Material', $this->_sitePageData->shopID, "_shop/payment/material/list/index", "_shop/payment/material/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_material_id' => array('name'), 'shop_supplier_id' => array('name')));

        $this->_putInMain('/main/_shop/payment/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/material/one/new',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopSuppliers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/material/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Payment_Material(),
            '_shop/payment/material/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/payment/material/new');
    }

    public function action_new_list()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/new_list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/material/one/new',
                'view::_shop/payment/material/list/item',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopSuppliers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/material/list/item'] =
            Helpers_View::getViewObjects($dataID, new Model_Ab1_Shop_Payment_Material(),
                '_shop/payment/material/list/item', '_shop/payment/material/one/item',
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/material/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Payment_Material(),
            '_shop/payment/material/one/list/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/payment/material/new-list');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/material/one/edit',
            )
        );

        // id записи
        $shopPaymentMaterialID = Request_RequestParams::getParamInt('id');
        if ($shopPaymentMaterialID === NULL) {
            throw new HTTP_Exception_404('Supplier price not is found!');
        } else {
            $model = new Model_Ab1_Shop_Payment_Material();
            if (!$this->dublicateObjectLanguage($model, $shopPaymentMaterialID)) {
                throw new HTTP_Exception_404('Supplier price not is found!');
            }
        }

        $this->_requestShopMaterials($model->getShopMaterialID());
        $this->_requestShopSuppliers($model->getShopSupplierID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Payment_Material', $this->_sitePageData->shopID, "_shop/payment/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentMaterialID), array('shop_supplier_id'));

        $this->_putInMain('/main/_shop/payment/material/edit');
    }

    public function action_edit_list()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/edit_list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/material/one/edit',
                'view::_shop/payment/material/list/item',
            )
        );

        // id записи
        $shopPaymentMaterialID = Request_RequestParams::getParamInt('id');
        if ($shopPaymentMaterialID === NULL) {
            throw new HTTP_Exception_404('Supplier price not is found!');
        } else {
            $model = new Model_Ab1_Shop_Payment_Material();
            if (!$this->dublicateObjectLanguage($model, $shopPaymentMaterialID)) {
                throw new HTTP_Exception_404('Supplier price not is found!');
            }
        }

        $this->_requestShopMaterials();
        $this->_requestShopSuppliers($model->getShopSupplierID());

        $this->_sitePageData->replaceDatas['view::_shop/payment/material/list/item'] = View_View::find('DB_Ab1_Shop_Payment_Material', $this->_sitePageData->shopID,
            "_shop/payment/material/list/item", '_shop/payment/material/one/item', $this->_sitePageData, $this->_driverDB,
            array('shop_supplier_id' => $model->getShopSupplierID(), 'date' => $model->getDate(),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_supplier_id'));

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/payment/material/one/edit'] =
            View_View::findOne('DB_Ab1_Shop_Payment_Material', $this->_sitePageData->shopID, "_shop/payment/material/one/list/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentMaterialID), array('shop_supplier_id'));

        $this->_putInMain('/main/_shop/payment/material/edit-list');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/save';

        $result = Api_Ab1_Shop_Payment_Material::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/tunable/shoppaymentmaterial/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/tunable/shoppaymentmaterial/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }

    public function action_save_list()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentmaterial/save_list';

        $result = Api_Ab1_Shop_Payment_Material::saveList($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if ((Request_RequestParams::getParamBoolean('is_close') === FALSE) && ($result['id'] > 0)) {
                $this->redirect('/tunable/shoppaymentmaterial/edit_list'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/tunable/shoppaymentmaterial/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }
}
