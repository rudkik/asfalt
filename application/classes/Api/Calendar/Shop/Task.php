<?php defined('SYSPATH') or die('No direct script access.');

class Api_Calendar_Shop_Task  {
    const CALENDAR_NAME = 'KINGSTON';

    /**
     * удаление реализации
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

        $model = new Model_Calendar_Shop_Task();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Task not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            // добавляем событие в календарь
            $model->setOldID(
                Drivers_Google_Google::addEventCalendar(
                    $sitePageData, self::CALENDAR_NAME, $model->getName(), $model->getText(),
                    $model->getDateFrom(), $model->getDateTo()
                )
            );
            Helpers_DB::saveDBObject($model, $sitePageData);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
            // удаляем событие из календаря
            Drivers_Google_Google::addEventCalendar($sitePageData, self::CALENDAR_NAME, $model->getOldID());
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
        $model = new Model_Calendar_Shop_Task();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Task not found.');
            }
        }

        $nameOld = $model->getName();
        Request_RequestParams::setParamStr('name', $model);

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamDate("date_from", $model);
        Request_RequestParams::setParamDate("date_to", $model);
        Request_RequestParams::setParamFloat("cost", $model);
        Request_RequestParams::setParamStr("mbc", $model);
        Request_RequestParams::setParamBoolean('is_calendar_outer', $model);

        $model->setShopRubricID(
            Api_Calendar_Shop_Rubric::getIDByName(
                Request_RequestParams::getParamStr('shop_rubric_name'),
                $sitePageData,
                $driver
            )
        );
        $model->setShopProductID(
            Api_Calendar_Shop_Product::getIDByName(
                Request_RequestParams::getParamStr('shop_product_name'),
                $sitePageData,
                $driver
            )
        );
        $model->setShopPartnerID(
            Api_Calendar_Shop_Partner::getIDByName(
                Request_RequestParams::getParamStr('shop_partner_name'),
                $sitePageData,
                $driver
            )
        );
        $model->setShopResultID(
            Api_Calendar_Shop_Result::getIDByName(
                Request_RequestParams::getParamStr('shop_result_name'),
                $sitePageData,
                $driver
            )
        );

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);

                // добавляем событие в календарь
                if($model->getIsCalendarOuter() && !Func::_empty($model->getDateFrom()) && !Func::_empty($model->getDateTo())) {
                    $model->setOldID(
                        Drivers_Google_Google::addEventCalendar(
                            $sitePageData, self::CALENDAR_NAME, $model->getName(), $model->getText(),
                            $model->getDateFrom(), $model->getDateTo()
                        )
                    );
                }
            }else{
                // изменяем событие в календаре
                if($model->getIsCalendarOuter() && !Func::_empty($model->getDateFrom()) && !Func::_empty($model->getDateTo())) {
                    $model->setOldID(
                        Drivers_Google_Google::editEventCalendar(
                            $sitePageData, self::CALENDAR_NAME, $model->getOldID(), $model->getName(),
                            $model->getText(), $model->getDateFrom(), $model->getDateTo()
                        )
                    );
                }elseif(!Func::_empty($model->getOldID())){
                    Drivers_Google_Google::delEventCalendar(
                        $sitePageData, self::CALENDAR_NAME, $model->getOldID()
                    );
                }
            }

            $basicFiles = $model->getFilesArray();
            // загружаем файлы
            $files = Request_RequestParams::getParamArray('file_list');
            if($files !== NULL) {
                $model->setFiles(
                    Helpers_File_Save::saveFiles(
                        $files,
                        $model->id,
                        $model->getName(),
                        $nameOld,
                        $model->getDateTo(),
                        $sitePageData, $driver
                    )
                );
            }

            $googleDisk = new Drivers_Google_Disk();
            $googleDisk->auth($sitePageData);

            $modelImage = new Model_Shop_Image();
            $modelImage->setDBDriver($driver);

            // добавляем файлы на Google диск
            $files = $model->getFilesArray();
            foreach ($files as &$file){
                if(!Func::_empty(Arr::path($file, 'options.google_disk_id', ''))){
                    continue;
                }

                $fileName = $file['file'];
                $pathDisk = substr($fileName, strpos($fileName, 'files/'));
                $fileName = DOCROOT .  $pathDisk;
                $pathDisk = dirname(str_replace('files/', 'TaskManager/', $pathDisk));

                $file['options']['google_disk_id'] = $googleDisk->insertFile(
                    $fileName, $pathDisk, $model->getName()
                )->getId();

                if(Helpers_DB::getDBObject($modelImage, $file['id'], $sitePageData)){
                    $modelImage->setOptionsArray(
                        array_merge(
                            $modelImage->getOptionsArray(),
                            array('google_disk_id' => $file['options']['google_disk_id'])
                        )
                    );
                    Helpers_DB::saveDBObject($modelImage, $sitePageData);
                }
            }
            $model->setFilesArray($files);


            foreach ($basicFiles as $basicFile){
                $googleID = Arr::path($basicFile, 'options.google_disk_id', '');
                if(empty($googleID)){
                    continue;
                }

                foreach ($files as $file){
                    if($googleID == Arr::path($file, 'options.google_disk_id', '')){
                        continue 2;
                    }
                }

                $fileName = $basicFile['file'];
                $pathDisk = substr($fileName, strpos($fileName, 'files/'));
                $pathDisk = dirname(str_replace('files/', 'KINGSTON/', $pathDisk));
                $googleDisk->deleteFile(basename($fileName), $pathDisk);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
