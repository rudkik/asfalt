<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Payment_Book  {
    const REFERRAL_PERCENT = 20; // сколько рефераллу пойдет процентов

    /**
     * Добавляем приход денег по оплате заказа
     * @param Model_Tax_Shop_Bill $bill
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function addPaymentBill(Model_Tax_Shop_Bill $bill, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // фиксируем приход денег
        $model = new Model_Tax_Shop_Payment_Book();
        $model->setDBDriver($driver);
        $model->setAmount($bill->getAmount());
        $model->setShopPaidTypeID($bill->getShopPaidTypeID());
        $model->setIsComing(TRUE);
        $model->setDate($bill->getPaidAt());

        $bank = '';
        switch ($bill->getPaidTypeID()){
            case Bank_Kazkom_Pay::BANK_PAY_TYPE_ID:
                $bank = Bank_Kazkom_Pay::BANK_TITLE;
                break;
            case Bank_ATF_Pay::BANK_PAY_TYPE_ID:
                $bank = Bank_ATF_Pay::BANK_TITLE;
                break;
            case Bank_Wooppay_Pay::BANK_PAY_TYPE_ID:
                $bank = Bank_Wooppay_Pay::BANK_TITLE;
                break;
        }
        $model->setText('Пополение баланса через '.$bank);
        Helpers_DB::saveDBObject($model, $sitePageData, $bill->shopID);

        // продливаем срок действия подписки
        $model = new Model_Shop();
        $model->setDBDriver($driver);
        Helpers_DB::getDBObject($model, $bill->shopID, $sitePageData);

        $date = strtotime($model->getValidityAt());
        if ($date < time()){
            $date = time();
        }

        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s', $date). ' +' . $bill->getMonth() . ' month'));
        $model->setValidityAt($date);
        $model->addOptionsArray(array('access_type_id' => $bill->getAccessTypeID()));
        Helpers_DB::saveDBObject($model, $sitePageData);

        // фиксируем приход денег у реферала (кто пригласил магазин)
        if($model->getReferralShopID() > 0){
            $referralAmount = round($bill->getAmount() / 100 * self::REFERRAL_PERCENT, 0);

            // прибавляем баланс
            $modelReferral = new Model_Shop();
            $modelReferral->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelReferral, $model->getReferralShopID(), $sitePageData)) {
                $modelReferral->setBalance($modelReferral->getBalance() + $referralAmount);
                Helpers_DB::saveDBObject($modelReferral, $sitePageData);

                // фиксируем бонус
                $modelPayment = new Model_Tax_Shop_Payment_Book();
                $modelPayment->setDBDriver($driver);
                $modelPayment->setAmount($referralAmount);
                $modelPayment->setIsComing(TRUE);
                $modelPayment->setDate(date('Y-m-d H:i:s'));
                $modelPayment->setText('Бонус за приглашение ' . $model->getName());
                Helpers_DB::saveDBObject($modelPayment, $sitePageData, $modelReferral->id);
            }
        }

        // фиксируем списание денег на продление подписки
        $model = new Model_Tax_Shop_Payment_Book();
        $model->setDBDriver($driver);
        $model->setAmount($bill->getAmount() * (-1));
        $model->setIsComing(FALSE);
        $model->setDate(date('Y-m-d H:i:s'));
        $model->setText('Продление подписки до '.Helpers_DateTime::getDateFormatRus($date));
        Helpers_DB::saveDBObject($model, $sitePageData, $bill->shopID);
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Payment_Book();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment book not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamInt('shop_paid_type_id', $model);
        Request_RequestParams::setParamDateTime('date', $model);
        Request_RequestParams::setParamBoolean("is_coming", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }
}
