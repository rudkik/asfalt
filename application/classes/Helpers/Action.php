<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Action {

    /**
     * Останавливаем акцию
     * @param Model_Shop_Action $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
	public static function stopAction(Model_Shop_Action $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		// получаем список товаров, на которые распространяется данная скидка
		$shopGoodIDs = Request_Request::find('DB_Shop_Good',$model->shopID, $sitePageData, $driver,
										   array('system_shop_action_id' => $model->id));

		// скидываем у всех данную скидку
		$driver->updateObjects(Model_Shop_Good::TABLE_NAME, $shopGoodIDs->getChildArrayID(),
				array('system_is_action' => 0, 'system_shop_action_id' => 0), 0, $model->shopID);

        $model->setIsRun(FALSE);
        $model->setIsPublic(FALSE);
        Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
	}

    /**
     * Запускаем акцию
     * @param Model_Shop_Action $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
	public static function startAction(Model_Shop_Action $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		switch ($model->getActionTypeID()) {
			case Model_ActionType::ACTION_TYPE_CATALOGS:{
				$shopGoodcatalogIDs = Arr::path($model->getDataArray(), 'id', array());

				// получаем список товаров из категорий
                $ids = Request_Request::find('DB_Shop_Good',$model->shopID, $sitePageData, $driver,
										   array('shop_table_rubric_id' => $shopGoodcatalogIDs, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'is_public_ignore' => TRUE));
				$shopGoodIDs = $ids->getChildArrayID();
			}
			break;
			case Model_ActionType::ACTION_TYPE_GOODS:{
                $shopGoodIDs[] = Arr::path($model->getDataArray(), 'id', array());
			}
			break;
            default:
                $shopGoodIDs = array();
		}

        // всем товарам добавляем акции
        $driver->updateObjects(Model_Shop_Good::TABLE_NAME, $shopGoodIDs,
            array('system_is_action' => 1, 'system_shop_action_id' => $model->id), 0, $model->shopID);

        $model->setIsRun(TRUE);
        Helpers_DB::saveDBObject($model, $sitePageData);
	}

    /**
     * Запускаем скидки, которым пришло время
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
	public static function runShopActions($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		$time = time();

		$model = new Model_Shop_Action();
		$model->setDBDriver($driver);

		// получаем список скидок, которые запущены, и проверяем, должны ли они работать
		$shopActionIDs = Request_Request::find(
		    DB_Shop_Action::NAME, $shopID, $sitePageData, $driver,
            array('is_run' => TRUE, 'is_public' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

		foreach ($shopActionIDs->childs as $shopActionID) {
			if ($model->dbGet($shopActionID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault, -1, $shopID)){
                if (($time < strtotime($model->getFromAt()) ||  ($time > strtotime($model->getToAt())))){
                    self::stopAction($model, $sitePageData, $driver);
                }
            }
		}

        // получаем список скидок, которые активные, но не запущены и проверяем,
        // должны ли они работать
        $shopActionIDs = Request_Request::find(
            DB_Shop_Action::NAME, $shopID, $sitePageData, $driver,
            array('is_run' => FALSE, 'is_public' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        foreach ($shopActionIDs->childs as $shopActionID) {
            if ($model->dbGet($shopActionID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault,  -1, $shopID)) {
                if (($time >= strtotime($model->getFromAt())) && ($time < strtotime($model->getToAt()))) {
                    self::startAction($model, $sitePageData, $driver);
                }
            }
        }

        // получаем список скидок, которые запущены, и проверяем, должны ли они работать для филиалов
        $shopIDs = Request_Shop::getBranchShopIDs($shopID, $sitePageData, $driver)->getChildArrayID();
        if(!empty($shopIDs)) {
            $shopActionIDs = Request_Request::findBranch(
                DB_Shop_Action::NAME, $shopIDs, $sitePageData, $driver,
                array('is_run' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            foreach ($shopActionIDs->childs as $shopActionID) {
                if ($model->dbGet($shopActionID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault, -1,  $shopActionID->values['shop_id'])) {
                    if (($time < strtotime($model->getFromAt()) || ($time > strtotime($model->getToAt())))) {
                        self::stopAction($model, $sitePageData, $driver);
                    }
                }
            }

            // получаем список скидок, которые активные, но не запущены и проверяем,
            // должны ли они работать
            $shopActionIDs = Request_Request::findBranch(
                DB_Shop_Action::NAME, $shopIDs, $sitePageData, $driver,
                array('is_run' => FALSE, 'is_public' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            foreach ($shopActionIDs->childs as $shopActionID) {
                if ($model->dbGet($shopActionID->id, $sitePageData->dataLanguageID, $sitePageData->languageIDDefault, -1, $shopActionID->values['shop_id'])) {
                    if (($time >= strtotime($model->getFromAt())) && ($time < strtotime($model->getToAt()))) {
                        self::startAction($model, $sitePageData, $driver);
                    }
                }
            }
        }
	}
}