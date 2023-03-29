<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport_Driver {

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Transport_Driver();
        $model->setDBDriver($driver);
        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
                throw new HTTP_Exception_500('Shop transport driver not found.');
            }
        }

        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('old_id', $model);
        Request_RequestParams::setParamInt('shop_worker_id', $model);

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
