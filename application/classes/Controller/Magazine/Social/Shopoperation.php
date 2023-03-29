<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_ShopOperation extends Controller_Magazine_Social_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_Operation';
        $this->controllerName = 'shopoperation';
        $this->tableID = Model_Magazine_Shop_Operation::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Operation::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/social/shopoperation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID, "_shop/operation/list/index", "_shop/operation/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit_page' => 25, 'shop_table_rubric_id' => Model_Magazine_Shop_Operation::RUBRIC_SOCIAL));

        $this->_putInMain('/main/_shop/operation/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/social/shopoperation/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/operation/one/new'] = Helpers_View::getViewObject($dataID, new Model_Magazine_Shop_Operation(),
            '_shop/operation/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/operation/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/social/shopoperation/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/edit',
            )
        );

        // id записи
        $shopOperationID = Request_RequestParams::getParamInt('id');
        if ($shopOperationID === NULL) {
            throw new HTTP_Exception_404('Operation not is found!');
        }else {
            $model = new Model_Magazine_Shop_Operation();
            if (! $this->dublicateObjectLanguage($model, $shopOperationID)) {
                throw new HTTP_Exception_404('Operation not is found!');
            }
        }

        // получаем данные
        View_View::findOne('DB_Shop_Operation', $this->_sitePageData->shopID, "_shop/operation/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopOperationID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/operation/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/social/shopoperation/save';

        $result = Api_Shop_Operation::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
