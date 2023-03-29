<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopWorkShift extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Work_Shift';
        $this->controllerName = 'shopworkshift';
        $this->tableID = Model_Ab1_Shop_Work_Shift::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Work_Shift::TABLE_NAME;
        $this->objectName = 'workshift';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopworkshift/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/shift/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Work_Shift',
            $this->_sitePageData->shopID,
            "_shop/work/shift/list/index", "_shop/work/shift/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/work/shift/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopworkshift/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/shift/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/work/shift/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Work_Shift(),
            '_shop/work/shift/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/work/shift/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopworkshift/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/shift/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Work_Shift();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Driver not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Work_Shift', $this->_sitePageData->shopID, "_shop/work/shift/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        $this->_putInMain('/main/_shop/work/shift/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopworkshift/save';

        $result = Api_Ab1_Shop_Work_Shift::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

