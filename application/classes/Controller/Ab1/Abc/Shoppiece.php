<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopPiece extends Controller_Ab1_Abc_BasicAb1
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

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shoppiece/edit';
        $this->_actionShopPieceEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shoppiece/save';

        $result = Api_Ab1_Shop_Piece::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
