<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopBranch extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shop';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'branch';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopbranch/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop', $this->_sitePageData->shopID, "_shop/branch/list/index",
            "_shop/branch/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('referral_shop_id' => array('name'), 'shop_operation_id' => array('email')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/branch/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopbranch/json';

        $this->_actionJSON(
            'Request_Shop',
            'findShopBranchIDs',
            array(
                'referral_shop_id' => array('name'),
                'shop_operation_id' => array('email')
            ),
            new Model_Shop()
        );
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopbranch/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Shop();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Branch not is found!');
        }

        // получаем данные
        $data = View_Shop::getShopBranch($this->_sitePageData->shopID, "_shop/branch/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }
}
