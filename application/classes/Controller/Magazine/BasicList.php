<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_BasicList extends Controller_Magazine_File
{

    /**
     * Виды счет-фактур
     * @param null $currentID
     */
    protected function _requestESFTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::esf-type/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Magazine_ESFType',
            $this->_sitePageData->shopMainID,
            "esf-type/list/list", "esf-type/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::esf-type/list/list'] = $data;
        }
    }

    /**
     * Места списания
     * @param null $currentID
     */
    protected function _requestShopWriteOffType($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/write-off/type/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $data = View_View::find('DB_Magazine_Shop_WriteOff_Type',
            $this->_sitePageData->shopMainID,
            "_shop/write-off/type/list/list", "_shop/write-off/type/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/write-off/type/list/list'] = $data;
        }
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

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $data = View_View::findBranch('DB_Ab1_Shop_Worker',
            $this->_sitePageData->shopMainID,
            "_shop/worker/list/list", "_shop/worker/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/worker/list/list'] = $data;
        }
    }

    /**
     * Список филиалов
     * @param null $currentID
     * @param int $shopTableRubricID
     * @return mixed|string
     */
    protected function _requestShopBranches($currentID = NULL,
                                            $shopTableRubricID = Model_Magazine_Shop::SHOP_TABLE_RUBRIC_BRANCH)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'shop_table_rubric_id' => $shopTableRubricID,
                'sort_by' => array(
                    'name' => 'asc',
                )
            )
        );
        $ids = Request_Request::findNotShop('DB_Shop',
            $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
        );

        $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] =
        $data = Helpers_View::getViewObjects($ids, new Model_Shop(), "_shop/branch/list/list",
            "_shop/branch/one/list", $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] = $data;
        }

        return $data;
    }

    /**
     * Список продукции
     * @param null $currentID
     * @param int $shopID
     * @param null $shopProductionRubricID
     * @param bool $isPublicIgnore
     * @param int $excludeID
     */
    protected function _requestShopProductions($currentID = NULL, $shopID = 0, $shopProductionRubricID = NULL,
                                               $isPublicIgnore = FALSE, $excludeID = -1)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopMainID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'main_shop_production_rubric_id' => $shopProductionRubricID,
                'is_public_ignore' => $isPublicIgnore,
                'id_not' => $excludeID,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Magazine_Shop_Production',
            $shopID,
            "_shop/production/list/list", "_shop/production/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/production/list/list'] = $data;
        }
    }
    /**
     * Список продуктов
     * @param null $currentID
     * @param int $shopID
     * @param null $shopProductRubricID
     * @param bool $isPublicIgnore
     */
    protected function _requestShopProducts($currentID = NULL, $shopID = 0, $shopProductRubricID = NULL, $isPublicIgnore = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopMainID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'main_shop_product_rubric_id' => $shopProductRubricID,
                'is_public_ignore' => $isPublicIgnore,
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $data = View_View::find('DB_Magazine_Shop_Product',
            $shopID,
            "_shop/product/list/list", "_shop/product/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/product/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список операторов
     * @param $shopTableRubricID
     * @param null $currentID
     */
    protected function _requestShopOperations($shopTableRubricID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/list',
            )
        );
        $data = View_View::find('DB_Shop_Operation', $this->_sitePageData->shopID,
            "_shop/operation/list/list", "_shop/operation/one/list", $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => $shopTableRubricID, 'sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/operation/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список рубрик
     * @param null $currentID
     * @param int $rootID
     */
    protected function _requestShopProductionRubrics($currentID = NULL, $rootID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/rubric/list/list',
            )
        );

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $data = View_View::find('DB_Magazine_Shop_Production_Rubric', $this->_sitePageData->shopMainID,
            "_shop/production/rubric/list/list", "_shop/production/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('root_id' => $rootID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
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
        $this->_sitePageData->replaceDatas['view::_shop/production/rubric/list/list'] = $data;
    }

    /**
     * Делаем запрос на список рубрик
     * @param null $currentID
     * @param int $rootID
     */
    protected function _requestShopProductRubrics($currentID = NULL, $rootID = 0)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/list/list',
            )
        );
        $data = View_View::find('DB_Magazine_Shop_Product_Rubric', $this->_sitePageData->shopMainID,
            "_shop/product/rubric/list/list", "_shop/product/rubric/one/list", $this->_sitePageData, $this->_driverDB,
            array('root_id' => $rootID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

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
     * Поставщики
     * @param null $currentID
     */
    protected function _requestShopSupplier($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('magazine/_all');
        $data = View_View::find('DB_Magazine_Shop_Supplier',
            $this->_sitePageData->shopMainID,
            "_shop/supplier/list/list", "_shop/supplier/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );
        $this->_sitePageData->previousShopShablonPath();

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/supplier/list/list'] = $data;
        }
    }

    /**
     * Единицы измерения
     * @param null $currentID
     */
    protected function _requestUnits($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::unit/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Magazine_Unit',
            $this->_sitePageData->shopMainID,
            "unit/list/list", "unit/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::unit/list/list'] = $data;
        }
    }

    /**
     * Карты сотрудников
     * @param null $currentID
     */
    protected function _requestShopCard($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/card/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Magazine_Shop_Card',
            $this->_sitePageData->shopMainID,
            "_shop/card/list/list", "_shop/card/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/card/list/list'] = $data;
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

        $data = View_View::find('DB_OrganizationType', $this->_sitePageData->shopID,
            "organizationtype/list/list", "organizationtype/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'land_id' => '3161',
                'sort_by' => array('value' => array('name' => 'asc'))));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::organizationtype/list/list'] = $data;
        }
    }
}