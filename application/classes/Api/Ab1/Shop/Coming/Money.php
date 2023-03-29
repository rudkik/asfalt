<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Coming_Money  {
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

        $model = new Model_Ab1_Shop_Coming_Money();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Coming money not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
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
        $model = new Model_Ab1_Shop_Coming_Money();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Coming money not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("number", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamInt("shop_cashbox_id", $model);


        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем расходники в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список расходников
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $from,
                'created_at_to' => $to
            )
        );
        $shopComingMoneyIDs = Request_Request::findBranch('DB_Ab1_Shop_Coming_Money',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_cashbox_id' => array('name', 'old_id'),
                'shop_id' => array('name', 'old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopComingMoneyIDs->childs as $shopComingMoneyID){
            $data .= '<consumable>'
                .'<NumDoc>'.$shopComingMoneyID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopComingMoneyID->values['created_at'])).'</date>'
                .'<amount>'.$shopComingMoneyID->values['amount'].'</amount>'
                .'<branch>'.$shopComingMoneyID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.htmlspecialchars($shopComingMoneyID->getElementValue('shop_id', 'name'), ENT_XML1).'</branch_name>'
                .'<cashbox>'.htmlspecialchars($shopComingMoneyID->getElementValue('shop_cashbox_id', 'old_id'), ENT_XML1).'</cashbox>'
                .'<cashbox_name>'.htmlspecialchars($shopComingMoneyID->getElementValue('shop_cashbox_id'), ENT_XML1).'</cashbox_name>';

            $data .= '</consumable>';
        }

        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="coming.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}
