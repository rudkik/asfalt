<?php defined('SYSPATH') or die('No direct script access.');

class Api_AutoPart_Shop_Product
{
    /**
     * Получаем список связанных товаров и группируем по минимальной закупочной цене
     * возвращеме массив id родительствого товара = минимальная закупочная цена
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return array
     */
    public static function getBindProducts($shopSourceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           $params = array()){

        $params = array_merge(
            $params,
            [
                'shop_source_id' => $shopSourceID,
                'root_shop_product_id_from' => 0,
                'is_public' => 1,
                'is_in_stock' => 1,
            ]
        );

        // ищем связанные товары
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams($params), 0, true,
            [
                'shop_supplier_id' => array('is_disable_dumping', 'min_markup'),
            ]
        );

        // группируем товары по родителю и ищем минимальную себестоимость
        $bindIDs = [];
        foreach ($ids->childs as $child){
            $root = $child->values['root_shop_product_id'];
            if(!key_exists($root, $bindIDs)){
                $bindIDs[$root] = [
                    'is_disable_dumping' => $child->getElementValue('shop_supplier_id', 'is_disable_dumping'),
                    'min_markup' => $child->getElementValue('shop_supplier_id', 'min_markup'),
                    'price_cost' => $child->values['price_cost'],
                ];
            }elseif ($bindIDs[$root]['price_cost'] > $child->values['price_cost']) {
                $bindIDs[$root] = [
                    'is_disable_dumping' => $child->getElementValue('shop_supplier_id', 'is_disable_dumping'),
                    'min_markup' => $child->getElementValue('shop_supplier_id', 'min_markup'),
                    'price_cost' => $child->values['price_cost'],
                ];
            }
        }

        return $bindIDs;
    }
}