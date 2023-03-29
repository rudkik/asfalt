<?php defined('SYSPATH') or die('No direct script access.');

class Api_ShopLoadFile
{

    /**
     * Поиск соответствий данных с БД
     * @param array $data
     * @param $typeID
     * @param $tableID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function findCollations(array $data, $typeID, $tableID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        switch ($tableID) {
            case Model_Shop_Good::TABLE_ID:
                $objects = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData, $driver,
                    array('type' => $typeID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
                $field = 'shop_good_';
                break;
            default:
                return $data;
        }

        // распарсить массив соответствий
        foreach ($objects->childs as $object) {
            if (empty($object->values['collations'])) {
                $object->values['collations'] = array();
            } else {
                $object->values['collations'] = json_decode($object->values['collations'], TRUE);
            }
        }

        // сопоставление данных
        foreach ($data as &$record) {
            $collations = Arr::path($record, 'collations', '');

            $record[$field.'id'] = 0;
            foreach ($objects->childs as $key => $object) {
                if(array_search($collations, $object->values['collations']) !== FALSE){
                    $record[$field.'id'] = $object->values['id'];
                    $record[$field.'name'] = $object->values['name'];

                    unset($objects->childs[$key]);
                    break;
                }
            }
        }

        return $data;
    }
}