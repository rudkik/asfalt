<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Product_TNVED  {

    /**
     * Получаем Идентификатор товара, работ, услуг по ТНВЭД
     * @param $catalogTruID
     * @param $tnved
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed|string
     */
    public static function getCatalogTruID($catalogTruID, $tnved, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($catalogTruID == 0){
            $catalogTruID = 1;
        }

        if(empty($tnved)){
            return $catalogTruID;
        }

        if(!empty($catalogTruID) && ($catalogTruID != 1 && $catalogTruID != 0)){
            if($catalogTruID == 0){
                $catalogTruID = 1;
            }
            return $catalogTruID;
        }

        $result = Request_Request::findByField(
            DB_Magazine_Shop_Product_TNVED::NAME, 'tnved_full', $tnved, $sitePageData->shopMainID,
            $sitePageData, $driver, 1, true
        );

        if(count($result->childs) < 1){
            $result = Request_Request::findByField(
                DB_Magazine_Shop_Product_TNVED::NAME, 'tnved_full', ltrim($tnved, 0), $sitePageData->shopMainID,
                $sitePageData, $driver, 1, true
            );
        }

        if(count($result->childs) < 1){
            return $catalogTruID;
        }
        $result = $result->childs[0];

        return mb_substr($result->values['kpved'], 1) . '-' . $tnved;
    }
}
