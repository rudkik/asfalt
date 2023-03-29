<?php defined('SYSPATH') or die('No direct script access.');

class Request_Magazine_Shop_Production_Rubric extends Request_Request {
    /**
     * Получаем детвору у всех элементов
     * @param $rubric
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     */
    private static function _getChildRubricIDs($rubric, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL)
    {
        $childRubricIDs = self::findByRoot(
            $shopID, $rubric->id, $sitePageData, $driver, array(), 0, $isLoadAllFields, $elements
        );
        foreach($childRubricIDs->childs as $childRubricID){
            self::_getChildRubricIDs(
                $childRubricID, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements
            );
        }
        $rubric->childs = $childRubricIDs->childs;
    }

    /**
     * Поиск рубрик родителя
     * @param $shopID
     * @param $rootID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @return MyArray
     */
    public static function findByRoot($shopID, $rootID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL){
        // не считывать параметры переданные в GET и POST запросах
        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        if(!$isNotReadRequest){
            $params = array_merge($params, $_GET, $_POST);
        }

        $params['root_id'] = $rootID;
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        return self::find(
            'DB_Magazine_Shop_Production_Rubric', $shopID, $sitePageData, $driver, $params, $limit,
            $isLoadAllFields, $elements
        );
    }
}
