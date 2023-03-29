<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Guarantee_Item  {

    /**
     * Сохранение список продукции доверенности
     * @param $shopID
     * @param $shopClientGuaranteeID
     * @param array $shopClientGuaranteeItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopID, $shopClientGuaranteeID, array $shopClientGuaranteeItems, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Guarantee_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_client_guarantee_id' => $shopClientGuaranteeID,
                'sort_by' => array('id' => 'asc'),
            )
        );
        $shopClientGuaranteeItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Guarantee_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        $result = array(
            'amount' => 0,
            'name' => '',
        );
        foreach($shopClientGuaranteeItems as $shopClientGuaranteeItem){
            $shopProductID = intval(Arr::path($shopClientGuaranteeItem, 'shop_product_id', 0));
            $shopProductRubricID = intval(Arr::path($shopClientGuaranteeItem, 'shop_product_rubric_id', 0));

            $quantity = Request_RequestParams::strToFloat(Arr::path($shopClientGuaranteeItem, 'quantity', 0));
            if($quantity <= 0){
                continue;
            }

            $price =  Request_RequestParams::strToFloat(Arr::path($shopClientGuaranteeItem, 'price', 0));
            if($price <= 0){
                continue;
            }

            $shopClientGuaranteeItemID = NULL;
            foreach ($shopClientGuaranteeItemIDs->childs as $key => $child){
                if((($shopProductID > 0) && ($child->values['shop_product_id'] == $shopProductID))
                   || (($shopProductRubricID > 0) && ($child->values['shop_product_rubric_id'] == $shopProductRubricID))){
                    $shopClientGuaranteeItemID = $child;
                    unset($shopClientGuaranteeItemIDs->childs[$key]);
                    break;
                }
            }
            if($shopClientGuaranteeItemID !== NULL){
                $shopClientGuaranteeItemID->setModel($model);
            }else{
                $model->clear();
            }

            $model->setShopProductID($shopProductID);
            $model->setShopProductRubricID($shopProductRubricID);
            $model->setQuantity($quantity);
            $model->setPrice($price);
            $model->setShopClientGuaranteeID($shopClientGuaranteeID);

            if($shopProductID > 0){
                $modelItem = new Model_Ab1_Shop_Product();
                $id = $shopProductID;
            }else{
                $modelItem = new Model_Ab1_Shop_Product_Rubric();
                $id = $shopProductRubricID;
                $shopID = $sitePageData->shopMainID;
            }
            $modelItem->setDBDriver($driver);

            if(Helpers_DB::getDBObject($modelItem, $id, $sitePageData, $shopID)){
                $name = $modelItem->getName();
            }else{
                $name = 'Все';
            }

            $model->setName(
                'Продукция: <b>'.$name.'</b> на сумму: <b>'
                .Func::getPriceStr($sitePageData->currency, $model->getAmount())
                .'</b><br>'
            );

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $result['amount'] += $model->getAmount();
            $result['name'] .= $model->getName();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopClientGuaranteeItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Client_Guarantee_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $result;
    }
}
