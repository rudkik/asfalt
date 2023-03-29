<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopTransportWaybill extends Controller_Ab1_Make_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Waybill';
        $this->controllerName = 'shoptransportwaybill';
        $this->tableID = Model_Ab1_Shop_Transport_Waybill::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Waybill::TABLE_NAME;
        $this->objectName = 'transportwaybill';

        parent::__construct($request, $response);
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_director_index() {
        $this->_sitePageData->url = '/make/shoptransportwaybill/director_index';

        $this->_requestShopTransports();

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find(
            'DB_Ab1_Shop_Transport_Waybill', $this->_sitePageData->shopID,
            '_shop/transport/waybill/list/director-index', '_shop/transport/waybill/one/director-index',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array(
                        'date' => 'desc',
                    ),
                    'limit_page' => 25,
                ),
                false
            ),
            array(
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name'),
                'create_user_id' => array('name'),
                'update_user_id' => array('name'),
                'transport_wage_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/waybill/director-index');
    }


    public function action_edit()
    {
        $this->_sitePageData->url = '/make/shoptransportwaybill/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Waybill();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestShopBranches(null, true);
        $this->_requestListDB('DB_Ab1_Shop_Transport_Route');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver', $model->getShopTransportDriverID());
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Fuel_Issue');

        $this->_requestShopTransports($model->getShopTransportID(), false);
        $this->_requestShopTransports(null, true, 'trailer');

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        // выработки транспорта
        Helpers_View::getViews(
            '_shop/transport/waybill/transport/list/index', '_shop/transport/waybill/transport/one/index',
            $this->_sitePageData, $this->_driverDB
        );

        // выработки водителя
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $id,
                'sort_by' => array(
                    'shop_transport_work_id.name' => 'asc',
                ),
            )
        );
        View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Driver::NAME, $this->_sitePageData->shopID,
            '_shop/transport/waybill/work/driver/list/index', '_shop/transport/waybill/work/driver/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_transport_work_id' => array('name', 'indicator_type_id'),
            )
        );

        // перевозки
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $id,
                'sort_by' => array(
                    'created_at' => 'asc',
                ),
            )
        );
        View_View::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, $this->_sitePageData->shopID,
            '_shop/transport/waybill/car/list/index', '_shop/transport/waybill/car/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_to_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_ballast_crusher_to_id' => array('name'),
                'shop_ballast_crusher_from_id' => array('name'),
                'shop_transportation_place_to_id' => array('name'),
                'shop_transport_route_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_move_place_to_id' => array('name'),
                'shop_move_client_to_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

