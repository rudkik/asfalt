<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopPiece extends Controller_Ab1_Sbyt_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Piece';
        $this->controllerName = 'shoppiece';
        $this->tableID = Model_Ab1_Shop_Piece::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Piece::TABLE_NAME;
        $this->objectName = 'piece';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/sbyt/shoppiece/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/piece/list/index',
            )
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_CASH);

        // получаем список
        View_View::find('DB_Ab1_Shop_Piece', $this->_sitePageData->shopID, "_shop/piece/list/index", "_shop/piece/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_client_id' => array('name'), 'shop_driver_id' => array('name'), 'shop_delivery_id' => array('name')));

        $this->_putInMain('/main/_shop/piece/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sbyt/shoppiece/edit';
        $this->_actionShopPieceEdit();
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/sbyt/shoppiece/del';
        $result = Api_Ab1_Shop_Piece::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shoppiece/save';

        $result = Api_Ab1_Shop_Piece::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
