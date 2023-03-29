<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopProductGroup extends Controller_Ab1_Bid_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product_Group';
        $this->controllerName = 'shopproductgroup';
        $this->tableID = Model_Ab1_Shop_Product_Group::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product_Group::TABLE_NAME;
        $this->objectName = 'productgroup';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bid/shopproductgroup/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/group/list/index',
            )
        );
        $this->_requestShopProductGroups();

        // получаем список
        View_View::find('DB_Ab1_Shop_Product_Group', $this->_sitePageData->shopMainID, "_shop/product/group/list/index", "_shop/product/group/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/product/group/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/bid/shopproductgroup/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Product_Group', $this->_sitePageData->shopMainID,
            "_shop/product/group/list/list", "_shop/product/group/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopproductgroup/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/group/one/new',
            )
        );

        $this->_requestShopProductGroups();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/product/group/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Product_Group(),
            '_shop/product/group/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/product/group/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopproductgroup/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/group/one/edit',
            )
        );

        // id записи
        $shopProductGroupID = Request_RequestParams::getParamInt('id');
        if ($shopProductGroupID === NULL) {
            throw new HTTP_Exception_404('Group product not is found!');
        } else {
            $model = new Model_Ab1_Shop_Product_Group();
            if (!$this->dublicateObjectLanguage($model, $shopProductGroupID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Group product not is found!');
            }
        }

        $this->_requestShopProductGroups();

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Product_Group', $this->_sitePageData->shopMainID, "_shop/product/group/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/product/group/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopproductgroup/save';

        $result = Api_Ab1_Shop_Product_Group::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
