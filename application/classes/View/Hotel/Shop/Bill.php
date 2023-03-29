
<?php defined('SYSPATH') or die('No direct script access.');

class View_Hotel_Shop_Bill extends View_View {
    /**
     * Поиск заказа по id или id оплаты
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public static function getShopBillByIDOrPaymentID($dbObject, $shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       array $params = array(), $elements = NULL, $isLoadView = TRUE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(Model_Hotel_Shop_Bill::TABLE_NAME, $elements);
            $key = Helpers_DB::getURLParamDatas(Request_Request::getParamsOne(), $params);

            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Hotel_Shop_Bill::getShopBillByIDOrPaymentID', $tables, $viewObject, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObject] = $result;
                return $result;
            }
        }

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        $id = Request_RequestParams::getParamInt('id', $params, $isNotReadRequest);

        $objectID = new MyArray();
        $objectID->id = $id;
        if (!Helpers_View::getDBData($objectID, $model, $sitePageData, $shopID, $elements)) {
            $modelPayment = new Model_Hotel_Shop_Payment();
            $modelPayment->setDBDriver($driver);

            if (!Helpers_DB::getDBObject($modelPayment, $id, $sitePageData, $shopID)) {
                $isNotFind = TRUE;
            }else{
                $objectID->id = $modelPayment->getShopBillID();
                $isNotFind = !Helpers_View::getDBData($objectID, $model, $sitePageData, $shopID, $elements);

                $_GET['id'] = $objectID->id;
                $_POST['id'] = $objectID->id;
            }

            if($isNotFind) {
                if (Request_RequestParams::getParamBoolean('is_error_404', $params) === TRUE) {
                    throw new HTTP_Exception_404('Bill not found!');
                } else {
                    $objectID->values = array();
                    $objectID->isFindDB = TRUE;
                }
                $objectID->id = 0;
            }
        }

        if (!$isLoadView) {
            return $objectID;
        }

        $result = Helpers_View::getViewObject($objectID, $model, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements);
        $sitePageData->replaceDatas['view::'.$viewObject] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Hotel_Shop_Bill::getShopBillByIDOrPaymentID', $tables, $viewObject, $sitePageData, $driver, $key);
        }

        return $result;
    }
}