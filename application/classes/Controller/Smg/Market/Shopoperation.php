<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopOperation extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Operation';
        $this->controllerName = 'shopoperation';
        $this->tableID = Model_AutoPart_Shop_Operation::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Operation::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/market/shopoperation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_AutoPart_Shop_Operation', $this->_sitePageData->shopID,
            "_shop/operation/list/index", "_shop/operation/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit_page' => 25,
            ),
            array(
                'shop_position_id' => array('name'),
                'shop_courier_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/operation/index');
    }


    public function action_new()
    {
        $this->_sitePageData->url = '/market/shopoperation/new';
        $this->_actionShopOperationNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/market/shopoperation/edit';
        $this->_actionShopOperationEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/market/shopoperation/save';

        $result = Api_AutoPart_Shop_Operation::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function _actionShopOperationNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/new',
            )
        );

        $this->_requestListDB('DB_AutoPart_Shop_Position');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/operation/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Operation(),
            '_shop/operation/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/operation/new');
    }

    public function _actionShopOperationEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/one/edit',
            )
        );

        // id записи
        $shopOperationID = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Operation();
        if (! $this->dublicateObjectLanguage($model, $shopOperationID, -1, false)) {
            throw new HTTP_Exception_404('Operation not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Position', $model->getShopPositionID());
        $this->_requestListDB('DB_AutoPart_Shop_Courier', $model->getShopCourierID());

        // получаем данные
        View_View::findOne(
            'DB_Shop_Operation', $this->_sitePageData->shopID, "_shop/operation/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopOperationID)
        );

        $this->_putInMain('/main/_shop/operation/edit');
    }
}
