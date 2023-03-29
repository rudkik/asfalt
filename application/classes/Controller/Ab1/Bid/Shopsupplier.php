<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopSupplier extends Controller_Ab1_Bid_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Supplier';
        $this->controllerName = 'shopsupplier';
        $this->tableID = Model_Ab1_Shop_Supplier::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Supplier::TABLE_NAME;
        $this->objectName = 'supplier';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bid/shopsupplier/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Supplier', $this->_sitePageData->shopMainID, "_shop/supplier/list/index", "_shop/supplier/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/supplier/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopsupplier/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/supplier/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Supplier(),
            '_shop/supplier/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/supplier/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopsupplier/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/one/edit',
            )
        );

        // id записи
        $shopSupplierID = Request_RequestParams::getParamInt('id');
        if ($shopSupplierID === NULL) {
            throw new HTTP_Exception_404('Supplier not is found!');
        }else {
            $model = new Model_Ab1_Shop_Supplier();
            if (! $this->dublicateObjectLanguage($model, $shopSupplierID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Supplier not is found!');
            }
        }
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Supplier', $this->_sitePageData->shopMainID, "_shop/supplier/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopSupplierID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/supplier/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopsupplier/save';

        $result = Api_Ab1_Shop_Supplier::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/bid/shopsupplier/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/bid/shopsupplier/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bid/shopsupplier/del';
        $result = Api_Ab1_Shop_Supplier::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
