<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopOperation extends Controller_Ab1_Cashbox_BasicAb1 {

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
        $this->_sitePageData->url = '/cashbox/shopoperation/index';

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
            array('limit' => 1000, 'limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => Model_Ab1_Shop_Operation::RUBRIC_CASHBOX),
            ['shop_worker_id' => ['name']]
        );

        $this->_putInMain('/main/_shop/operation/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shopoperation/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/new',
            )
        );

        $this->_requestShopCashboxes();
        $this->_requestListDB('DB_Ab1_Shop_Department');
        $this->_requestListDB('DB_Ab1_Shop_Worker');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/operation/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Operation(),
            '_shop/operation/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/operation/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cashbox/shopoperation/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/edit',
            )
        );

        // id записи
        $shopOperationID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Operation();
        if (! $this->dublicateObjectLanguage($model, $shopOperationID, -1, FALSE)) {
            throw new HTTP_Exception_404('Operation not is found!');
        }

        $this->_requestShopCashboxes($model->getShopCashboxID());
        $this->_requestListDB('DB_Ab1_Shop_Department', $model->getShopDepartmentID());
        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());

        // получаем данные
        View_View::findOne('DB_Shop_Operation', $this->_sitePageData->shopID, "_shop/operation/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopOperationID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/operation/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shopoperation/save';

        $result = Api_Shop_Operation::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
