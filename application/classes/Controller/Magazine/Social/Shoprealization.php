<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_ShopRealization extends Controller_Magazine_Social_BasicMagazine{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/social/shoprealization/statistics';

        if(Request_RequestParams::getParamInt('is_special') == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF){
            $this->_actionShopRealizationWriteOffStatistics();
        }else {
            $this->_actionShopRealizationStatistics();
        }
    }

    public function action_index() {
        $this->_sitePageData->url = '/social/shoprealization/index';

        $this->_requestShopBranches(NULL, Model_Magazine_Shop::SHOP_TABLE_RUBRIC_MAGAZINE);

        $isSpecial = Request_RequestParams::getParamInt('is_special');
        if($isSpecial == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/list/special/index',
                )
            );

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'is_special' => FALSE,
                ),
                FALSE
            );
            View_View::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID,
                "_shop/realization/list/special/index", "_shop/realization/one/special/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_worker_id' => array('name'))
            );

            $this->_putInMain('/main/_shop/realization/special/index');
        }elseif($isSpecial == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/list/write-off/index',
                )
            );

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'is_special' => FALSE,
                ),
                FALSE
            );
            View_View::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID,
                "_shop/realization/list/write-off/index", "_shop/realization/one/write-off/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_write_off_type_id' => array('name'))
            );

            $this->_putInMain('/main/_shop/realization/write-off/index');
        }else{
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/list/index',
                )
            );

            $this->_requestShopCard();

            // получаем список
            $params = Request_RequestParams::setParams(
                array(
                    'limit_page' => 25,
                    'is_special' => FALSE,
                ),
                FALSE
            );
            View_View::find('DB_Magazine_Shop_Realization',
                $this->_sitePageData->shopID,
                "_shop/realization/list/index", "_shop/realization/one/index",
                $this->_sitePageData, $this->_driverDB, $params,
                array('shop_worker_id' => array('name'))
            );

            $this->_putInMain('/main/_shop/realization/index');
        }
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/social/shoprealization/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Realization();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Realization not is found!');
        }
        $model->getElement('shop_card_id', TRUE, $this->_sitePageData->shopMainID);

        if($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/special/edit',
                    '_shop/realization/item/list/special/index',
                )
            );

            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            View_View::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID,
                '_shop/realization/item/list/special/index', '_shop/realization/item/one/special/index',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_production_id' => array('name', 'barcode'),
                    'unit_id' => array('name')
                )
            );

            $dataID = new MyArray();
            $model->getElement('shop_worker_id', TRUE);
            $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/special/edit'] = Helpers_View::getViewObject(
                $dataID, $model, '_shop/realization/one/special/edit', $this->_sitePageData, $this->_driverDB
            );
            $this->_putInMain('/main/_shop/realization/special/edit');
        }elseif($model->getIsSpecial() == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF) {
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/write-off/edit',
                    '_shop/realization/item/list/write-off/index',
                )
            );

            $this->_requestShopWriteOffType($model->getShopWriteOffTypeID());

            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            View_View::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID,
                '_shop/realization/item/list/write-off/index', '_shop/realization/item/one/write-off/index',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_production_id' => array('name', 'barcode'),
                    'unit_id' => array('name')
                )
            );

            $dataID = new MyArray();
            $model->getElement('shop_worker_id', TRUE);
            $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/write-off/edit'] = Helpers_View::getViewObject(
                $dataID, $model, '_shop/realization/one/write-off/edit', $this->_sitePageData, $this->_driverDB
            );
            $this->_putInMain('/main/_shop/realization/write-off/edit');
        }else{
            // задаем данные, которые будут меняться
            $this->_setGlobalDatas(
                array(
                    'view::_shop/realization/one/edit',
                    '_shop/realization/item/list/index',
                )
            );

            $params = Request_RequestParams::setParams(
                array(
                    'shop_realization_id' => $id,
                    'sort_by' => array('shop_production_id.name' => 'asc'),
                )
            );
            View_View::find('DB_Magazine_Shop_Realization_Item',
                $this->_sitePageData->shopID,
                '_shop/realization/item/list/index', '_shop/realization/item/one/index',
                $this->_sitePageData, $this->_driverDB, $params,
                array(
                    'shop_production_id' => array('name', 'barcode'),
                    'unit_id' => array('name')
                )
            );

            $dataID = new MyArray();
            $model->getElement('shop_worker_id', TRUE);
            $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
            $dataID->setIsFind(TRUE);
            $this->_sitePageData->replaceDatas['view::_shop/realization/one/edit'] = Helpers_View::getViewObject(
                $dataID, $model, '_shop/realization/one/edit', $this->_sitePageData, $this->_driverDB
            );
            $this->_putInMain('/main/_shop/realization/edit');

        }
    }
}
