<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Bookkeeping_ShopTaxView extends Controller_Nur_Bookkeeping_BasicNur {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptaxview';
        $this->tableID = Model_Nur_Shop_Tax_View::TABLE_ID;
        $this->tableName = Model_Nur_Shop_Tax_View::TABLE_NAME;
        $this->objectName = 'taxview';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptaxview/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/view/list/index',
            )
        );

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit_page' => 25,
            ),
            TRUE
        );
        View_View::find('DB_Nur_Shop_Tax_View',
            $this->_sitePageData->shopMainID,
            "_shop/tax/view/list/index", "_shop/tax/view/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(),
            TRUE, TRUE

        );

        $this->_putInMain('/main/_shop/tax/view/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptaxview/json';

        $this->_actionJSON(
            'Request_Nur_Shop_Tax_View',
            'findShopTaxViewIDs',
            array(),
            new Model_Nur_Shop_Tax_View()
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptaxview/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/view/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/tax/view/one/new'] = Helpers_View::getViewObject($dataID, new Model_Nur_Shop_Tax_View(),
            '_shop/tax/view/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/tax/view/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptaxview/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/view/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Nur_Shop_Tax_View();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Tax view not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Nur_Shop_Tax_View', $this->_sitePageData->shopID, "_shop/tax/view/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/tax/view/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shoptaxview/save';

        $result = Api_Nur_Shop_Tax_View::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
