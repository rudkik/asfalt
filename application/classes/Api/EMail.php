<?php defined('SYSPATH') or die('No direct script access.');

class Api_EMail
{
    /**
     * Отправить на е-mail письмо
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @throws HTTP_Exception_500
     */
    public static function sendEMail($shopID, $viewObject,
                                     SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                     array $params){

        // не считывать параметры переданные в GET и POST запросах
        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);


        $email = Request_RequestParams::getParamStr('email', $params, $isNotReadRequest);
        $messageTitle = Request_RequestParams::getParamStr('message_title', $params, $isNotReadRequest);

        $data = new MyArray();
        $data->values = Request_RequestParams::getParamArray('data', $params, array(), $isNotReadRequest);
        $data->values['to_email'] = $email;
        $data->values['message_title'] = $messageTitle;
        $data->isFindDB = TRUE;

        $message = Helpers_View::getViewObject($data, new Model_Basic_LanguageObject(array(), '', 0),
            $viewObject, $sitePageData, $driver, $shopID);

        $files = $_FILES;

        if(!empty($email)) {
            if (!Mail::sendEMailHTML($sitePageData, $email, $messageTitle, $message, $files)) {
                throw new HTTP_Exception_500('Error message to e-mail: '.$email.'.');
            }
        }
    }

    /**
     * Сообщение о изменение данных о клиенте
     * @param $email
     * @param $shopID
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendUpdateShopClient($email, $shopID, $shopClientID, SitePageData $sitePageData,
                                                Model_Driver_DBBasicDriver $driver)
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_UPDATE_CLIENT]), 1
        );

        $view = '';
        if (count($shopEMailIDs->childs) == 1) {
            // получаем, какое сообщение отправить
            $modelEMail = new Model_Shop_EMail();
            $modelEMail->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
                return FALSE;
            }

            $view = $modelEMail->getText();
            if(empty($view)){
                return FALSE;
            }
            $title = $modelEMail->getName();
        }else{
            $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR.'client'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR.'update.php';
            if(file_exists($file)){
                $view = file_get_contents($file);
            }
            $title = '';
        }

        if (empty($view)) {
            return FALSE;
        }

        $message = View_EMail::getUpdateShopClient($shopID, $shopClientID, $view, $sitePageData, $driver, $title);
        if (empty($message)) {
            return FALSE;
        }

        if(Mail::sendEMailHTML($sitePageData, $email, $title, $message)){
            echo 'ok';
        }
        return TRUE;
    }

    /**
     * Сообщение о запросе рассылки от пользователя
     * @param $email
     * @param $shopID
     * @param $shopSubscribeID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendAddShopSubscribe($email, $shopID, $shopSubscribeID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_ADD_SUBSCRIBE]), 1
        );

        $view = '';
        if (count($shopEMailIDs->childs) == 1) {
            // получаем, какое сообщение отправить
            $modelEMail = new Model_Shop_EMail();
            $modelEMail->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
                return FALSE;
            }

            $view = $modelEMail->getText();
            if(empty($view)){
                return FALSE;
            }
            $title = $modelEMail->getName();
        }else{
            $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR.'subscribe-type'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR.'add-subscribe.php';
            if(file_exists($file)){
                $view = file_get_contents($file);
            }
            $title = '';
        }

        if (empty($view)) {
            return FALSE;
        }

        $message = View_EMail::getAddShopSubscribe($shopID, $shopSubscribeID, $view, $sitePageData, $driver, $title);
        if (empty($message)) {
            return FALSE;
        }

        if(Mail::sendEMailHTML($sitePageData, $email, $title, $message)){
            echo 'ok';
        }
        return TRUE;
    }

    /**
     * Сообщение о запросе от пользователя
     * @param $email
     * @param $shopID
     * @param $shopMessageID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendAddShopMessage($email, $shopID, $shopMessageID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_ADD_MESSAGE]), 1
        );

        // проверяем может на русском есть шаблон сообщения
        if ((count($shopEMailIDs->childs) < 1) && ($sitePageData->dataLanguageID != Model_Language::LANGUAGE_RUSSIAN)) {
            $tmp = $sitePageData->dataLanguageID;
            $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
            $shopEMailIDs = Request_Request::find(
                DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
                Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_ADD_MESSAGE]), 1
            );
            $sitePageData->dataLanguageID = $tmp;
        }

        $view = '';
        if (count($shopEMailIDs->childs) == 1) {
            // получаем, какое сообщение отправить
            $modelEMail = new Model_Shop_EMail();
            $modelEMail->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
                return FALSE;
            }

            $view = $modelEMail->getText();
            if(empty($view)){
                return FALSE;
            }
            $title = $modelEMail->getName();
        }else{
            $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR.'message'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR.'add.php';
            if(file_exists($file)){
                $view = file_get_contents($file);
            }else{
                $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR.'message'.DIRECTORY_SEPARATOR. Model_Language::LANGUAGE_RUSSIAN.DIRECTORY_SEPARATOR.'add.php';
                if(file_exists($file)){
                    $view = file_get_contents($file);
                }
            }
            $title = '';
        }

        if (empty($view)) {
            return FALSE;
        }

        $files = array();
        $message = View_EMail::getAddShopMessage($shopID, $shopMessageID, $view, $sitePageData, $driver, $title, $files);
        if (empty($message)) {
            return FALSE;
        }

        if(Mail::sendEMailHTML($sitePageData, $email, $title, $message, $files)){
            echo 'ok';
        }else {
            echo 'no';
        }
        return TRUE;
    }

    /**
     * Сообщение о восстановления пароля
     * @param $email
     * @param $shopID
     * @param $shopUserID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return bool
     */
    public static function sendRememberPasswordShopUserByEMail($email, $shopID, $shopUserID, SitePageData $sitePageData,
                                                               Model_Driver_DBBasicDriver $driver, array $params = array())
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_REMEMBER_PASSWORD_USER]), 1
        );

        if (count($shopEMailIDs->childs) < 1) {
            return FALSE;
        }

        // получаем, какое сообщение отправить
        $modelEMail = new Model_Shop_EMail();
        $modelEMail->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
            return FALSE;
        }

        $view = $modelEMail->getText();
        if(empty($view)){
            return FALSE;
        }
        $title = $modelEMail->getName();

        $message = View_EMail::getRememberPasswordShopUserByEMail($shopID, $shopUserID, $view, $sitePageData, $driver, $params);
        if (empty($message)) {
            return FALSE;
        }

        return Mail::sendEMailHTML($sitePageData, $email, $title, $message);
    }

    /**
     * Сообщение о восстановления пароля оператора
     * @param $email
     * @param $shopID
     * @param $shopOperationID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return bool
     */
    public static function sendRememberPasswordShopOperationByEMail($email, $shopID, $shopOperationID, SitePageData $sitePageData,
                                                               Model_Driver_DBBasicDriver $driver, array $params = array())
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_REMEMBER_PASSWORD_USER]), 1
        );

        if (count($shopEMailIDs->childs) < 1) {
            return FALSE;
        }

        // получаем, какое сообщение отправить
        $modelEMail = new Model_Shop_EMail();
        $modelEMail->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
            return FALSE;
        }

        $view = $modelEMail->getText();
        if(empty($view)){
            return FALSE;
        }
        $title = $modelEMail->getName();

        $message = View_EMail::getRememberPasswordShopOperationByEMail($shopID, $shopOperationID, $view, $sitePageData, $driver, $params);
        if (empty($message)) {
            return FALSE;
        }

        return Mail::sendEMailHTML($sitePageData, $email, $title, $message);
    }

    /**
     * Сообщение о создании пользователя
     * @param $email
     * @param $shopID
     * @param $shopUserID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @return bool
     */
    public static function sendCreateShopUser($email, $shopID, $shopUserID, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver, array $params = array())
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => Model_EMailType::EMAIL_TYPE_CREATE_USER]), 1
        );

        if (count($shopEMailIDs->childs) < 1) {
            return FALSE;
        }

        // получаем, какое сообщение отправить
        $modelEMail = new Model_Shop_EMail();
        $modelEMail->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
            return FALSE;
        }

        $view = $modelEMail->getText();
        if(empty($view)){
            return FALSE;
        }
        $title = $modelEMail->getName();

        $message = View_EMail::getCreateShopUser($shopID, $shopUserID, $view, $sitePageData, $driver, $params);
        if (empty($message)) {
            return FALSE;
        }

        try {
            return Mail::sendEMailHTML($sitePageData, $email, $title, $message);
        }catch (Exception $e){
            return FALSE;
        }
    }

    /**
     * Сообщение о создании/изменении заказа
     * @param $emailType
     * @param $email
     * @param $shopID
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    private static function _sendEditShopBill($emailType, $email, $shopID, $shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopEMailIDs = Request_Request::find(
            DB_Shop_EMail::NAME, $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(['email_type_id' => $emailType]), 1
        );

        $view = '';
        if (count($shopEMailIDs->childs) == 1) {
            // получаем, какое сообщение отправить
            $modelEMail = new Model_Shop_EMail();
            $modelEMail->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelEMail, $shopEMailIDs->childs[0]->id, $sitePageData, $sitePageData->shopMainID)) {
                return FALSE;
            }

            $view = $modelEMail->getText();
            if(empty($view)){
                return FALSE;
            }
            $title = $modelEMail->getName();
        }else{
            $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'email' . DIRECTORY_SEPARATOR.'bill'.DIRECTORY_SEPARATOR. $sitePageData->dataLanguageID.DIRECTORY_SEPARATOR.'edit-bill.php';
            if(file_exists($file)){
                $view = file_get_contents($file);
            }
            $title = '';
        }

        $message = View_EMail::getShopBill($shopID, $shopBillID, $view, $sitePageData, $driver);
        if (empty($message)) {
            return FALSE;
        }

        if(! empty($email)) {
            Mail::sendEMailHTML($sitePageData, $email, $title, $message);
        }

        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopBillID, $sitePageData, $shopID)){
            return FALSE;
        }
        $model->dbGetElements($sitePageData->shopMainID, array('shop_id', 'shop_root_id'));

        // отправляем письмо в магазин
        $emails = $model->getElement('shop_id')->getParamsArray(Model_Shop::PARAM_NAME_SEND_EMAIL_INFO);
        if(!empty($emails)){
            if (Mail::sendEMailHTML($sitePageData, $emails, $title, $message)){
                return FALSE;
            }
        }

        // отправляем письмо в магазин родителя
        if($model->getShopRootID() > 0) {
            $emails = $model->getElement('shop_root_id');
            if($emails !== NULL) {
                $emails = $emails->getParamsArray(Model_Shop::PARAM_NAME_SEND_EMAIL_INFO);
                if (!empty($emails)) {
                    Mail::sendEMailHTML($sitePageData, $emails, $title, $message);
                }
            }
        }

        return TRUE;
    }

    /**
     * Сообщение о создании заказа
     * @param $email
     * @param $shopID
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendCreateShopBill($email, $shopID, $shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        return self::_sendEditShopBill(Model_EMailType::EMAIL_TYPE_CREATE_BILL, $email, $shopID, $shopBillID, $sitePageData, $driver);
    }

    /**
     * Сообщение о изменении заказа
     * @param $email
     * @param $shopID
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function sendEditShopBill($email, $shopID, $shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        return self::_sendEditShopBill(Model_EMailType::EMAIL_TYPE_EDIT_BILL, $email, $shopID, $shopBillID, $sitePageData, $driver);
    }
}