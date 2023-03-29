<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Nbc_ShopOperation extends Controller_Ab1_Nbc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Operation';
        $this->controllerName = 'shopoperation';
        $this->tableID = Model_Ab1_Shop_Operation::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Operation::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nbc/shopoperation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Shop_Operation', $this->_sitePageData->shopID,
            '_shop/operation/list/index', '_shop/operation/one/index',
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => Model_Ab1_Shop_Operation::RUBRIC_NBC),
            ['shop_worker_id' => ['name']]
        );

        $this->_putInMain('/main/_shop/operation/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nbc/shopoperation/new';
        $this->_actionShopOperationNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nbc/shopoperation/edit';
        $this->_actionShopOperationEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nbc/shopoperation/save';

        $result = Api_Shop_Operation::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
