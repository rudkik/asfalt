<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopPieceItem extends Controller_Ab1_Sbyt_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Piece_Item';
        $this->controllerName = 'shoppieceitem';
        $this->tableID = Model_Ab1_Shop_Piece_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Piece_Item::TABLE_NAME;
        $this->objectName = 'pieceitem';

        parent::__construct($request, $response);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shoppieceitem/save';

        $result = Api_Ab1_Shop_Piece_Item::saveItem($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result, '/sbyt/shoppieceitem/history');
    }

}
