<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopMoveOther extends Controller_Ab1_Abc_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Other';
        $this->controllerName = 'shopmoveother';
        $this->tableID = Model_Ab1_Shop_Move_Other::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Other::TABLE_NAME;
        $this->objectName = 'moveother';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/abc/shopmoveother/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/other/list/index',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestShopMovePlaces();
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);

        // получаем список
        View_View::find('DB_Ab1_Shop_Move_Other', $this->_sitePageData->shopID, "_shop/move/other/list/index", "_shop/move/other/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 1),
            array(
                'shop_move_place_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_driver_id' => array('name'),
                'weighted_exit_operation_id' => array('name'),
                'shop_formula_material_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/move/other/index');
    }
}
