<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopRealizationReturn extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Realization_Return';
        $this->controllerName = 'shoprealizationreturn';
        $this->tableID = Model_Magazine_Shop_Realization_Return::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Realization_Return::TABLE_NAME;
        $this->objectName = 'realizationreturn';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shoprealizationreturn/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/return/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Shop_Realization_Return',
            $this->_sitePageData->shopID,
            "_shop/realization/return/list/index", "_shop/realization/return/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/realization/return/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shoprealizationreturn/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/return/one/new',
                '_shop/realization/return/item/list/index',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->setIsFind(TRUE);
        $this->_sitePageData->replaceDatas['view::_shop/realization/return/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Magazine_Shop_Realization_Return(), '_shop/realization/return/item/list/index',
            '_shop/realization/return/item/one/index', $this->_sitePageData, $this->_driverDB
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->setIsFind(TRUE);
        $this->_sitePageData->replaceDatas['view::_shop/realization/return/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Realization_Return(),
            '_shop/realization/return/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/realization/return/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shoprealizationreturn/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Realization_Return();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Realization return not is found!');
        }
        $model->getElement('shop_card_id', TRUE, $this->_sitePageData->shopMainID);

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/return/one/edit',
                'view::_shop/realization/return/item/list/index',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_return_id' => $id,
                'sort_by' => array('shop_production_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Realization_Return_Item',
            $this->_sitePageData->shopID,
            '_shop/realization/return/item/list/index', '_shop/realization/return/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_production_id' => array('name', 'barcode'),
                'unit_id' => array('name')
            )
        );

        $dataID = new MyArray();
        $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        $dataID->setIsFind(TRUE);
        $this->_sitePageData->replaceDatas['view::_shop/realization/return/one/edit'] = Helpers_View::getViewObject(
            $dataID, $model, '_shop/realization/return/one/edit', $this->_sitePageData, $this->_driverDB
        );
        $this->_putInMain('/main/_shop/realization/return/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shoprealizationreturn/save';
        Helpers_Token::checkAccess($this->_sitePageData->url);

        $result = Api_Magazine_Shop_Realization_Return::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shoprealizationreturn/del';
        $result = Api_Magazine_Shop_Realization_Return::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
