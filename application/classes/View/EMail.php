<?php defined('SYSPATH') or die('No direct script access.');

class View_EMail
{
    /**
     * Отправка сведения о заказе по e-mail
     * @param $shopID
     * @param $shopBillID
     * @param $viewData - текст вьющки для письма
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return null|string
     */
    public static function getShopBill($shopID, $shopBillID, $viewData, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopBillID, $sitePageData, $shopID)) {
            return NULL;
        }

        $bill = array();
        $bill['id'] = $model->id;
        $bill['amount'] = $model->getAmount();
        $bill['discount'] = $model->getDiscount();
        $bill['client_comment'] = $model->getClientComment();
        $bill['delivery_amount'] = $model->getDeliveryAmount();
        $bill['delivery_paid_at'] = $model->getDeliveryAt();
        $bill['options'] = $model->getOptionsArray();
        $bill['created_at'] = $model->getCreatedAt();
        $bill['shop_bill_status_id'] = $model->getShopBillStatusID();

        // доставка
        $bill['delivery_name'] = '';
        if ($model->getShopDeliveryTypeID() > 0) {
            $modelDeliveryType = new Model_Shop_DeliveryType();
            $modelDeliveryType->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelDeliveryType, $model->getShopDeliveryTypeID(), $sitePageData, $shopID)) {
                $bill['delivery_name'] = $modelDeliveryType->getName();
            }
        }

        // оплата
        $bill['paid_name'] = '';
        if ($model->getShopPaidTypeID() > 0) {
            $modelPaidType = new Model_Shop_PaidType();
            $modelPaidType->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelPaidType, $model->getShopPaidTypeID(), $sitePageData, $shopID)) {
                $bill['paid_name'] = $modelPaidType->getName();
            }
        }

        // город
        $bill['city_name'] = '';
        if ($model->getShopPaidTypeID() > 0) {
            $modelCity = new Model_City();
            $modelCity->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelCity, $model->getCityID(), $sitePageData, $shopID)) {
                $bill['city_name'] = $modelCity->getName();
            }
        }

        // родитель заказа
        $shopRoot = array();
        if ($model->getShopRootID() > 0) {
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelShop, $model->getShopRootID(), $sitePageData, $shopID)) {
                $shopRoot = $modelShop->getValues(TRUE, TRUE);
            }
        }

        // страна
        $bill['country_name'] = '';

        // товары
        $shopBillItemIDs = Request_Request::find(
            DB_Shop_Bill_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(array('shop_bill_id' => $model->id))
        );

        $modelBillItem = new Model_Shop_Bill_Item();
        $modelBillItem->setDBDriver($driver);

        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);

        $modelGoodChild = new Model_Shop_Table_Child();
        $modelGoodChild->setDBDriver($driver);

        $billitems = array();
        foreach ($shopBillItemIDs->childs as $shopBillItemID) {
            if (!Helpers_DB::getDBObject($modelBillItem, $shopBillItemID->id, $sitePageData, $shopID)) {
                continue;
            }
            if (!Helpers_DB::getDBObject($modelGood, $modelBillItem->getShopGoodID(), $sitePageData, $shopID)) {
                continue;
            }
            if ($modelBillItem->getShopTableChildID() > 0) {
                if (!Helpers_DB::getDBObject($modelGoodChild, $modelBillItem->getShopTableChildID(), $sitePageData, $shopID)) {
                    continue;
                }
                $shopGoodChildName = $modelGoodChild->getName();
            } else {
                $shopGoodChildName = '';
            }

            $billitem = array();

            $billitem['goods_id'] = $modelGood->id;
            $billitem['goods_name'] = $modelGood->getName();
            $billitem['goods_article'] = $modelGood->getArticle();
            $billitem['goods_image_path'] = $modelGood->getImagePath();
            $billitem['goods_text'] = $modelGood->getText();
            $billitem['goods_child_name'] = $shopGoodChildName;
            $billitem['goods_options'] = $modelGood->getOptionsArray();

            $billitem['price'] = $modelBillItem->getPrice();
            $billitem['count'] = $modelBillItem->getCountElement();
            $billitem['discount'] = $modelBillItem->getDiscount();
            $billitem['amount'] = $modelBillItem->getAmount();
            $billitem['client_comment'] = $modelBillItem->getClientComment();
            $billitem['options'] = $modelBillItem->getOptionsArray();

            $billitems[] = $billitem;
        }

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->bill = $bill;
            $view->billitems = $billitems;
            $view->shopRoot = $shopRoot;
            $view->siteData = $sitePageData;
            $datas = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
            echo $e->getMessage(); die;
        }
        unlink($file);

        return $datas;
    }

    /**
     * Отправка сведения о создании пользователя по e-mail
     * @param $shopID
     * @param $shopBillID
     * @param $viewData - текст вьющки для письма
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return null|string
     */
    public static function getCreateShopUser($shopID, $shopUserID, $viewData, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_User();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopUserID, $sitePageData, $shopID)) {
            return NULL;
        }

        $user = array();
        $user['id'] = $model->id;
        $user['name'] = $model->getName();
        $user['email'] = $model->getEmail();
        $user['options'] = $model->getOptionsArray();

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->user = $user;
            $view->params = $params;
            $view->siteData = $sitePageData;
            $datas = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
           echo $e->getMessage(); die;
        }
        unlink($file);

        return $datas;
    }

    /**
     * Отправка сведения о восстановление пароля по e-mail
     * @param $shopID
     * @param $shopBillID
     * @param $viewData - текст вьющки для письма
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return null|string
     */
    public static function getRememberPasswordShopUserByEMail($shopID, $shopUserID, $viewData, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_User();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopUserID, $sitePageData, $shopID)) {
            return NULL;
        }

        $model->setUserHash(Auth::instance()->hashPassword($model->getPassword()));
        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        $user = array();
        $user['id'] = $model->id;
        $user['name'] = $model->getName();
        $user['email'] = $model->getEmail();
        $user['options'] = $model->getOptionsArray();
        $user['code'] = 'code='.$model->getUserHash();

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->user = $user;
            $view->params = $params;
            $view->siteData = $sitePageData;
            $datas = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
            echo $e->getMessage(); die;
        }
        unlink($file);

        return $datas;
    }

    /**
     * Отправка сведения о восстановление пароля по e-mail
     * @param $shopID
     * @param $shopOperationID
     * @param $viewData
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return null|string
     */
    public static function getRememberPasswordShopOperationByEMail($shopID, $shopOperationID, $viewData, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                              array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_Shop_Operation();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopOperationID, $sitePageData, $shopID)) {
            return NULL;
        }

        $model->setUserHash(Auth::instance()->hashPassword($model->getPassword()));
        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        $user = array();
        $user['id'] = $model->id;
        $user['name'] = $model->getName();
        $user['email'] = $model->getEmail();
        $user['options'] = $model->getOptionsArray();
        $user['code'] = 'code='.$model->getUserHash();

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->user = $user;
            $view->params = $params;
            $view->siteData = $sitePageData;
            $datas = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
            echo $e->getMessage(); die;
        }
        unlink($file);

        return $datas;
    }


    /**
     * Отправка сведения о создании пользователя по e-mail
     * @param $shopID
     * @param $shopMessageID
     * @param $viewData
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $title
     * @param array $files
     * @param array $params
     * @return null|string
     */
    public static function getAddShopMessage($shopID, $shopMessageID, $viewData, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             &$title, array &$files, array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_Shop_Message();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopMessageID, $sitePageData, $shopID)) {
            return NULL;
        }
        $model->getElement('shop_client_id', TRUE);

        $element = $model->getElement('shop_table_catalog_id', TRUE);
        if(empty($title)){
            if($element === NULL){
                $title = 'Сообщение';
            }else{
                $title = $element->getName();
            }
        }

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->data = $model->getValues(TRUE, TRUE, $sitePageData->shopMainID);
            $view->siteData = $sitePageData;
            $data = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
            echo $e->getMessage(); die;
        }
        unlink($file);

        return $data;
    }

    /**
     * Отправка сведения о создании рассылки от пользователя
     * @param $shopID
     * @param $shopBillID
     * @param $viewData - текст вьющки для письма
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return null|string
     */
    public static function getAddShopSubscribe($shopID, $shopSubscribeID, $viewData, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             &$title, array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_Shop_Subscribe();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopSubscribeID, $sitePageData, $shopID)) {
            return NULL;
        }

        $model->dbGetElements('shop_table_catalog_id');
        if(empty($title)){
            $element = $model->getElement('shop_table_catalog_id');
            if($element !== NULL) {
                $title = $element->getName();
            }
        }

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->data = $model->getValues(TRUE, TRUE);
            $view->siteData = $sitePageData;
            $datas = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
            echo $e->getMessage(); die;
        }
        unlink($file);

        return $datas;
    }

    /**
     * Отправка сведения  о изменение данных о клиенте
     * @param $shopID
     * @param $shopClientID
     * @param $viewData - текст вьющки для письма
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return null|string
     */
    public static function getUpdateShopClient($shopID, $shopClientID, $viewData, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               &$title, array $params = array())
    {
        if(empty($viewData)){
            return NULL;
        }

        $model = new Model_Shop_Client();
        $model->setDBDriver($driver);
        if (! Helpers_DB::getDBObject($model, $shopClientID, $sitePageData, $shopID)) {
            return NULL;
        }

        $element = $model->getElement('shop_table_catalog_id', TRUE);
        if($element !== NULL) {
            $title = $element->getName();
        }else{
            $title = '';
        }

        $paramsContact = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
            )
        );
        $shopClientContactIDs = Request_Shop_ClientContact::findShopClientContactIDs($shopID, $sitePageData, $driver,
            $paramsContact, 0, TRUE, array('client_contact_type_id' => array('name')));

        $shopClientContacts = array();
        foreach ($shopClientContactIDs->childs as $child){
            $shopClientContacts[] = array(
                'name' => trim($child->values['last_name'].' '.$child->values['name']),
                'type' => $child->getElementValue('client_contact_type_id'),
            );
        }

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR. 'message' . DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($file);
        $tmp = 1000;
        while (file_exists($file . $tmp . '.php')) {
            $tmp++;
        }
        $file = $file . $tmp . '.php';
        file_put_contents($file, $viewData, FILE_APPEND);

        $fileView = '/email/message/' . $tmp;
        try {
            $view = View::factory($fileView);
            $view->client = $model->getValues(TRUE, TRUE);
            $view->contacts = $shopClientContacts;
            $view->siteData = $sitePageData;
            $datas = Helpers_View::viewToStr($view);
        } catch (Exception $e) {
            echo $e->getMessage(); die;
        }
        unlink($file);

        return $datas;
    }
}