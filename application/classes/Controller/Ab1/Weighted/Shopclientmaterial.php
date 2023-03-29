<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopClientMaterial extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Material';
        $this->controllerName = 'shopclientmaterial';
        $this->tableID = Model_Ab1_Shop_Client_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Material::TABLE_NAME;
        $this->objectName = 'clientmaterial';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/weighted/shopclientmaterial/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopclientmaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/material/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Client_Material', $this->_sitePageData->shopMainID, "_shop/client/material/list/index", "_shop/client/material/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/client/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopclientmaterial/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/material/one/new',
            )
        );
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/client/material/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Client_Material(),
            '_shop/client/material/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/client/material/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopclientmaterial/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/material/one/edit',
            )
        );

        // id записи
        $shopClientMaterialID = Request_RequestParams::getParamInt('id');
        if ($shopClientMaterialID === NULL) {
            throw new HTTP_Exception_404('ClientMaterial not is found!');
        }else {
            $model = new Model_Ab1_Shop_Client_Material();
            if (! $this->dublicateObjectLanguage($model, $shopClientMaterialID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('ClientMaterial not is found!');
            }
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Client_Material', $this->_sitePageData->shopMainID, "_shop/client/material/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientMaterialID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/client/material/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopclientmaterial/save';

        $result = Api_Ab1_Shop_Client_Material::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/weighted/shopclientmaterial/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/weighted/shopclientmaterial/index'
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
}
