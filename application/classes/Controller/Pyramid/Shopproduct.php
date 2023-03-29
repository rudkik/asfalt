<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pyramid_ShopProduct extends Controller_Pyramid_BasicPyramid
{

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Pyramid_Shop_Product::TABLE_ID;
        $this->tableName = Model_Pyramid_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/pyramid/shopproduct/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Pyramid_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('root_id' => $this->_sitePageData->operationID),
            array(), TRUE, TRUE
        );

        $this->_putInMain('/main/_shop/product/index');
    }

    public function action_json()
    {
        $rootID = intval(Request_RequestParams::getParamInt('root_id'));
        if($rootID < 1){
            $rootID = $this->_sitePageData->operationID;
        }
        $this->_actionJSON(
            'Request_Pyramid_Shop_Product',
            'find',
            array(
                'currency_id' => array('symbol'),
            ),
            array(
                'root_id' => $rootID,
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pyramid/shopproduct/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/new',
            )
        );

        $this->_requestBanks();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/product/one/new'] = Helpers_View::getViewObject($dataID, new Model_Pyramid_Shop_Product(),
            '_shop/product/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_show()
    {
        $this->_sitePageData->url = '/pyramid/shopproduct/show';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/show',
            )
        );

        // id записи
        $shopProductID = Request_RequestParams::getParamInt('id');
        $model = new Model_Pyramid_Shop_Product();
        if (!$this->dublicateObjectLanguage($model, $shopProductID, -1, FALSE)) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Pyramid_Shop_Product', $this->_sitePageData->shopID, "_shop/product/one/show",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopProductID), array());

        $this->_putInMain('/main/_shop/product/show');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pyramid/shopproduct/save';

        $result = Api_Pyramid_Shop_Product::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/pyramid/shopproduct/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/pyramid/shopproduct/index'
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

    public function action_recount_balance()
    {
        $this->_sitePageData->url = '/pyramid/shopproduct/recount_balance';

        Api_Pyramid_Shop_Product::recountProductsBalance($this->_sitePageData, $this->_driverDB);
    }
}
