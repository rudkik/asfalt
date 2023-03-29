<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopPieceItem extends Controller_Ab1_Abc_BasicAb1
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Piece_Item';
        $this->controllerName = 'shoppieceitem';
        $this->tableID = Model_Ab1_Shop_Piece_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Piece_Item::TABLE_NAME;
        $this->objectName = 'pieceitem';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/abc/shoppieceitem/index';

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE]
        );

        parent::_actionIndex(
            array(
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_formula_product_id' => array('name'),
                'shop_piece_id' => array('name', 'created_at'),
            ),
            array(
                'shop_subdivision_id' => $this->_sitePageData->operation->getProductShopSubdivisionIDsArray(),
            )
        );
    }
}
