<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopFormula extends Controller_Ab1_Tunable_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Formula';
        $this->controllerName = 'shopformula';
        $this->tableID = Model_Ab1_Shop_Formula::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Formula::TABLE_NAME;
        $this->objectName = 'formula';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/tunable/shopformula/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopMaterials();

        // получаем список
        View_View::find('DB_Ab1_Shop_Formula', $this->_sitePageData->shopMainID, "_shop/formula/list/index", "_shop/formula/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_product_id' => array('name'), 'shop_material_id' => array('name')));

        $this->_putInMain('/main/_shop/formula/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopformula/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/one/new',
                '_shop/formula/item/list/index',
            )
        );


        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopMaterials();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Formula_Item(), '_shop/formula/item/list/index',
            '_shop/formula/item/one/index', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/formula/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Formula(),
            '_shop/formula/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/formula/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopformula/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/one/edit',
                '_shop/formula/item/list/index',
            )
        );

        // id записи
        $shopFormulaID = Request_RequestParams::getParamInt('id');
        if ($shopFormulaID === NULL) {
            throw new HTTP_Exception_404('Formula not is found!');
        } else {
            $model = new Model_Ab1_Shop_Formula();
            if (!$this->dublicateObjectLanguage($model, $shopFormulaID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Formula not is found!');
            }
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopMaterials();

        View_View::find('DB_Ab1_Shop_Formula_Item', $this->_sitePageData->shopMainID, '_shop/formula/item/list/index',
            '_shop/formula/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_formula_id' => $shopFormulaID,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Formula', $this->_sitePageData->shopMainID, "_shop/formula/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopFormulaID), array('shop_client_id'));

        $this->_putInMain('/main/_shop/formula/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopformula/save';

        $result = Api_Ab1_Shop_Formula::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $model = new Model_Ab1_Shop_Client();
            $this->getDBObject($model, $result['result']['values']['shop_client_id'], $this->_sitePageData->shopMainID);
            $result['result']['shop_client'] = $model->getValues(TRUE, TRUE);
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/tunable/shopformula/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/tunable/shopformula/index'
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
