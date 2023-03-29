<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopTurnType extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Turn_Type';
        $this->controllerName = 'shopturntype';
        $this->tableID = Model_Ab1_Shop_Turn_Type::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Turn_Type::TABLE_NAME;
        $this->objectName = 'turntype';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopturntype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/type/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Turn_Type', $this->_sitePageData->shopID, "_shop/turn/type/list/index", "_shop/turn/type/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25), array('shop_turn_id' => array('name')));

        $this->_putInMain('/main/_shop/turn/type/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopturntype/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/type/one/new',
                'view::_shop/product-turn/list/index',
            )
        );

        View_View::find('DB_Ab1_Shop_Product', $this->_sitePageData->shopID, '_shop/product-turn/list/index',
            '_shop/product-turn/one/index', $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/turn/type/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Turn_Type(),
            '_shop/turn/type/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/turn/type/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopturntype/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/type/one/edit',
                'view::_shop/product-turn/list/index',
            )
        );

        // id записи
        $shopTurnTypeID = Request_RequestParams::getParamInt('id');
        if ($shopTurnTypeID === NULL) {
            throw new HTTP_Exception_404('TurnType not is found!');
        }else {
            $model = new Model_Ab1_Shop_Turn_Type();
            if (! $this->dublicateObjectLanguage($model, $shopTurnTypeID, $this->_sitePageData->shopID)) {
                throw new HTTP_Exception_404('TurnType not is found!');
            }
        }

        $products = Request_Request::find('DB_Ab1_Shop_Product',$this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $productTurns = Request_Request::find('DB_Ab1_Shop_Product_Turn', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_turn_type_id' => $shopTurnTypeID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        foreach($productTurns->childs as $productTurn){
            $product = $products->findChild($productTurn->values['shop_product_id']);
            if($product !== NULL){
                $product->additionDatas['group'] = $productTurn->values['group'];
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/product-turn/list/index'] = Helpers_View::getViewObjects($products, new Model_Ab1_Shop_Product(),
            '_shop/product-turn/list/index', '_shop/product-turn/one/index', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Turn_Type', $this->_sitePageData->shopID, "_shop/turn/type/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopTurnTypeID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/turn/type/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopturntype/save';

        $result = Api_Ab1_Shop_Turn_Type::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/weighted/shopturntype/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/weighted/shopturntype/index'
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

    /**
     * Делаем запрос на список клиентов
     * @param $typeID
     */
    protected function _requestShopTurns($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/list/list',
            )
        );

        $data = View_View::find('DB_Ab1_Shop_Turn', $this->_sitePageData->shopMainID,
            "_shop/turn/list/list", "_shop/turn/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/turn/list/list'] = $data;
        }
    }
}
