<?php defined('SYSPATH') or die('No direct script access.');

class View_Favorite extends View_View {
    /**
     * Получаем список товаров магазина в избранном
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadOneView
     * @param bool $isLoadView
     * @return array|bool|mixed|MyArray
     */
    public static function getShopGoods($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                        Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                        $isLoadOneView = FALSE, $isLoadView = TRUE){

        // ставим дополнительные загрушки, системные вьюшки (чтобы много раз не пересчитывать корзину)
        $sitePageData->globalDatas['view::favorite_count'] = '^#@view::favorite_count@#^';

        // ищем в мемкеше
        $key =  Api_Favorite::getHash($sitePageData);
        $data = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Favorite::getShopGoods', array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key);
        if ($data !== NULL){
            $sitePageData->replaceDatas['view::'.$viewObjects] = $data['shopgoods'];
            $sitePageData->replaceDatas['view::favorite_count'] = $data['count'];

            return $data;
        }

        // получаем количество товаров
        $shopGoodIDs = Api_Favorite::getShopGoods($sitePageData);
        if (!$isLoadView) {
            return $shopGoodIDs;
        }

        // получаем товары
        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);
        $shopGoods = Helpers_View::getViewObjects(
            $shopGoodIDs, $model, $viewObjects, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements
        );

        $sitePageData->replaceDatas['view::'.$viewObjects] = $shopGoods;


        $sitePageData->replaceDatas['view::favorite_count'] = count($shopGoodIDs->childs);

        $data = array(
            'shopgoods' => $shopGoods,
            'count' => count($shopGoodIDs->childs),
        );

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView(
            $data, $shopID, 'View_Favorite::getShopGoods',
            array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key
        );

        return $data;
    }

    /**
     * Получаем количество товаров магазина в избранном
     * @param $dbObject
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadOneView
     * @param bool $isLoadView
     * @return array|bool|mixed|MyArray
     */
    public static function getCountShopGoods($dbObject, $shopID, $viewObject, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                             $isLoadOneView = FALSE, $isLoadView = TRUE){
        // ищем в мемкеше
        $key =  Api_Favorite::getHash($sitePageData);
        $data = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Favorite::getCountShopGoods', array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObject, $sitePageData, $driver, $key);
        if ($data !== NULL){
            $sitePageData->replaceDatas['view::'.$viewObject] = $data;
            return $data;
        }

        // получаем количество товаров
        $shopGoodIDs = Api_Favorite::getShopGoods($sitePageData);
        if (!$isLoadView) {
            return $shopGoodIDs;
        }

        $shopGoodIDs->values['count'] = count($shopGoodIDs->childs);

        $shopGoods = Helpers_View::getView(
            $viewObject, $sitePageData, $driver, $shopGoodIDs
        );

        $sitePageData->replaceDatas['view::'.$viewObject] = $shopGoods;


        $sitePageData->replaceDatas['view::favorite_count'] = count($shopGoodIDs->childs);

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView(
            $data, $shopID, 'View_Favorite::getCountShopGoods',
            array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObject, $sitePageData, $driver, $key
        );

        return $data;
    }
}