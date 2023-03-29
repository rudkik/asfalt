<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Sequence  {

    /**
     * Получение номера документа на текущий момент
     * @param $tableName
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $length
     * @return int|string
     */
    public static function getSequence($tableName, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
        $length = 10)
    {
        $sql = GlobalData::newModelDriverDBSQL();
        $sql->setTableName($tableName);
        $sql->limit = 1;

        $sql->getRootSelect()->addFunctionField('', '"number", \'^[0]+\', \'\'', 'regexp_replace', 'number');
        $sql->getrootSort()->addField('', 'number', FALSE);

        $sql->getRootWhere()->addField('number', '', '^[0-9]+$', '',
            Model_Driver_DBBasicWhere::COMPARE_TYPE_REGULAR);

        if ($year > 0) {
            $sql->getRootWhere()->addField('date', '', $year . '-01-01', '',
                Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY);
            $sql->getRootWhere()->addField('date', '', $year . '-12-31', '',
                Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY);
        }
        $arr = $driver->getSelect($sql, TRUE, $sitePageData->dataLanguageID, $sitePageData->shopID)['result'];

        if (count($arr) > 0) {
            $result = ltrim($arr[0]['number'], 0) * 1 + 1;
            if ($result < 1) {
                $result = 1;
            }
        }else{
            $result = 1;
        }

        $length = $length - mb_strlen($result);
        for ($i = 1; $i <= $length; $i++){
            $result = '0'.$result;
        }
        return $result;
    }
}
