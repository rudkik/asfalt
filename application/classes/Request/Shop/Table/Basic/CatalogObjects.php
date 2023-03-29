<?php defined('SYSPATH') or die('No direct script access.');

class Request_Shop_Table_Basic_CatalogObjects extends Request_Shop_Table_Basic_Rubric
{

    /**
     * Создаем запрос из данных
     * @param Model_Driver_DBBasicSQL $sql
     * @param SitePageData $sitePageData
     * @param $isNotReadRequest
     * @param array $params
     * @param null | array $sortBy
     * @param null | array $groupBy
     */
    protected static $paramsFindShopTableCatalogObjects = array('shop_table_hashtag_id', 'shop_table_select_id',
        'shop_table_brand_id', 'shop_table_unit_id', 'old_id', 'old_id_empty');

    protected static function _getRequestParamsSQL($shopID, Model_Driver_DBBasicSQL $sql, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                   $isNotReadRequest, array $params = array(), $sortBy = NULL, $groupBy = NULL, $tableName = ''){

        $hashtags = Request_RequestParams::getParam('shop_table_hashtag_id', $params, NULL, $isNotReadRequest, $sitePageData);
        if($hashtags !== NULL){
            if((is_array($hashtags) && !empty($hashtags)) || (!is_array($hashtags) && ($hashtags * 1 > 0))) {
                $ids = Request_Shop_Table_ObjectToObject::findShopRootIDs($shopID, $sitePageData,
                    $driver, array('shop_child_object_id' => $hashtags, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
                if (count($ids->childs) == 0) {
                    return FALSE;
                }

                $sql->getRootWhere()->addField('id', '', $ids->getChildArrayID(TRUE), '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
            }
        }


        for($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++){
            Request_RequestUtils::setWhereFieldInt($sitePageData, array('param_'.$i.'_int'),
                'param_'.$i.'_int', $sql->getRootWhere(), $params, $isNotReadRequest);
            Request_RequestUtils::setWhereFieldStr($sitePageData, array('param_'.$i.'_str'),
                'param_'.$i.'_str', $sql->getRootWhere(), $params, $isNotReadRequest);
        }

        return parent::_getRequestParamsSQL($shopID, $sql, $sitePageData, $driver, $isNotReadRequest, $params, $sortBy, $groupBy, $tableName);
    }

}