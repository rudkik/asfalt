<?php defined('SYSPATH') or die('No direct script access.');

class View_Basic_Basic {


    /**
     * Получаем список таблиц из списка полей на расшифровку
     * @param $tableName
     * @param null | array $elements
     */
    public static function getTables($dbObject, $elements = NULL){
        return array($dbObject::TABLE_NAME);
    }

    /**
     * Получить объект
     * @param $shopID
     * @param Model_Basic_DBValue $model
     * @param SitePageData $sitePageData
     * @param array $params
     * @param null $elements
     * @param string $errorMessage
     * @return MyArray
     * @throws HTTP_Exception_404
     */
    public static function getShopObject($shopID, Model_Basic_DBValue $model, SitePageData $sitePageData,
                                         array $params = array(), $elements = NULL, $errorMessage = ''){
        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        $id = Request_RequestParams::getParamInt('id', $params, $isNotReadRequest);

        $objectID = new MyArray();
        $objectID->id = $id;
        if (!Helpers_View::getDBData($objectID, $model, $sitePageData, $shopID, $elements)) {
            if (Request_RequestParams::getParamBoolean('is_error_404', $params) === TRUE) {
                throw new HTTP_Exception_404($errorMessage);
            } else {
                $objectID->values = array();
                $objectID->isFindDB = TRUE;
            }
            $objectID->id = 0;
        }

        return $objectID;
    }
}