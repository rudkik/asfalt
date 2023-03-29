<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopCar extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Car';
        $this->controllerName = 'shopcar';
        $this->tableID = Model_Ab1_Shop_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Car::TABLE_NAME;
        $this->objectName = 'car';

        parent::__construct($request, $response);
    }

    public function action_check() {
        $this->_sitePageData->url = '/atc/shopcar/check';

        $result = new MyArray();

        $params = array_merge($_GET, $_POST);
        unset($params['limit_page']);
        $params = Request_RequestParams::setParams(
            array_merge(
                $params,
                array(
                    'created_at_from' => '2020-12-31 23:59:59',
                    'shop_transport_id_from' => 0,
                    'shop_transport_waybill_id' => 0,
                    'quantity_from' => 0,
                )
            )
        );
        $elements = ['shop_transport_id' => ['name']];

        // получаем реализацию
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Car::TABLE_ID]);
        $result->addChilds($ids);

        // получаем штучный товар
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Piece::TABLE_ID]);
        $result->addChilds($ids);

        // получаем перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Car', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Move_Car::TABLE_ID]);
        $result->addChilds($ids);

        // получаем брак
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Defect_Car', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Defect_Car::TABLE_ID]);
        $result->addChilds($ids);

        // получаем прочие перемещение
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Move_Other', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Move_Other::TABLE_ID]);
        $result->addChilds($ids);

        // получаем ответ.хранения
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Lessee_Car', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Lessee_Car::TABLE_ID]);
        $result->addChilds($ids);

        // получаем завоз материала
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car_To_Material', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Car_To_Material::TABLE_ID]);
        $result->addChilds($ids);

        // получаем балласт
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Ballast', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Ballast::TABLE_ID]);
        $ids->replaceChildValue('created_at', 'date');
        $result->addChilds($ids);

        // получаем перевозки внутри карьера
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Transportation', 0, $this->_sitePageData, $this->_driverDB, $params,
            0, true, $elements
        );
        $ids->addAdditionDataChilds(['table_id' => Model_Ab1_Shop_Transportation::TABLE_ID]);
        $ids->replaceChildValue('created_at', 'date');

        $result->addChilds($ids);

        $result->childsSortBy(Request_RequestParams::getParamArray('sort_by', [], ['created_at' => 'asc']), true, true);

        Helpers_View::getViews(
            '_shop/car/list/check', '_shop/car/one/check',
            $this->_sitePageData, $this->_driverDB, $result
        );

        $this->_requestShopTransports();
        $this->_requestShopBranches(null, true);

        $this->_putInMain('/main/_shop/car/check');
    }
}