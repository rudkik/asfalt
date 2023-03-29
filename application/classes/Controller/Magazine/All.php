<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_All extends Controller_Magazine_BasicList
{

    public function _actionShopProductNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/new',
            )
        );

        $this->_requestShopProductRubrics(NULL, NULL);
        $this->_requestUnits();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/product/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Product(),
            '_shop/product/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/new');
    }

    public function _actionShopProductEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/one/edit',
            )
        );

        // id записи
        $shopProductID = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $shopProductID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        $this->_requestShopProductRubrics($model->getShopProductRubricID(), NULL);
        $this->_requestUnits($model->getUnitID());

        // получаем данные
        $this->_sitePageData->newShopShablonPath('magazine/_all');
        View_View::findOne('DB_Magazine_Shop_Product', $this->_sitePageData->shopMainID, "_shop/product/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopProductID));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/edit');
    }

    public function _actionShopMoveNew()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/one/new',
                '_shop/move/item/list/index',
            )
        );

        $this->_requestShopBranches(NULL,Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/move/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Magazine_Shop_Move(), '_shop/move/item/list/index',
            '_shop/move/item/one/index', $this->_sitePageData, $this->_driverDB
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/move/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Move(),
            '_shop/move/one/new', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/new');
    }

    public function _actionShopMoveEdit()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/one/edit',
                '_shop/move/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Move();
        if (! $this->dublicateObjectLanguage($model, $id, 0, FALSE)) {
            throw new HTTP_Exception_404('Move not is found!');
        }
        $model->getElement('shop_card_id', TRUE, $this->_sitePageData->shopMainID);

        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        $this->_sitePageData->newShopShablonPath('magazine/_all');

        $params = Request_RequestParams::setParams(
            array(
                'shop_move_id' => $id,
                'sort_by' => array('shop_production_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID,
            '_shop/move/item/list/index', '_shop/move/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_production_id' => array('name'))
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Move',
            $this->_sitePageData->shopID, "_shop/move/one/edit", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/edit');
    }

    protected function _actionShopProductionRubricStatistics()
    {
        $basicList = array(
            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_year' => 0,
        );

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/rubric/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_production_rubric_id.id', 'shop_production_rubric_id.name',
                ),
            )
        );

        $elements = array(
            'shop_production_rubric_id' => array('name', 'id'),
        );

        $ids = Request_Request::find(
            'DB_Magazine_Shop_Realization_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE, $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->getElementValue('shop_production_rubric_id', 'id');
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['amount_day'] += $child->values['amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->getElementValue('shop_production_rubric_id', 'id');
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['amount_yesterday'] += $child->values['amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->getElementValue('shop_production_rubric_id', 'id');
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['amount_week'] += $child->values['amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->getElementValue('shop_production_rubric_id', 'id');
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['amount_month'] += $child->values['amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $objectID = $child->getElementValue('shop_production_rubric_id', 'id');
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['amount_year'] += $child->values['amount'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $objectID = $child->getElementValue('shop_production_rubric_id', 'id');
            if(!key_exists($objectID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$objectID] = $child;
            }

            $listIDs->childs[$objectID]->additionDatas['amount'] += $child->values['amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray(
                'sort_by', array(),
                array(
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_production_rubric_id.name' => 'asc',
                )
            ),
            true, true
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/production/rubric/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/production/rubric/list/statistics','_shop/production/rubric/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/production/rubric/statistics');
    }

    protected function _actionShopTalonStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/talon/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'period_from' => date('Y').'-01-01',
                'period_to' => date('Y').'-12-31 23:59:59',
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'validity_from',
                    'validity_to',
                ),
            )
        );

        $elements = array();

        $ids = Request_Request::find('DB_Magazine_Shop_Talon',
            0, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $params = Request_RequestParams::setParams(
                array(
                    'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                    'created_at_from_equally' => $child->values['validity_from'],
                    'created_at_to' => $child->values['validity_to'].' 23:59:59',
                    'sum_quantity' => TRUE,
                    'sum_amount' => TRUE,
                    'group_by' => array(
                        'validity_from',
                        'validity_to',
                    ),
                )
            );

            $items = Request_Request::find('DB_Magazine_Shop_Realization_Item',
                0, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            $child->values['quantity_spent'] = $items->childs[0]->values['quantity'] * 2;
            $child->values['amount_spent'] = $items->childs[0]->values['amount'];
            $child->values['amount'] = $items->childs[0]->values['amount']
                / ($items->childs[0]->values['quantity'] * 2) * $child->values['quantity'];
            $listIDs->childs[] = $child;
        }

        // итог
        $total = array(
            'quantity' => 0,
            'quantity_spent' => 0,
            'amount' => 0,
            'amount_spent' => 0,
        );
        foreach ($listIDs->childs as $key => $child){
            $total['quantity'] += $child->values['quantity'];
            $total['quantity_spent'] += $child->values['quantity_spent'];
            $total['amount'] += $child->values['amount'];
            $total['amount_spent'] += $child->values['amount_spent'];
        }
        $listIDs->additionDatas = $total;

        $listIDs->childsSortBy(
            array(
                'validity_from' => 'desc',
            ),
            true, true
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/talon/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/talon/list/statistics','_shop/talon/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/talon/statistics');
    }

    protected function _actionShopRealizationItemWriteOffStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/item/write-off/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
                'group_by' => array(
                    'shop_production_id', 'shop_production_id.name',
                    'unit_id.name',
                ),
            )
        );

        $elements = array(
            'shop_production_id' => array('name'),
            'unit_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'quantity_day' => $child->values['quantity'],
                'quantity_yesterday' => 0,
                'quantity_week' => 0,
                'quantity_month' => 0,
                'quantity_year' => 0,
            );

            $listIDs->childs[$child->values['shop_production_id']] = $child;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $total = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_year' => 0,
        );
        foreach ($listIDs->childs as $key => $child){
            $total['quantity_day'] += $child->additionDatas['quantity_day'];
            $total['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'];
            $total['quantity_week'] += $child->additionDatas['quantity_week'];
            $total['quantity_month'] += $child->additionDatas['quantity_month'];
            $total['quantity_year'] += $child->additionDatas['quantity_year'];
        }
        $listIDs->additionDatas = $total;

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_production_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/realization/item/write-off/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/realization/item/write-off/list/statistics','_shop/realization/item/write-off/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/realization/item/write-off/statistics');
    }

    protected function _actionShopRealizationWriteOffStatistics()
    {
        $basicList = array(
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
        );

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/write-off/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        // итог
        $listIDs->additionDatas['quantity'] = $basicList;
        $listIDs->additionDatas['amount'] = $basicList;

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
                'sum_quantity' => TRUE,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_write_off_type_id', 'shop_write_off_type_id.name',
                ),
            )
        );

        $elements = array(
            'shop_write_off_type_id' => array('name'),
        );

        $year = date('Y');
        for ($i = 1; $i < 13; $i++){
            $params['created_at_from'] = Helpers_DateTime::getMonthBeginStr($i, $year);
            $params['created_at_to'] = Helpers_DateTime::plusDays(Helpers_DateTime::getMonthEndStr($i, $year), 1);

            $ids = Request_Request::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
            foreach ($ids->childs as $child){
                $objectID = $child->values['shop_write_off_type_id'];
                if(!key_exists($objectID, $listIDs->childs)){
                    $child->additionDatas['quantity'] = $basicList;
                    $child->additionDatas['amount'] = $basicList;
                    $listIDs->childs[$objectID] = $child;
                }

                $listIDs->childs[$objectID]->additionDatas['quantity'][$i] += $child->values['quantity'];
                $listIDs->childs[$objectID]->additionDatas['amount'][$i] += $child->values['amount'];

                $listIDs->additionDatas['quantity'][$i] += $child->values['quantity'];
                $listIDs->additionDatas['amount'][$i] += $child->values['amount'];
            }
        }

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_write_off_type_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/realization/write-off/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/realization/write-off/list/statistics','_shop/realization/write-off/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/realization/write-off/statistics');
    }

    protected function _actionShopMoveItemStatistics()
    {
        $branchMoveID = Request_RequestParams::getParamInt('branch_move_id');

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/item/list/statistics',
            )
        );
        $this->_sitePageData->replaceDatas['view::_shop/branch/move/list/list'] =
            $this->_requestShopBranches($branchMoveID, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'branch_move_id' => $branchMoveID,
                'group_by' => array(
                    'shop_production_id', 'shop_production_id.name',
                    'unit_id.name',
                ),
            )
        );

        $elements = array(
            'shop_production_id' => array('name'),
            'unit_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'quantity_day' => $child->values['quantity'],
                'quantity_yesterday' => 0,
                'quantity_week' => 0,
                'quantity_month' => 0,
                'quantity_year' => 0,
            );

            $listIDs->childs[$child->values['shop_production_id']] = $child;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $total = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_year' => 0,
        );
        foreach ($listIDs->childs as $key => $child){
            $total['quantity_day'] += $child->additionDatas['quantity_day'];
            $total['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'];
            $total['quantity_week'] += $child->additionDatas['quantity_week'];
            $total['quantity_month'] += $child->additionDatas['quantity_month'];
            $total['quantity_year'] += $child->additionDatas['quantity_year'];
        }
        $listIDs->additionDatas = $total;

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_production_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/move/item/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/move/item/list/statistics','_shop/move/item/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/item/statistics');
    }

    protected function _actionShopMoveStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'shop_id' => $this->_sitePageData->shopID,
                'group_by' => array(
                    'branch_move_id', 'branch_move_id.name',
                    'shop_id', 'shop_id.name',
                ),
            )
        );

        $elements = array(
            'branch_move_id' => array('name'),
        );

        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move', array(),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'quantity_day' => $child->values['quantity'],
                'quantity_yesterday' => 0,
                'quantity_week' => 0,
                'quantity_month' => 0,
                'quantity_year' => 0,
            );

            $listIDs->childs[$child->values['branch_move_id']] = $child;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move', array(),
            $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['branch_move_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move', array(),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['branch_move_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move', array(),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['branch_move_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move', array(),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['branch_move_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move', array(),
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['branch_move_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = array(
                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $total = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_year' => 0,
        );
        foreach ($listIDs->childs as $key => $child){
            $total['quantity_day'] += $child->additionDatas['quantity_day'];
            $total['quantity_yesterday'] += $child->additionDatas['quantity_yesterday'];
            $total['quantity_week'] += $child->additionDatas['quantity_week'];
            $total['quantity_month'] += $child->additionDatas['quantity_month'];
            $total['quantity_year'] += $child->additionDatas['quantity_year'];
        }
        $listIDs->additionDatas = $total;

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.branch_move_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/move/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/move/list/statistics','_shop/move/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/move/statistics');
    }

    protected function _actionShopRealizationItemStatistics()
    {
        $shopWorkerID = Request_RequestParams::getParamInt('shop_worker_id');
        $shopProductionRubricID = Request_RequestParams::getParamInt('shop_production_rubric_id');

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/item/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);
        if($shopWorkerID !== null){
            $this->_requestShopWorkers($shopWorkerID);
        }
        if($shopProductionRubricID !== null){
            $this->_requestShopProductionRubrics($shopProductionRubricID);
        }

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'shop_worker_id' => $shopWorkerID,
                'shop_production_rubric_id' => $shopProductionRubricID,
                'group_by' => array(
                    'shop_production_id', 'shop_production_id.name',
                    'unit_id.name',
                ),
            )
        );

        $elements = array(
            'shop_production_id' => array('name'),
            'unit_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'amount_day' => $child->values['amount'],
                'amount_yesterday' => 0,
                'amount_week' => 0,
                'amount_month' => 0,
                'amount_year' => 0,

                'quantity_day' => $child->values['quantity'],
                'quantity_yesterday' => 0,
                'quantity_week' => 0,
                'quantity_month' => 0,
                'quantity_year' => 0,
            );

            $listIDs->childs[$child->values['shop_production_id']] = $child;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,

                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['amount'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,

                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['amount'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,

                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['amount'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,

                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['amount'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_production_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,

                    'quantity_day' => 0,
                    'quantity_yesterday' => 0,
                    'quantity_week' => 0,
                    'quantity_month' => 0,
                    'quantity_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['amount'];
            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_year',

                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            Request_RequestParams::getParamArray(
                'sort_by', array(),
                array(
                    Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_production_id.name' => 'asc',
                )
            ),
            true, true
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/realization/item/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/realization/item/list/statistics','_shop/realization/item/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/realization/item/statistics');
    }

    protected function _actionShopRealizationStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/realization/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);
        $this->_requestShopWorkers();

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'shop_worker_id' => Request_RequestParams::getParamInt('shop_worker_id'),
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_worker_id', 'shop_worker_id.name',
                ),
            )
        );

        $elements = array(
            'shop_worker_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'amount_day' => $child->values['amount'],
                'amount_yesterday' => 0,
                'amount_week' => 0,
                'amount_month' => 0,
                'amount_year' => 0,
            );

            $listIDs->childs[$child->values['shop_worker_id']] = $child;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_worker_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_worker_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_worker_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_worker_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['amount'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Realization',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_worker_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['amount'];
        }*/

        // итог
        $total = array(
            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_year' => 0,
        );
        foreach ($listIDs->childs as $key => $child){
            $total['amount_day'] += $child->additionDatas['amount_day'];
            $total['amount_yesterday'] += $child->additionDatas['amount_yesterday'];
            $total['amount_week'] += $child->additionDatas['amount_week'];
            $total['amount_month'] += $child->additionDatas['amount_month'];
            $total['amount_year'] += $child->additionDatas['amount_year'];
        }
        $listIDs->additionDatas = $total;

        // Находим наличные
        if(key_exists(0, $listIDs->childs)){
            $listIDs->additionDatas['cash'] = $listIDs->childs[0]->additionDatas;
            unset($listIDs->childs[0]);
        }else{
            $listIDs->additionDatas['cash'] = array(
                'amount_day' => 0,
                'amount_yesterday' => 0,
                'amount_week' => 0,
                'amount_month' => 0,
                'amount_year' => 0,
            );
        }

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/realization/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/realization/list/statistics','_shop/realization/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/realization/statistics');
    }

    protected function _actionShopReceiveItemStatistics()
    {
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');

        $basicList = array(
            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_year' => 0,

            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_year' => 0,
        );

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/item/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);
        $this->_requestShopSupplier($shopSupplierID);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_amount' => TRUE,
                'sum_quantity' => true,
                'shop_supplier_id' => $shopSupplierID,
                'group_by' => array(
                    'shop_product_id', 'shop_product_id.name',
                    'unit_id.name',
                ),
            )
        );

        $elements = array(
            'shop_product_id' => array('name'),
            'unit_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_day'] += $child->values['amount'];
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $basicList;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['amount'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_product_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $basicList;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity'] += $child->values['quantity'];
            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['amount'];
        }*/

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'amount_day',
                'amount_yesterday',
                'amount_week',
                'amount_month',
                'amount_year',

                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_year',
            ),
            true
        );

        $listIDs->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name',
            )
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/receive/item/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/receive/item/list/statistics','_shop/receive/item/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/receive/item/statistics');
    }

    protected function _actionShopReceiveStatistics()
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/list/statistics',
            )
        );
        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_supplier_id', 'shop_supplier_id.name',
                ),
            )
        );

        $elements = array(
            'shop_supplier_id' => array('name'),
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $child->additionDatas = array(
                'amount_day' => $child->values['amount'],
                'amount_yesterday' => 0,
                'amount_week' => 0,
                'amount_month' => 0,
                'amount_year' => 0,
            );

            $listIDs->childs[$child->values['shop_supplier_id']] = $child;
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['created_at_to'] = $dateFrom;
        $paramsYesterday['created_at_from'] = Helpers_DateTime::minusDays($dateFrom, 1);

        $ids = Request_Request::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_supplier_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_yesterday'] += $child->values['amount'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_supplier_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_week'] += $child->values['amount'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_supplier_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_month'] += $child->values['amount'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['created_at_from'] = $dateFrom;

        $ids = Request_Request::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
        );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_supplier_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount_year'] += $child->values['amount'];
        }

        // задаем время выборки с за все время
        /* $params['created_at_from'] = NULL;

         $ids = Request_Request::find('DB_Magazine_Shop_Receive',
             $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            $elements
         );
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_supplier_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = array(
                    'amount_day' => 0,
                    'amount_yesterday' => 0,
                    'amount_week' => 0,
                    'amount_month' => 0,
                    'amount_year' => 0,
                );
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['amount'] += $child->values['amount'];
        }*/

        // итог
        $total = array(
            'amount_day' => 0,
            'amount_yesterday' => 0,
            'amount_week' => 0,
            'amount_month' => 0,
            'amount_year' => 0,
        );
        foreach ($listIDs->childs as $key => $child){
            $total['amount_day'] += $child->additionDatas['amount_day'];
            $total['amount_yesterday'] += $child->additionDatas['amount_yesterday'];
            $total['amount_week'] += $child->additionDatas['amount_week'];
            $total['amount_month'] += $child->additionDatas['amount_month'];
            $total['amount_year'] += $child->additionDatas['amount_year'];
        }
        $listIDs->additionDatas = $total;

        $listIDs->childsSortBy(
            array(
                'amount_year',
            ),
            false
        );

        $this->_sitePageData->countRecord = count($listIDs->childs);

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $this->_sitePageData->replaceDatas['view::_shop/receive/list/statistics'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/receive/list/statistics','_shop/receive/one/statistics',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/receive/statistics');
    }
}