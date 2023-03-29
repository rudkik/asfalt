<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopMove extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Move';
        $this->controllerName = 'shopmove';
        $this->tableID = Model_Magazine_Shop_Move::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Move::TABLE_NAME;
        $this->objectName = 'move';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopmove/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/list/index',
            )
        );

        $this->_requestShopCard();
        $this->_requestShopBranches(
            NULL,  Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE
        );

        // получаем список
        View_View::findBranch(
            'DB_Magazine_Shop_Move', array(),
            "_shop/move/list/index", "_shop/move/one/index",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'sort_by' => array(
                        'created_at' => 'desc'
                    ),
                ), false
            ),
            array(
                'shop_id' => array('name'),
                'branch_move_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/move/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopmove/new';
        $this->_actionShopMoveNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopmove/edit';
        $this->_actionShopMoveEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopmove/save';
        Helpers_Token::checkAccess($this->_sitePageData->url);

        $result = Api_Magazine_Shop_Move::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bar/shopmove/del';
        $result = Api_Magazine_Shop_Move::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
