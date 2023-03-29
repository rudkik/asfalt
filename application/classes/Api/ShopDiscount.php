<?php defined('SYSPATH') or die('No direct script access.');

class Api_ShopDiscount  {

    public static function saveShopDiscount(Model_Shop_Discount $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model->setDBDriver($driver);
        $id = Request_RequestParams::getParamInt('id');
        if (! Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopID)) {
            throw new HTTP_Exception_500('Discount not found.');
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamDateTime('from_at', $model);
        Request_RequestParams::setParamDateTime('to_at', $model);
        Request_RequestParams::setParamStr('text', $model);

        Request_RequestParams::setParamInt('discount_type_id', $model);
        switch ($model->getDiscountTypeID()) {
            case Model_DiscountType::DISCOUNT_TYPE_BILL_AMOUNT:
                $data = Request_RequestParams::getParamFloat('amount');
                if ($data !== NULL) {
                    $model->setDataArray(array('amount' => $data));
                }else{
                    $model->setDiscountTypeID(0);
                    $model->setDataArray(array());
                }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_CATALOGS:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('shopgoodcatalog_ids');
                foreach($catalogs as $catalog){
                    $catalog = intval($catalog);
                    if($catalog > 0){
                        $data[] = $catalog;
                    }
                }

                $count = Request_RequestParams::getParamFloat('shopgoodcatalogs_count');
                $amount = Request_RequestParams::getParamFloat('shopgoodcatalogs_amount');
                if((! empty($data)) && (($count > 0) || ($amount > 0))){
                    $model->setDataArray(
                        array(
                            'id' => $data,
                            'count' => $count,
                            'amount' => $amount
                        )
                    );
                }else{
                    $model->setDiscountTypeID(0);
                    $model->setDataArray(array());
                }

                break;
            case Model_DiscountType::DISCOUNT_TYPE_GOODS:
                $data = array();

                $catalogs = Request_RequestParams::getParamArray('shopgood_ids');
                foreach($catalogs as $catalog){
                    $catalog = intval($catalog);
                    if($catalog > 0){
                        $data[] = $catalog;
                    }
                }

                $count = Request_RequestParams::getParamFloat('shopgoods_count');
                $amount = Request_RequestParams::getParamFloat('shopgoods_amount');
                if((! empty($data)) && (($count > 0) || ($amount > 0))){
                    $model->setDataArray(
                        array(
                            'id' => $data,
                            'count' => $count,
                            'amount' => $amount
                        )
                    );
                }else{
                    $model->setDiscountTypeID(0);
                    $model->setDataArray(array());
                }
                break;
            case Model_DiscountType::DISCOUNT_TYPE_GOOD:
                Request_RequestParams::setParamInt('shop_good_id', $model);
                break;
            default:
                $model->setDiscountTypeID(0);
                $model->setDataArray(array());
        }

        // подарок
        Request_RequestParams::setParamInt('gift_type_id', $model);
        switch ($model->getGiftTypeID()) {
            case Model_GiftType::GIFT_TYPE_BILL_COMMENT:
                $data = Request_RequestParams::getParamStr('bill_comment');
                if ($data !== NULL) {
                    $model->setBillComment($data);
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                }else{
                    $model->setGiftTypeID(0);
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                    $model->setBillComment('');
                }
                break;
            case Model_GiftType::GIFT_TYPE_BILL_DISCOUNT:
                $discount = Request_RequestParams::getParamFloat('discount');
                if($discount > 0){
                    Request_RequestParams::setParamBoolean('is_percent', $model);
                    $model->setDiscount($discount);
                    $model->setBillComment('');
                }else{
                    $model->setGiftTypeID(0);
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                    $model->setBillComment('');
                }
                break;
            case Model_GiftType::GIFT_TYPE_BILL_DISCOUNT_AND_COMMENT:
                $discount = Request_RequestParams::getParamFloat('discount');
                Request_RequestParams::setParamStr('bill_comment', $model);
                if($discount > 0){
                    Request_RequestParams::setParamBoolean('is_percent', $model);
                    $model->setDiscount($discount);
                }else{
                    $model->setDiscount(0);
                    $model->setIsPercent(FALSE);
                }
                break;
            default:
                $model->setGiftTypeID(0);
                $model->setDiscount(0);
                $model->setIsPercent(FALSE);
                $model->setBillComment('');

        }

        $result = array();
        if ($model->validationFields($result)) {
            $model->setEditUserID($sitePageData->userID);
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            Helpers_Discount::runShopDiscounts($sitePageData->shopMainID, $sitePageData, $driver);
        }

        return $result;
    }
}