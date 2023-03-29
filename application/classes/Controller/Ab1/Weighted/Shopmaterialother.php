<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopMaterialOther extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Other';
        $this->controllerName = 'shopmaterialother';
        $this->tableID = Model_Ab1_Shop_Material_Other::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Other::TABLE_NAME;
        $this->objectName = 'material';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopmaterialother/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/other/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Material_Other',
            $this->_sitePageData->shopMainID,
            "_shop/material/other/list/index", "_shop/material/other/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/material/other/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopmaterialother/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/other/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/material/other/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Other(),
            '_shop/material/other/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/material/other/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopmaterialother/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/other/one/edit',
            )
        );

        // id записи
        $shopMaterialOtherID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Other();
        if (! $this->dublicateObjectLanguage($model, $shopMaterialOtherID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Material not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Material_Other', $this->_sitePageData->shopMainID, "_shop/material/other/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopMaterialOtherID));

        $this->_putInMain('/main/_shop/material/other/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopmaterialother/save';

        $result = Api_Ab1_Shop_Material_Other::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
