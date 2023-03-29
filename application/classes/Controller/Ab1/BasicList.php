<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_BasicList extends Controller_Ab1_BasicShop
{
    /**
     * Делаем запрос на список транспорта
     * @param null $currentID
     * @param null $isTrailer
     * @param string $file
     * @return string
     */
    protected function _requestShopTransports($currentID = NULL, $isTrailer = null, $file = 'list'){
        return $this->_requestListDB(
            'DB_Ab1_Shop_Transport', $currentID, $this->_sitePageData->shopMainID,
            Request_RequestParams::setParams(
                array(
                    'is_trailer' => $isTrailer,
                    'sort_by' => array(
                        'shop_transport_mark_id.name' => 'asc',
                        'number' => 'asc',
                    ),
                )
            ),
            array('shop_transport_mark_id' => array('name')),
            $file
        );
    }

    /**
     * Делаем запрос на список мест для слива сырья
     * @param null $currentID
     * @param bool $isShowRaw
     * @return string
     */
    protected function _requestShopRawDrainChutes($currentID = NULL, $isShowRaw = false)
    {
        $elements = null;
        if($isShowRaw){
            $elements = array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
            );
        }

        return $this->_requestListDB(
            'DB_Ab1_Shop_Raw_DrainChute', $currentID, 0, array(), $elements
        );
    }

    /**
     * Делаем запрос на список группы рецептов
     * @param null $currentID
     * @param int $shopProductRubricID
     */
    protected function _requestShopFormulaGroups($currentID = NULL, $shopProductRubricID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/group/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_rubric_id' => $shopProductRubricID,
                'sort_by' => array(
                    'name' => 'asc'
                )
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Formula_Group',
            $this->_sitePageData->shopMainID,
            "_shop/formula/group/list/list", "_shop/formula/group/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/formula/group/list/list'] = $data;
    }

    /**
     * Делаем запрос на список рубрик
     * @param null $currentID
     * @param int $rootID
     */
    protected function _requestShopProductPricelistRubrics($currentID = NULL, $rootID = 0)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/pricelist/rubric/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'root_id' => $rootID,
                'sort_by' => array(
                    'name' => 'asc'
                )
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Product_Pricelist_Rubric',
            $this->_sitePageData->shopMainID,
            "_shop/product/pricelist/rubric/list/list", "_shop/product/pricelist/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/product/pricelist/rubric/list/list'] = $data;
    }

    /**
     * Работники
     * @param null $currentID
     */
    protected function _requestShopWorkers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::findBranch('DB_Ab1_Shop_Worker',
            $this->_sitePageData->shopMainID,
            "_shop/worker/list/list", "_shop/worker/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/worker/list/list'] = $data;
    }

    /**
     * Статусы договоров
     * @param null $currentID
     */
    protected function _requestClientContractStatuses($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/status/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_ClientContract_Status',
            $this->_sitePageData->shopMainID,
            "client-contract/status/list/list", "client-contract/status/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::client-contract/status/list/list'] = $data;
    }

    /**
     * Категории договоров
     * @param null $currentID
     * @param bool $isRoot
     * @param array $params
     */
    protected function _requestClientContractTypes($currentID = NULL, $isRoot = false, array $params = [])
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/type/list/list',
            )
        );

        if($isRoot === false){
            $params['root_id_not'] = 0;
        }else{
            $params['root_id'] = 0;
        }

        $params = Request_RequestParams::setParams(
            array_merge(
                $params,
                array(
                    'sort_by' => array('name' => 'asc'),
                )
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_ClientContract_Type',
            $this->_sitePageData->shopMainID,
            "client-contract/type/list/list", "client-contract/type/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::client-contract/type/list/list'] = $data;
    }

    /**
     * Тип формулы
     * @param null $currentID
     * @param int $particleTypeID
     * @return mixed|MyArray|string
     */
    protected function _requestFormulaTypes($currentID = NULL, $particleTypeID = Model_Ab1_FormulaType::PARTICLE_TYPE_PRODUCT)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::formula-type/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
                'particle_type_id' => $particleTypeID,
            )
        );


        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_FormulaType',
            $this->_sitePageData->shopMainID,
            "formula-type/list/list", "formula-type/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::formula-type/list/list'] = $data;

        return $data;
    }

    /**
     * Список фискальных регистраторов
     * @param null $currentID
     * @param bool $isBranch
     */
    protected function _requestShopCashboxes($currentID = NULL, $isBranch = false)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/cashbox/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        if($isBranch){
            $data = View_View::findBranch('DB_Ab1_Shop_Cashbox',
                $this->_sitePageData->shopMainID,
                "_shop/cashbox/list/list", "_shop/cashbox/one/list",
                $this->_sitePageData, $this->_driverDB,
                $params
            );
        }else {
            $data = View_View::find('DB_Ab1_Shop_Cashbox',
                $this->_sitePageData->shopID,
                "_shop/cashbox/list/list", "_shop/cashbox/one/list",
                $this->_sitePageData, $this->_driverDB,
                $params
            );
        }
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/cashbox/list/list'] = $data;
        }
    }

    /**
     * Список весов, для материалов
     * @param null $currentID
     */
    protected function _requestDaughterWeights($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::daughter-weight/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_DaughterWeight',
            $this->_sitePageData->shopMainID,
            "daughter-weight/list/list", "daughter-weight/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::daughter-weight/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список банков
     * @param null|int $currentID
     */
    protected function _requestBanks($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::bank/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Bank', $this->_sitePageData->shopID,
            "bank/list/list", "bank/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::bank/list/list'] = $data;
        }
    }

    /**
     * Список клиентов
     * @param null $currentID
     * @param null $clientTypeID
     */
    protected function _requestShopClients($currentID = NULL, $clientTypeID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'client_type_id' => $clientTypeID,
                'sort_by' => array('name' => 'asc'),
                'id_not' => 175747,
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Client',
            $this->_sitePageData->shopMainID,
            "_shop/client/list/list", "_shop/client/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/client/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список видов проверок
     * @param null $currentID
     */
    protected function _requestCheckTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::check-type/list/list',
            )
        );

        $data = View_View::find('DB_Ab1_CheckType', 0,
            "check-type/list/list", "check-type/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc')))
        );

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::check-type/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список типов оплат
     * @param null $currentID
     */
    protected function _requestPaymentTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::payment-type/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_PaymentType',0,
            "payment-type/list/list", "payment-type/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::payment-type/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список причин невыбора запланированных объемов за день
     * @param null|int $currentID
     */
    protected function _requestPlanReasonTypes($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::plan-reason-type/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_PlanReasonType',
            $this->_sitePageData->shopID,
            "plan-reason-type/list/list", "plan-reason-type/one/list", $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(array('sort_by' => array('name' => 'asc')))
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::plan-reason-type/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список типов оплаты актов выполненных работ
     * @param null $currentID
     */
    protected function _requestActServicePaidTypes($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::act-service-paid-type/list/list',
            )
        );

        $data = View_View::find('DB_Ab1_ActServicePaidType', $this->_sitePageData->shopMainID,
            "act-service-paid-type/list/list", "act-service-paid-type/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::act-service-paid-type/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список складов продукции
     * @param null $currentID
     * @param int $shopID
     * @param bool $isIgnoreIsPublic
     * @param null $shopSubdivisionID
     */
    protected function _requestShopStorages($currentID = NULL, $shopID = 0, $isIgnoreIsPublic = FALSE, $shopSubdivisionID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isIgnoreIsPublic,
                'shop_subdivision_id' => $shopSubdivisionID,
                'sort_by' => array('name' => 'asc')
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Storage',
            $shopID, "_shop/storage/list/list", "_shop/storage/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/storage/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список типов продукции
     * @param null $currentID
     * @param string $file
     */
    protected function _requestProductTypes($currentID = NULL, $file = 'list')
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::product/type/list/'.$file,
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_ProductType',
            $this->_sitePageData->shopID,
            "product/type/list/".$file, "product/type/one/".$file,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array('name' => 'asc')
                )
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::product/type/list/'.$file] = $data;
    }

    /**
     * Делаем запрос на список видов продукции
     * @param null $currentID
     * @param string $file
     */
    protected function _requestProductViews($currentID = NULL, $file = 'list')
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::product/view/list/'.$file,
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_ProductView',
            $this->_sitePageData->shopID,
            "product/view/list/".$file, "product/view/one/".$file,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array('name' => 'asc')
                )
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::product/view/list/'.$file] = $data;
    }

    /**
     * Список филиалов магазинов
     * @param null $currentID
     * @return mixed|string
     */
    protected function _requestShopBranchesMagazine($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_table_rubric_id' => Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE,
                'sort_by' => array(
                    'name' => 'asc',
                )
            )
        );
        $ids = Request_Request::findNotShop('DB_Shop',
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] =
        $data = Helpers_View::getViewObjects($ids, new Model_Shop(), "_shop/branch/list/list",
            "_shop/branch/one/list", $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Список филиалов
     * @param null $currentID
     * @param bool $isMain
     * @param string $file
     * @param array $params
     */
    protected function _requestShopBranches($currentID = NULL, $isMain = FALSE, $file = 'list', array $params = array())
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/'.$file,
            )
        );

        $params = Request_RequestParams::setParams(
            $params
        );
        $ids = Request_Shop::findShopBranchIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE);

        if($isMain) {
            $tmp = new MyArray();
            $tmp->values = $this->_sitePageData->shopMain->getValues(TRUE, TRUE);
            $tmp->isLoadElements = TRUE;
            $tmp->isFindDB = TRUE;
            $ids->childs = array_merge(
                array($this->_sitePageData->shopMainID => $tmp),
                $ids->childs
            );
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/branch/list/'.$file] =
        $data = Helpers_View::getViewObjects($ids, new Model_Shop(), "_shop/branch/list/".$file,
            "_shop/branch/one/".$file, $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/'.$file] = $data;
        }
    }

    /**
     * Список станций отправлеия
     * @param null $currentID
     */
    protected function _requestShopBoxcarClients($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/client/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Boxcar_Client', $this->_sitePageData->shopMainID,
            "_shop/boxcar/client/list/list", "_shop/boxcar/client/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/boxcar/client/list/list'] = $data;
        }
    }

    /**
     * Список поставщиков сырья
     * @param null $currentID
     */
    protected function _requestShopBoxcarDepartureStations($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/departure/station/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Boxcar_Departure_Station', $this->_sitePageData->shopMainID,
            "_shop/boxcar/departure/station/list/list", "_shop/boxcar/departure/station/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/boxcar/departure/station/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список КАТО
     * @param null $currentID
     */
    protected function _requestKatos($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::kato/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Kato', $this->_sitePageData->shopID,
            "kato/list/list", "kato/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::kato/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список типов организации
     * @param null $currentID
     */
    protected function _requestOrganizationTypes($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::organizationtype/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_OrganizationType', $this->_sitePageData->shopID,
            "organizationtype/list/list", "organizationtype/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'land_id' => '3161',
                'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::organizationtype/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список тарифов дистанций
     * @param null|int $currentID
     */
    protected function _requestShopBallastDistanceTariffs($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/tariff/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Ballast_Distance_Tariff', $this->_sitePageData->shopID,
            "_shop/ballast/distance/tariff/list/list", "_shop/ballast/distance/tariff/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/distance/tariff/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список дробилок
     * @param null $currentID
     * @param array $params
     * @param string $file
     */
    protected function _requestShopBallastCrushers($currentID = NULL, array $params = array(), $file = 'list')
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/crusher/list/'.$file,
            )
        );

        $params = Request_RequestParams::setParams(
            array_merge(
                $params,
                array(
                    'sort_by' => array('name' => 'asc')
                )
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find(
            'DB_Ab1_Shop_Ballast_Crusher', $this->_sitePageData->shopID,
            "_shop/ballast/crusher/list/".$file, "_shop/ballast/crusher/one/".$file,
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/crusher/list/'.$file] = $data;
        }
    }

    /**
     * Делаем запрос на список дистанций
     * @param null|int $currentID
     */
    protected function _requestShopBallastDistances($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Ballast_Distance', $this->_sitePageData->shopID,
            "_shop/ballast/distance/list/list", "_shop/ballast/distance/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/distance/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список машин балласта
     * @param null|int $currentID
     */
    protected function _requestShopBallastCarsBranches($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::findBranch('DB_Ab1_Shop_Ballast_Car',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/car/list/list", "_shop/ballast/car/one/list",
            $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_id' => ['name'])
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/car/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список машин балласта
     * @param null|int $currentID
     */
    protected function _requestShopBallastCars($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/car/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Ballast_Car',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/car/list/list", "_shop/ballast/car/one/list",
            $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/car/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список машин балласта
     * @param null|int $currentID
     */
    protected function _requestShopBallastDriversBranches($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::findBranch('DB_Ab1_Shop_Ballast_Driver',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/driver/list/list", "_shop/ballast/driver/one/list",
            $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/driver/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список машин балласта
     * @param null|int $currentID
     */
    protected function _requestShopBallastDrivers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/driver/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Ballast_Driver',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/driver/list/list", "_shop/ballast/driver/one/list",
            $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/ballast/driver/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список смен
     * @param null|int $currentID
     */
    protected function _requestShopWorkShiftsBranches($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/shift/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::findBranch('DB_Ab1_Shop_Work_Shift',
            $this->_sitePageData->shopMainID,
            "_shop/work/shift/list/list", "_shop/work/shift/one/list",
            $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_id' => ['name'])
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/work/shift/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список смен
     * @param null|int $currentID
     */
    protected function _requestShopWorkShifts($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/work/shift/list/list',
            )
        );
        $data = View_View::find('DB_Ab1_Shop_Work_Shift',
            $this->_sitePageData->shopID,
            "_shop/work/shift/list/list", "_shop/work/shift/one/list",
            $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/work/shift/list/list'] = $data;
        }
    }


    /**
     * Список продукции
     * @param null $currentID
     * @param int $shopID
     * @param null $shopProductRubricID
     * @param bool $isPublicIgnore
     * @param null $productViewID
     * @param string $file
     * @param bool $isDeleteIgnore
     * @param array $ids
     */
    protected function _requestShopProducts($currentID = NULL, $shopID = 0, $shopProductRubricID = NULL,
                                            $isPublicIgnore = FALSE, $productViewID = null, $file = 'list',
                                            $isDeleteIgnore = false, array $ids = array())
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/'.$file,
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'main_shop_product_rubric_id' => $shopProductRubricID,
                'is_public_ignore' => $isPublicIgnore,
                'is_delete_ignore' => $isDeleteIgnore,
                'product_view_id' => $productViewID,
                'sort_by' => array('name' => 'asc'),
            )
        );

        $shopProductIDs = Request_Request::find(
            'DB_Ab1_Shop_Product', $shopID,
            $this->_sitePageData, $this->_driverDB, $params, 0, true
        );

        // проверяем все ли нужные продукты найдены
        if($currentID > 0){
            $ids[] = $currentID;
        }
        foreach ($ids as $key => $id){
            if($shopProductIDs->findChild($id) !== null){
                unset($ids[$key]);
            }
        }
        if(!empty($ids)){
            $params = Request_RequestParams::setParams(
                array(
                    'id' => $ids,
                    'is_public_ignore' => true,
                    'is_delete_ignore' => true,
                )
            );
            $shopProductIDs->addChilds(
                Request_Request::find(
                    'DB_Ab1_Shop_Product', $shopID,
                    $this->_sitePageData, $this->_driverDB, $params, 0, true
                )
            );
            $shopProductIDs->childsSortBy(
                array('name')
            );
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $model = new Model_Ab1_Shop_Product();
        $data = Helpers_View::getViewObjects(
            $shopProductIDs, $model, "_shop/product/list/".$file, "_shop/product/one/".$file,
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/product/list/'.$file] = $data;
    }

    /**
     * Список продукции всех филиалов
     * @param null $currentID
     * @param int $shopID
     * @param null $shopProductRubricID
     * @param bool $isPublicIgnore
     * @param null $productViewID
     */
    protected function _requestShopProductsBranches($currentID = NULL, $shopID = 0, $shopProductRubricID = NULL,
                                                    $isPublicIgnore = FALSE, $productViewID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'main_shop_product_rubric_id' => $shopProductRubricID,
                'is_public_ignore' => $isPublicIgnore,
                'product_view_id' => $productViewID,
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::findBranch('DB_Ab1_Shop_Product',
            $shopID,
            "_shop/product/list/list", "_shop/product/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params,
            array('shop_id' => array('name'))
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/product/list/list'] = $data;
        }
    }

    /**
     * Список материалов
     * @param null $currentID
     * @param null $formulaTypeID
     * @param null $isWeighted
     * @param null $isMoistureAndDensity
     */
    protected function _requestShopMaterials($currentID = NULL, $formulaTypeID = null, $isWeighted = null, $isMoistureAndDensity = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'is_weighted' => $isWeighted,
                'is_moisture_and_density' => $isMoistureAndDensity,
                'sort_by' => array('name' => 'asc')
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Material',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, true
        );

        if(!empty($formulaTypeID)){
            foreach ($ids->childs as $key => $child){
                if(array_search($formulaTypeID, explode(',', $child->values['access_formula_type_ids'])) === false){
                    unset($ids->childs[$key]);
                }
            }
        }

        $model = new Model_Ab1_Shop_Material();
        $model->setDBDriver($this->_driverDB);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = Helpers_View::getViewObjects(
            $ids, $model,
            "_shop/material/list/list", "_shop/material/one/list",
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/material/list/list'] = $data;
    }

    /**
     * @param null $currentID
     */
    protected function _requestShopMaterialOthers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/other/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Material_Other', $this->_sitePageData->shopMainID,
            "_shop/material/other/list/list", "_shop/material/other/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/material/other/list/list'] = $data;
        }
    }

    /**
     * Список сырья
     * @param null $currentID
     * @param array $params
     * @return mixed|MyArray|string
     */
    protected function _requestShopRaws($currentID = NULL, $params = array())
    {
        return $this->_requestListDB('DB_Ab1_Shop_Raw', $currentID, $this->_sitePageData->shopMainID, $params);
    }

    /**
     * Делаем запрос на список мест погрузки
     * @param null $currentID
     * @param int $shopID
     * @param bool $isIgnoreIsPublic
     */
    protected function _requestShopTurnPlaces($currentID = NULL, $shopID = 0, $isIgnoreIsPublic = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/place/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isIgnoreIsPublic,
                'sort_by' => array('name' => 'asc')
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Turn_Place',
            $shopID, "_shop/turn/place/list/list", "_shop/turn/place/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/turn/place/list/list'] = $data;
        }
    }

    /**
     * @param $shopProductID
     * @param $shopCarID
     * @param null $currentID
     * @return mixed|MyArray|string
     */
    protected function _requestShopTurnPlacesByProduct($shopProductID, $shopCarID, $currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/list',
            )
        );

        $ids = Request_Request::find('DB_Ab1_Shop_Product_Turn', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'shop_product_id' => $shopProductID, 'group' => 1))->getChildArrayInt('shop_turn_type_id');

        if(empty($ids)){
            $this->_sitePageData->replaceDatas['view::_shop/client/list/list'] = '';
            $data = '';
        }else {
            $data = Request_Request::find('DB_Ab1_Shop_Turn_Place', $this->_sitePageData->shopID, $this->_sitePageData,
                $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'shop_turn_type_id' => array('value' =>  $ids),
                    'sort_by' => array('value'=> array('name' => 'asc'))));

            foreach($data->childs as $child){
                $child->additionDatas['is_select'] = FALSE;
                $child->additionDatas['shop_car_id'] = $shopCarID;

                $shopCars = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData,
                    $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                        'shop_turn_place_id' => $child->id,
                        'shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_ASU, Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT)),
                        'is_exit' => 0), 0, TRUE,
                    array('shop_product_id' => array('name')));

                // группируем по имени
                $shopCarsNew = new MyArray();
                foreach ($shopCars->childs as $shopCar){
                    $shopCarsNew->childs[$shopCar->values['shop_product_id']] = $shopCar;
                }

                $child->additionDatas['view::_shop/car/list/turn'] = Helpers_View::getViewObjects($shopCarsNew, new Model_Ab1_Shop_Car(), "_shop/car/list/turn",
                    "_shop/car/one/turn", $this->_sitePageData,  $this->_driverDB);
                $child->additionDatas['turn'] =  count($shopCars->childs);

                $shopCars = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData,
                    $this->_driverDB, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                        'created_at_from' => date('Y-m-d 06:00:00'),
                        'shop_turn_place_id' => $child->id, 'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_EXIT,
                        'is_exit' => 1, 'sum_quantity' => TRUE, 'group_by' => array('value' => array('shop_turn_place_id'))), 0);
                if (count($shopCars->childs) > 0) {
                    $child->additionDatas['ton'] = intval($shopCars->childs[0]->values['quantity']);
                }else{
                    $child->additionDatas['ton'] = 0;
                }

                $params = Request_RequestParams::setParams(
                    array(
                        'created_at_from' => date('Y-m-d 06:00:00'),
                        'shop_turn_place_id' => $child->id,
                        'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU,
                        'is_exit' => 0,
                        'sum_quantity' => TRUE,
                        'group_by' => array('shop_turn_place_id')
                    )
                );
                $shopCars = Request_Request::find('DB_Ab1_Shop_Car',
                    $this->_sitePageData->shopID, $this->_sitePageData,
                    $this->_driverDB, $params, 0
                );
                if (count($shopCars->childs) > 0) {
                    $child->additionDatas['ton_asu'] = intval($shopCars->childs[0]->values['quantity']);
                }else{
                    $child->additionDatas['ton_asu'] = 0;
                }
            }

            $this->_sitePageData->newShopShablonPath('ab1/_all');
            $data = Helpers_View::getViewObjects($data, new Model_Ab1_Shop_Turn_Place(), "_shop/turn/place/list/list-car", "_shop/turn/place/one/list-car",
                $this->_sitePageData,  $this->_driverDB);
            $this->_sitePageData->previousShopShablonPath();
        }

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/client/list/list'] = $data;
        }

        return $data;
    }

    /**
     * @param null $currentID
     */
    protected function _requestShopCompetitors($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/list/list',
            )
        );

        $data = View_View::find('DB_Ab1_Shop_Competitor', $this->_sitePageData->shopMainID,
            "_shop/competitor/list/list", "_shop/competitor/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/competitor/list/list'] = $data;
        }
    }


    /**
     * @param null $currentID
     */
    protected function _requestShopSuppliers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/list/list',
            )
        );

        $data = View_View::find('DB_Ab1_Shop_Supplier', $this->_sitePageData->shopMainID,
            "_shop/supplier/list/list", "_shop/supplier/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/supplier/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список оправителей
     * @param null $currentID
     */
    protected function _requestShopDaughters($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/daughter/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Daughter', $this->_sitePageData->shopMainID,
            "_shop/daughter/list/list", "_shop/daughter/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/daughter/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список клиентов
     * @param null $currentID
     */
    protected function _requestShopClientMaterial($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/material/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Client_Material', $this->_sitePageData->shopMainID,
            "_shop/client/material/list/list", "_shop/client/material/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'is_public_ignore' => TRUE,
                'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/client/material/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список операторов
     * @param $shopTableRubricID
     * @param null $currentID
     * @param string $file
     * @return mixed|MyArray|string
     */
    protected function _requestShopOperations($shopTableRubricID, $currentID = NULL, $file = 'list')
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/'.$file,
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
            "_shop/operation/list/".$file, "_shop/operation/one/".$file, $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => $shopTableRubricID, 'sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Делаем запрос на список тар машин
     * @param null $currentID
     * @param int $tareType
     */
    protected function _requestShopCarTares($currentID = NULL, $tareType = Model_Ab1_TareType::TARE_TYPE_OUR)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/car/tare/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Car_Tare',
            $this->_sitePageData->shopMainID,
            "_shop/car/tare/list/list", "_shop/car/tare/one/list",
            $this->_sitePageData, $this->_driverDB,
            array(
                'tare_type_id' => $tareType,
                'sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/car/tare/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список
     * @param null $currentID
     */
    protected function _requestShopTransportCompanies($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transport/company/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Transport_Company', $this->_sitePageData->shopMainID,
            "_shop/transport/company/list/list", "_shop/transport/company/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/transport/company/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список рубрик
     * @param null $currentID
     * @param int $rootID
     * @param array $params
     */
    protected function _requestShopProductRubrics($currentID = NULL, $rootID = 0, array $params = array())
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array_merge(
                array(
                    'root_id' => $rootID,
                    'sort_by' => array('name' => 'asc')
                ),
                $params
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Product_Rubric',
            $this->_sitePageData->shopMainID,
            "_shop/product/rubric/list/list", "_shop/product/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/product/rubric/list/list'] = $data;
    }

    /**
     * Делаем запрос на список групп
     * @param null $currentID
     */
    protected function _requestShopProductGroups($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/group/list/list',
            )
        );
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Product_Group',
            $this->_sitePageData->shopMainID,
            "_shop/product/group/list/list", "_shop/product/group/one/list",
            $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/product/group/list/list'] = $data;
    }

    /**
     * Делаем запрос на список групп доставки
     * @param null $currentID
     */
    protected function _requestShopDeliveryGroups($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/group/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Delivery_Group',
            $this->_sitePageData->shopMainID,
            "_shop/delivery/group/list/list", "_shop/delivery/group/one/list",
            $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/delivery/group/list/list'] = $data;
    }

    /**
     * Делаем запрос на список рубрик материалов
     * @param null $currentID
     */
    protected function _requestShopMaterialRubrics($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'root_id' => 0,
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Material_Rubric',
            $this->_sitePageData->shopMainID,
            "_shop/material/rubric/list/list", "_shop/material/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/material/rubric/list/list'] = $data;
    }

    /**
     * Доверенности
     * @param $shopClientID
     * @param null $currentID
     * @param string $file
     * @param null $date
     * @return mixed|string
     */
    protected function _requestShopClientAttorney($shopClientID, $currentID = NULL, $file = 'list', $date = null)
    {
        if(empty($date)){
            $date = date('Y-m-d');
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/list/'.$file,
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'validity' => $date,
                'sort_by' => array('from_at' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Client_Attorney',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params
        );

        $model = new Model_Ab1_Shop_Client_Attorney();
        $model->setDBDriver($this->_driverDB);
        if(($currentID > 0) && ($ids->findChild($currentID) === NULL)){
            if(Helpers_DB::getDBObject($model, $currentID, $this->_sitePageData, 0)){
                $ids->addChild($currentID)->setValues($model, $this->_sitePageData, array());
            }
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = Helpers_View::getViewObjects(
            $ids, $model,
            "_shop/client/attorney/list/".$file, "_shop/client/attorney/one/".$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID,
            TRUE, array()
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/client/attorney/list/'.$file] = $data;

        return $data;
    }

    /**
     * Договоры
     * @param $shopClientID
     * @param null $currentID
     * @param string $file
     * @param null $clientContractTypeID
     * @param null $clientContractStatusID
     * @return mixed|string
     */
    protected function _requestShopClientContract($shopClientID, $currentID = NULL, $file = 'list',
                                                  $clientContractTypeID = null, $clientContractStatusID = null)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/list/'.$file,
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'client_contract_type_id' => $clientContractTypeID,
                'client_contract_status_id' => $clientContractStatusID,
                'sort_by' => array('from_at' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Client_Contract',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params
        );

        $model = new Model_Ab1_Shop_Client_Contract();
        $model->setDBDriver($this->_driverDB);
        if(($currentID > 0) && ($ids->findChild($currentID) === NULL)){
            if(Helpers_DB::getDBObject($model, $currentID, $this->_sitePageData)){
                $ids->addChild($currentID)->setValues($model, $this->_sitePageData, array());
            }
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = Helpers_View::getViewObjects(
            $ids, $model,
            "_shop/client/contract/list/".$file, "_shop/client/contract/one/".$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID,
            TRUE, array()
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/list/'.$file] = $data;

        return $data;
    }

    /**
     * Цеха доставки
     * @param null $currentID
     * @param string $file
     * @return mixed|string
     */
    protected function _requestShopDeliveryDepartments($currentID = NULL, $file = 'list')
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/department/list/'.$file,
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Delivery_Department',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params
        );

        $model = new Model_Ab1_Shop_Delivery_Department();
        $model->setDBDriver($this->_driverDB);
        $data = Helpers_View::getViewObjects(
            $ids, $model,
            "_shop/delivery/department/list/".$file, "_shop/delivery/department/one/".$file,
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID,
            TRUE, array()
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/delivery/department/list/'.$file] = $data;

        return $data;
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopDeliveries($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Delivery',
            $this->_sitePageData->shopMainID,
            "_shop/delivery/list/list", "_shop/delivery/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc')))
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/delivery/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список
     * @param null $currentID
     */
    protected function _requestRejectionReasons($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::rejection-reason/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_RejectionReason', $this->_sitePageData->shopID,
            "rejection-reason/list/list", "rejection-reason/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::rejection-reason/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список
     * @param null $currentID
     */
    protected function _requestShopMoveClients($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/client/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Move_Client', $this->_sitePageData->shopMainID,
            "_shop/move/client/list/list", "_shop/move/client/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/move/client/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список мест вывоза прочего материала
     * @param null $currentID
     */
    protected function _requestShopMovePlaces($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/place/list/list',
            )
        );

        $data = View_View::find('DB_Ab1_Shop_Move_Place', $this->_sitePageData->shopMainID,
            "_shop/move/place/list/list", "_shop/move/place/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/move/place/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список
     * @param null $currentID
     */
    protected function _requestShopTurnTypes($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/type/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Turn_Type', $this->_sitePageData->shopID,
            "_shop/turn/type/list/list", "_shop/turn/type/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/turn/type/list/list'] = $data;
        }
    }

    /**
     * Список заводов
     * @param null $currentID
     */
    protected function _requestShopBoxcarFactories($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/factory/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Boxcar_Factory', $this->_sitePageData->shopMainID,
            "_shop/boxcar/factory/list/list", "_shop/boxcar/factory/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/boxcar/factory/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список мест хранения материала
     * @param null $currentID
     * @param int $shopID
     * @param string $subString
     * @param null $shopSubdivisionID
     */
    protected function _requestShopHeaps($currentID = NULL, $shopID = 0, $subString = '/receiver', $shopSubdivisionID = null){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/heap'.$subString.'/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_subdivision_id' => $shopSubdivisionID,
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Heap',
            $shopID,
            "_shop/heap/list/list", "_shop/heap/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/heap'.$subString.'/list/list'] = $data;
    }

    /**
     * Делаем запрос на список подразделения материала
     * @param null $currentID
     * @param int $shopID
     * @param string $subString
     * @return mixed|MyArray|string
     */
    protected function _requestShopSubdivisions($currentID = NULL, $shopID = 0, $subString = '/receiver'){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/subdivision'.$subString.'/list/list',
            )
        );

        if($shopID == 0){
            $shopID = $this->_sitePageData->shopID;
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_Shop_Subdivision', $shopID,
            "_shop/subdivision/list/list", "_shop/subdivision/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }
        $this->_sitePageData->replaceDatas['view::_shop/subdivision'.$subString.'/list/list'] = $data;
        return $data;
    }

    /**
     * Делаем запрос на список спецтранспорта
     * @param null $currentID
     * @param int $shopID
     * @param bool $isIgnoreIsPublic
     */
    protected function _requestShopSpecialTransports($currentID = NULL, $shopID = 0, $isIgnoreIsPublic = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/special/transport/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isIgnoreIsPublic,
                'sort_by' => array('name' => 'asc')
            )
        );
        $data = View_View::find('DB_Ab1_Shop_Special_Transport',
            $shopID, "_shop/special/transport/list/list", "_shop/special/transport/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/special/transport/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список типов доставки
     * @param null $currentID
     */
    protected function _requestDeliveryTypes($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::deliverytype/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = View_View::find('DB_Ab1_DeliveryType', $this->_sitePageData->shopMainID,
            "deliverytype/list/list", "deliverytype/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::deliverytype/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список записей DB_ объекта
     * @param $dbObject
     * @param null $currentID
     * @param array $params
     * @param null $elements
     * @param string $file
     * @param string $field
     * @return string
     */
    protected function _requestShopListDB($dbObject, $currentID = NULL, array $params = array(), $elements = null,
                                      $file = 'list', $field = 'name')
    {
        return self::_requestListDB(
            $dbObject, $currentID, $this->_sitePageData->shopID, $params, $elements, $file, $field
        );
    }

    /**
     * Делаем запрос на список записей DB_ объекта
     * @param $dbObject
     * @param null $currentID
     * @param int $shopID
     * @param array $params
     * @param null $elements
     * @param string $file
     * @param string $field
     * @return string
     */
    protected function _requestListDB($dbObject, $currentID = NULL, $shopID = 0, array $params = array(), $elements = null,
                                      $file = 'list', $field = 'name')
    {
        if($shopID < 0 && key_exists('shop_id', $dbObject::FIELDS)){
            $shopID = $this->_sitePageData->shopID;
        }

        $view = DB_Basic::getViewPath($dbObject);
        if(file_exists(VIEWPATH . 'ab1/_all/' . $this->_sitePageData->dataLanguageID . '/' . $view . 'list/list.php')){
            $viewPath = $view;
        }else{
            $viewPath = '_db/';
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::' . $view . 'list/'.$file,
            )
        );

        $params = array_merge(
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array(
                        $field => 'asc'
                    )
                )
            ),
            $params
        );

        $ids = Request_Request::find(
            $dbObject, $shopID, $this->_sitePageData, $this->_driverDB, $params, 1000, true, $elements
        );
        $ids->addAdditionDataChilds(['field' => $field]);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $data = Helpers_View::getViews(
            $viewPath . 'list/list', $viewPath . 'one/list',
            $this->_sitePageData, $this->_driverDB, $ids, false
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            if (is_array($currentID)){
                foreach ($currentID as $s){
                    $s = 'data-id="' . $s . '"';
                    $data = str_replace($s, $s . ' selected', $data);
                }
            }else {
                $s = 'data-id="' . $currentID . '"';
                $data = str_replace($s, $s . ' selected', $data);
            }
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::' . $view . 'list/' . $file, $data);

        return $data;
    }

    /**
     * Получаем список записей для select
     */
    public function action_list() {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/list';
        $this->response->body($this->_requestListDB($this->dbObject));
    }

    /**
     * Делаем запрос на список типов доставки
     * @param null $currentID
     */
    protected function _requestShopBranchType($currentID = NULL){
        $data = '<option data-id="'.Model_Ab1_Shop::SHOP_TABLE_RUBRIC_BRANCH.'" value="'.Model_Ab1_Shop::SHOP_TABLE_RUBRIC_BRANCH.'">Завод</option>'
            . '<option data-id="'.Model_Ab1_Shop::SHOP_TABLE_RUBRIC_MAGAZINE.'" value="'.Model_Ab1_Shop::SHOP_TABLE_RUBRIC_MAGAZINE.'">Магазин</option>';

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
        }

        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/branch/type/list/list', $data);
    }
}