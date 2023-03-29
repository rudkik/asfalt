<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_BasicList extends Controller_Calendar_BasicShop
{
    /**
     * Продукты
     * @param null $currentID
     */
    protected function _requestShopProducts($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Calendar_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/list", "_shop/product/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/product/list/list'] = $data;
        }
    }

    /**
     * Продукты
     * @param null $currentID
     */
    protected function _requestShopResults($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/result/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Calendar_Shop_Result',
            $this->_sitePageData->shopID,
            "_shop/result/list/list", "_shop/result/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/result/list/list'] = $data;
        }
    }

    /**
     * Продукты
     * @param null $currentID
     */
    protected function _requestShopPartners($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/partner/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Calendar_Shop_Partner',
            $this->_sitePageData->shopID,
            "_shop/partner/list/list", "_shop/partner/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/partner/list/list'] = $data;
        }
    }

    /**
     * Продукты
     * @param null $currentID
     */
    protected function _requestShopRubrics($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/rubric/list/list',
            )
        );
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('name' => 'asc'),
            )
        );
        $data = View_View::find('DB_Calendar_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/list", "_shop/rubric/one/list",
            $this->_sitePageData, $this->_driverDB,
            $params
        );

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/rubric/list/list'] = $data;
        }
    }
}