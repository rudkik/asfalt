<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_BasicList extends Controller_Tax_Client_BasicShop
{

    /**
     * Делаем запрос на список банковских счетов
     * @param null|int $currentID
     */
    protected function _requestShopBankAccounts($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bank/account/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Bank_Account', $this->_sitePageData->shopID,
            "_shop/bank/account/list/list", "_shop/bank/account/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/bank/account/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestPaidTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::paidtype/list/list',
            )
        );
        $data = View_View::findAll('DB_Tax_PaidType', $this->_sitePageData->shopID,
            "paidtype/list/list", "paidtype/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::paidtype/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param $shopContractorID
     * @param null $currentID
     */
    protected function _requestShopAttorneys($shopContractorID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/attorney/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Attorney', $this->_sitePageData->shopID,
            "_shop/attorney/list/list", "_shop/attorney/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), 'shop_contractor_id' => $shopContractorID,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/attorney/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestTaxViews($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::tax-view/list/list',
            )
        );
        $data = View_View::find('DB_Tax_View', $this->_sitePageData->shopID,
            "tax-view/list/list", "tax-view/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('id' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::tax-view/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopWorkers($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/worker/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Worker', $this->_sitePageData->shopID,
            "_shop/worker/list/list", "_shop/worker/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/worker/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestWorkerStatuses($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::workerstatus/list/list',
            )
        );
        $data = View_View::findAll('DB_Tax_WorkerStatus', $this->_sitePageData->shopID,
            "workerstatus/list/list", "workerstatus/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::workerstatus/list/list'] = $data;
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
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopContractors($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/contractor/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Contractor', $this->_sitePageData->shopID,
            "_shop/contractor/list/list", "_shop/contractor/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/contractor/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param $shopContractorID
     * @param null $currentID
     */
    protected function _requestShopContracts($shopContractorID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/contract/list/list',
            )
        );
        $data = View_View::find('DB_Tax_Shop_Contract', $this->_sitePageData->shopID,
            "_shop/contract/list/list", "_shop/contract/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), 'shop_contractor_id' => $shopContractorID,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/contract/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestKNPs($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::knp/list/list',
            )
        );
        $data = View_View::findAll('DB_Tax_KNP', $this->_sitePageData->shopID,
            "knp/list/list", "knp/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('code' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::knp/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestKBKs($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::kbk/list/list',
            )
        );
        $data = View_View::findAll('DB_Tax_KBK', $this->_sitePageData->shopID,
            "kbk/list/list", "kbk/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('code' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::kbk/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestKBes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::kbe/list/list',
            )
        );
        $data = View_View::findAll('DB_Tax_KBe', $this->_sitePageData->shopID,
            "kbe/list/list", "kbe/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('code' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::kbe/list/list'] = $data;
        }
    }
}