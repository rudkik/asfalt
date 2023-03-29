<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Client_Guarantee  {

    /**
     * удаление товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Ab1_Shop_Client_Guarantee();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Client guarantee not found. #2901201610');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if ($isUnDel){
            $shopClientGuaranteeItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Guarantee_Item',
                $sitePageData->shopMainID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_guarantee_id' => $id,
                        'is_delete' => 1,
                        'is_public' => 0,
                    )
                )
            );

            $driver->unDeleteObjectIDs(
                $shopClientGuaranteeItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Client_Guarantee_Item::TABLE_NAME, array('is_public' => 1), $sitePageData->shopMainID
            );
        }else{
            $shopClientGuaranteeItemIDs = Request_Request::find('DB_Ab1_Shop_Client_Guarantee_Item',
                $sitePageData->shopMainID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_guarantee_id' => $id,
                    )
                )
            );

            $driver->deleteObjectIDs(
                $shopClientGuaranteeItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Client_Guarantee_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopMainID
            );
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Client_Guarantee();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Client guarantee not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_client_id", $model);

        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            $options = $model->getOptionsArray();
            $files = Helpers_Image::getChildrenFILES('options');
            foreach ($files as $key => $child) {
                if(is_array($child['tmp_name'])){
                    foreach ($child['tmp_name'] as $index => $path){
                        $data = array(
                            'tmp_name' => $path,
                            'name' => $child['name'][$index],
                            'type' => $child['type'][$index],
                            'error' => $child['error'][$index],
                            'size' => $child['size'][$index],
                        );
                        $options[$key][] = array(
                            'file' => $file->saveDownloadFilePath($data, $model->id, Model_Ab1_Shop_Client_Guarantee::TABLE_ID, $sitePageData),
                            'name' => $data['name'],
                            'size' => $data['size'],
                        );
                    }
                }else{
                    $options[$key][] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Ab1_Shop_Client_Guarantee::TABLE_ID, $sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            $model->addOptionsArray($options);

            $shopClientGuaranteeItems = Request_RequestParams::getParamArray('shop_client_guarantee_items');
            if($shopClientGuaranteeItems !== NULL) {
                $data = Api_Ab1_Shop_Client_Guarantee_Item::save(
                    $sitePageData->shopID, $model->id, $shopClientGuaranteeItems, $sitePageData, $driver
                );
                $model->setAmount($data['amount']);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
