<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopMovePlace extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Place';
        $this->controllerName = 'shopmoveplace';
        $this->tableID = Model_Ab1_Shop_Move_Place::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Place::TABLE_NAME;
        $this->objectName = 'moveplace';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopmoveplace/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/place/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Move_Place', $this->_sitePageData->shopID, "_shop/move/place/list/index", "_shop/move/place/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25), array());

        $this->_putInMain('/main/_shop/move/place/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopmoveplace/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/place/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/move/place/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Move_Place(),
            '_shop/move/place/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/move/place/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopmoveplace/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/place/one/edit',
            )
        );

        // id записи
        $shopMovePlaceID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Place();
        if (! $this->dublicateObjectLanguage($model, $shopMovePlaceID, -1, FALSE)) {
            throw new HTTP_Exception_404('Move place not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Move_Place', $this->_sitePageData->shopID, "_shop/move/place/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopMovePlaceID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/move/place/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopmoveplace/save';
        $result = Api_Ab1_Shop_Move_Place::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
