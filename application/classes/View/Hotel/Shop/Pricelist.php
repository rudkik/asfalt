
<?php defined('SYSPATH') or die('No direct script access.');

class View_Hotel_Shop_Pricelist extends View_View {
    /**
     * Поиск свободных типов комнат для заданного срока
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadView
     * @return string
     * @throws Exception
     */
    public static function findFreeShopPricelists($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                 array $params = array(), $elements = NULL, $isLoadView = TRUE, $isLoadOneView = FALSE){
        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            $tables = self::getTables(Model_Hotel_Shop_Pricelist::TABLE_NAME, $elements);
            $key = Helpers_DB::getURLParamDatas(array(), $params);
            $result = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Hotel_Shop_Pricelist::findFreeShopPricelists', $tables, $viewObjects, $sitePageData, $driver, $key);
            if ($result !== NULL) {
                $sitePageData->replaceDatas['view::' . $viewObjects] = $result;
                return $result;
            }
        }

        $dateFrom = Request_RequestParams::getParamDateTime('date_from', $params);
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d');
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to', $params);
        if($dateTo === NULL){
            $dateTo = $dateFrom;
        }else{
            $dateTo = date('Y-m-d', strtotime($dateTo) - 60 * 60 * 24);
        }
        if ($dateTo < $dateFrom){
            $dateTo = $dateFrom;
        }

        $ids = Api_Hotel_Shop_Pricelist::getFreePricelists($dateFrom, $dateTo, $sitePageData, $driver, FALSE, $params);

        // нужно ли считать стоимость
        if (Request_RequestParams::getParamBoolean('is_calc_amount', $params)){
            $amount = 0;
            foreach ($ids->childs as $child){
                $tmp = Api_Hotel_Shop_Pricelist::getAmountPricelistOfValues($child->values, 0, 0,
                    $dateFrom, $dateTo, $sitePageData, $driver);
                $amount += $tmp;
                $child->additionDatas = array(
                    'amount' => $tmp,
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                );
            }
            $ids->additionDatas['amount'] = $amount;
        }else{
            $ids->addAdditionDataChilds(
                array(
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                )
            );
        }
        $ids->additionDatas['date_from'] = $dateFrom;
        $ids->additionDatas['date_to'] = $dateTo;

        if (!$isLoadView) {
            return $ids;
        }

        $model = new Model_Hotel_Shop_Pricelist();
        $model->setDBDriver($driver);
        $result = Helpers_View::getViewObjects($ids, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID,
            TRUE, $elements, $isLoadOneView);

        $sitePageData->replaceDatas['view::'.$viewObjects] = $result;

        if (Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) {
            Helpers_DB::setMemcacheFunctionView($result, $shopID, 'View_Hotel_Shop_Pricelist::findFreeShopPricelists', $tables, $viewObjects, $sitePageData, $driver, $key);
        }

        return $result;
    }
}