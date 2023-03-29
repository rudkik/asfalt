<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopWriteOffType extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_WriteOff_Type';
        $this->controllerName = 'shopwriteofftype';
        $this->tableID = Model_Magazine_Shop_WriteOff_Type::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_WriteOff_Type::TABLE_NAME;
        $this->objectName = 'writeofftype';

        parent::__construct($request, $response);
    }
    
    public function action_json() {
        $this->_sitePageData->url = '/bar/shopwriteofftype/json';

        $this->_actionJSON(
            'Request_Magazine_Shop_WriteOff_Type',
            'find',
            array(
            ),
            new Model_Magazine_Shop_WriteOff_Type()
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopwriteofftype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/write-off/type/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Shop_WriteOff_Type',
            $this->_sitePageData->shopMainID, "_shop/write-off/type/list/index", "_shop/write-off/type/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/write-off/type/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopwriteofftype/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/write-off/type/one/new',
            )
        );

        $this->_requestOrganizationTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/write-off/type/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_WriteOff_Type(), '_shop/write-off/type/one/new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/write-off/type/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopwriteofftype/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/write-off/type/one/edit',
            )
        );

        // id записи
        $shopWriteOffTypeID = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_WriteOff_Type();
        if (! $this->dublicateObjectLanguage($model, $shopWriteOffTypeID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('WriteOffType not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_WriteOff_Type',
            $this->_sitePageData->shopMainID, "_shop/write-off/type/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $shopWriteOffTypeID), array()
        );

        $this->_putInMain('/main/_shop/write-off/type/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopwriteofftype/save';

        $result = Api_Magazine_Shop_WriteOff_Type::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bar/shopwriteofftype/del';
        $result = Api_Magazine_Shop_WriteOff_Type::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
