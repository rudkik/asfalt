<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_BasicList extends Controller_Nur_BasicShop
{

    /**
     * Делаем запрос на код налогового органа
     * @param null|int $currentID
     */
    protected function _requestAuthorities($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::authority/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Authority', $this->_sitePageData->shopID,
            "authority/list/list", "authority/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('code' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::authority/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на БИН акимов
     * @param null|int $currentID
     */
    protected function _requestAkimats($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::akimat/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Akimat', $this->_sitePageData->shopID,
            "akimat/list/list", "akimat/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::akimat/list/list'] = $data;
        }
    }

    /**
     * Список видов компаний
     * @param null $currentID
     * @param bool $isPublicIgnore
     */
    protected function _requestShopCompanyViews($currentID = NULL, $isPublicIgnore = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/company/view/list/list',
            )
        );

        $shopID = $this->_sitePageData->shopMainID;

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isPublicIgnore,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Nur_Shop_Company_View',
            $shopID,
            "_shop/company/view/list/list", "_shop/company/view/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

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

            $this->_sitePageData->replaceDatas['view::_shop/company/view/list/list'] = $data;
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
        $data = View_View::find('DB_Bank', $this->_sitePageData->shopID,
            "bank/list/list", "bank/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::bank/list/list'] = $data;
        }
    }

    /**
     * Список групп задач
     * @param null $currentID
     * @param bool $isPublicIgnore
     */
    protected function _requestShopTaskGroups($currentID = NULL, $isPublicIgnore = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/group/list/list',
            )
        );

        $shopID = $this->_sitePageData->shopMainID;

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isPublicIgnore,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Nur_Shop_Task_Group',
            $shopID,
            "_shop/task/group/list/list", "_shop/task/group/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

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

            $this->_sitePageData->replaceDatas['view::_shop/task/group/list/list'] = $data;
        }
    }

    /**
     * Список местных налогов
     * @param null $currentID
     * @param bool $isPublicIgnore
     */
    protected function _requestShopTaxViews($currentID = NULL, $isPublicIgnore = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/tax/view/list/list',
            )
        );

        $shopID = $this->_sitePageData->shopMainID;

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isPublicIgnore,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Nur_Shop_Tax_View',
            $shopID,
            "_shop/tax/view/list/list", "_shop/tax/view/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

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

            $this->_sitePageData->replaceDatas['view::_shop/tax/view/list/list'] = $data;
        }
    }

    /**
     * Список задач
     * @param null $currentID
     * @param int $shopID
     * @param bool $isPublicIgnore
     */
    protected function _requestShopTasks($currentID = NULL, $shopID = 0, $isPublicIgnore = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopMainID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'is_public_ignore' => $isPublicIgnore,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Nur_Shop_Task',
            $shopID,
            "_shop/task/list/list", "_shop/task/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

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

            $this->_sitePageData->replaceDatas['view::_shop/task/list/list'] = $data;
        }
    }

    /**
     * Список рубрик
     * @param $tableID
     * @param null $currentID
     */
    protected function _requestShopTableRubric($tableID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/_table/rubric/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'table_id' => $tableID,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Shop_Table_Rubric',
            $this->_sitePageData->shopMainID,
            "_shop/_table/rubric/list/list", "_shop/_table/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/_table/rubric/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestOrganizationTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::organizationtype/list/list',
            )
        );
        $data = View_View::find('DB_OrganizationType', $this->_sitePageData->shopID,
            "organizationtype/list/list", "organizationtype/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::organizationtype/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestOrganizationTaxTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::organizationtaxtype/list/list',
            )
        );
        $data = View_View::find('DB_Tax_OrganizationTaxType', $this->_sitePageData->shopID,
            "organizationtaxtype/list/list", "organizationtaxtype/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::organizationtaxtype/list/list'] = $data;
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
     * Список филиалов
     * @param null $currentID
     * @param bool $isMain
     * @param bool $isDeleteCurrent
     */
    protected function _requestShopBranches($currentID = NULL, $isMain = FALSE, $isDeleteCurrent = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/list',
            )
        );

        $params = Request_RequestParams::setParams(
            array()
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

        if($isDeleteCurrent){
            foreach ($ids->childs as $key => $child){
                if ($child->id == $this->_sitePageData->shopID){
                    unset($ids->childs[$key]);
                    break;
                }
            }
        }

        $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] =
        $data = Helpers_View::getViewObjects($ids, new Model_Shop(), "_shop/branch/list/list",
            "_shop/branch/one/list", $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/branch/list/list'] = $data;
        }
    }

    /**
     * Список продукции
     * @param null $currentID
     * @param int $shopID
     * @param null $shopProductRubricID
     * @param bool $isPublicIgnore
     */
    protected function _requestShopProductions($currentID = NULL, $shopID = 0, $shopProductionRubricID = NULL, $isPublicIgnore = FALSE)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/list/list',
            )
        );

        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $params = Request_RequestParams::setParams(
            array(
                'main_shop_production_rubric_id' => $shopProductionRubricID,
                'is_public_ignore' => $isPublicIgnore,
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Nur_Shop_Product',
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
     * Делаем запрос на список рубрик
     * @param null $currentID
     * @param int $rootID
     */
    protected function _requestShopProductionRubrics($currentID = NULL, $rootID = 0)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/production/rubric/list/list',
            )
        );
        $data = View_View::find('DB_Nur_Shop_Production_Rubric', $this->_sitePageData->shopMainID,
            "_shop/production/rubric/list/list", "_shop/production/rubric/one/list", $this->_sitePageData, $this->_driverDB,
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
        $data = View_View::find('DB_Nur_Shop_Product_Rubric', $this->_sitePageData->shopMainID,
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
        $data = View_View::find('DB_Nur_Shop_Product_Group',
            $this->_sitePageData->shopMainID,
            "_shop/product/group/list/list", "_shop/product/group/one/list",
            $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)
        );

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
        $data = View_View::find('DB_Nur_Shop_Supplier',
            $this->_sitePageData->shopMainID,
            "_shop/supplier/list/list", "_shop/supplier/one/list", $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/supplier/list/list'] = $data;
        }
    }

}