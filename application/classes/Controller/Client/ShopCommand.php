<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_ShopCommand extends Controller_Client_BasicClient {

    public function action_get_image_captcha(){
        $this->_sitePageData->url = '/command/get_image_captcha';
        $this->_sitePageData->isIndexRobots = FALSE;
        Helpers_Captcha::getCaptchaImage();
    }

    /**
     * Добавляем контакты клиента объединяем по авторизованному пользователю, если
     * пользователь не авторизован, то создается новый пользователь
     * Даные клиента:
     * client[first_name], client[name] - имя клиента (не обязательно)
     * client[last_name] - фамилия клиента (не обязательно)
     * client[text] - примечание (не обязательно)
     * client[type] - вид клиента (обязательно)
     *
     * Вид в HTML
     * <input name="client[first_name]" value="">
     * <input name="client[name]" value="">
     * <input name="client[last_name]" value="">
     * <input name="client[text]" value="">
     * <input name="client[type]" value="">
     *
     * Данные контакта:
     * contact[name] - контакт (e-mail, телефон и т.д.)
     * contact[client_contact_type_id] - тип контакта Model_ClientContactType::CONTACT_TYPE_...
     * contact[text] - примечание (не обязательно)
     * shop_id - филиал (не обязательно)
     * url - куда перенаправить (не обязательно)
     *
     * Вид в HTML
     * <input name="contact[name]" value="">
     * <input name="contact[client_contact_type_id]" value="<?php echo Model_ClientContactType::CONTACT_TYPE_EMAIL; ?>">
     * <input name="contact[text]" value="">
     * <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
     * <input name="url" value="">
     */
    public function action_add_contact_client(){
        $this->_sitePageData->url = '/command/add_contact_client';
        $this->_sitePageData->isIndexRobots = FALSE;

        $shopID = intval(Request_RequestParams::getParamInt('shop_id'));
        if($shopID  < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $modelClient = new Model_Shop_Client();
        $modelClient->setDBDriver($this->_driverDB);

        $type = Request_RequestParams::getParamInt('client.type', array(), FALSE,
            $this->_sitePageData, TRUE);
        if ($this->_sitePageData->userID > 0){
            $params = Request_RequestParams::setParams(
                array(
                    'type' => $type,
                    'user_id' => $this->_sitePageData->userID,
                )
            );
            $ids = Request_Request::find('DB_Shop_Client', $shopID, $this->_sitePageData, $this->_driverDB, $params,
                1, TRUE);
            $ids->saveChildValuesInModel($modelClient);
        }

        if ($modelClient->id < 1) {
            $modelClient->shopID = $shopID;
            $modelClient->setShopTableCatalogID($type);
        }

        // получаем имя клиента
        $firstName = Request_RequestParams::getParamStr('client.first_name', array(), FALSE,
            NULL, TRUE);
        $name = Request_RequestParams::getParamStr('client.name', array(), FALSE,
            NULL, TRUE);
        if ((!empty($name)) || (!empty($firstName))) {
            $modelClient->setName(
                str_replace('  ', ' ',
                    trim($firstName. ' ' . $name)
                )
            );
        }

        Request_RequestParams::setParamStr('last_name', $modelClient, 'client.last_name');
        Request_RequestParams::setParamStr('text', $modelClient, 'client.text');

        $options = Request_RequestParams::getParamArray('client.options', array(), NULL, FALSE,
            NULL, TRUE);
        if($options !== NULL){
            $modelClient->addOptionsArray($options);
        }


        $model = new Model_Shop_Client_Contact();
        $model->setDBDriver($this->_driverDB);
        $model->shopID = $shopID;

        Request_RequestParams::setParamStr('name', $model, 'contact.name');
        Request_RequestParams::setParamInt('client_contact_type_id', $model, 'contact.client_contact_type_id');
        Request_RequestParams::setParamStr('text', $model, 'contact.text');

        $result = array();
        if ($model->validationFields($result)){
            if ($modelClient->id < 1) {
                Helpers_DB::saveDBObject($modelClient, $this->_sitePageData);
            }

            $model->setShopClientID($modelClient->id);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
            $result['values'] = $model->getValues();

            $modelClient->addContact($model->getName(), $model->getClientContactTypeID());
            Helpers_DB::saveDBObject($modelClient, $this->_sitePageData);

            Api_EMail::sendUpdateShopClient('', $shopID, $modelClient->id, $this->_sitePageData,
                $this->_driverDB);
        }else{
            throw new HTTP_Exception_500('Error: '.print_r($result, TRUE));
        }

        // перенаплавляем на получение списка
        $url = Request_RequestParams::getParamStr('url');
        if(! empty($url)) {
            $this->redirect($url);
        }
    }


    /**
     * Создание магазина и оператора
     */
    public function action_shopcreate()
    {
        $this->_sitePageData->url = '/command/shopcreate';

        $shop = Request_RequestParams::getParamArray('shop');
        if($shop === NULL){
            return FALSE;
        }

        $modelShop = new Model_Shop();
        $modelShop->setDBDriver($this->_driverDB);
        $modelShop->setName(Arr::path($shop, 'name', ''));
        $modelShop->setShopTableRubricID(intval(Arr::path($shop, 'shop_table_rubric_id', 0)));
        $modelShop->setShopTableCatalogID(intval(Arr::path($shop, 'shop_table_catalog_id', 0)));
        $modelShop->setMainShopID($this->_sitePageData->shopID);

        // временно для всех магазинов прибавляем 7 дней (для bigbuh.kz)
        $modelShop->setValidityAt(date('Y-m-d H:i:s', strtotime('+37 days')));

        if(Func::_empty($modelShop->getName())){
            throw new HTTP_Exception_500('Shop name empty.');
        }

        // ссылка на магазин реферал
        $referral = floatval(Arr::path($shop, 'referral', 0));
        if ($referral > 0){
            $modelShop->setReferralShopID($referral);
        }

        $tmp = Arr::path($shop, 'options', '');
        if(is_array($tmp)) {
            $modelShop->setOptions($tmp);
        }
        // проверяем магазин
        $result = array();
        if (! $modelShop->validationFields($result)){
            $this->redirect(
                Request_RequestParams::getParamStr('url') . URL::query(
                    array(
                        'system' =>
                            array(
                                'user_registration' => array(
                                    'error' => 1,
                                    'error_data' => $result,
                                    'values' => $modelShop->getValues(TRUE, TRUE, $this->_sitePageData->shopID)
                                )
                            )
                    ),
                    FALSE
                )
            );
        }

        $user = Request_RequestParams::getParamArray('user');
        if($user === NULL){
            return FALSE;
        }

        $modelOperation = new Model_Shop_Operation();
        $modelOperation->setDBDriver($this->_driverDB);
        $modelOperation->setEmail(Arr::path($user, 'email', ''));
        $modelOperation->setName(Arr::path($user, 'name', ''));
        $modelOperation->setPassword(Arr::path($user, 'password', ''));

        // проверяем существует ли данный оператор
        $operationID = Request_Shop_Operation::findIDByEMail(
            $modelOperation->getEmail(),$this->_sitePageData->shopID,  $this->_sitePageData, $this->_driverDB
        );
        if($operationID > 0) {
            $result = array();

            $s = str_replace(':field', 'E-mail', I18n::get(':field already exists'));
            $result['fields']['email'] = $s;
            $result['error_msg'] = trim(Arr::path($result, 'error_msg', '') . "\r\n" . $s);

            $this->redirect(
                Request_RequestParams::getParamStr('url') . URL::query(
                    array(
                        'system' =>
                            array(
                                'user_registration' => array(
                                    'error' => 1,
                                    'error_data' => $result,
                                    'values' => $modelOperation->getValues(TRUE, TRUE, $this->_sitePageData->shopID)
                                )
                            )
                    ),
                    FALSE
                )
            );
            return FALSE;
        }

        // находим или создаем пользователя в базе данных
        $userID = Request_User::getShopUserIDByEMail($modelOperation->getEmail(), $this->_driverDB);
        if($userID > 0) {
            $modelOperation->setUserID($userID);
        }else{
            $modelUser = new Model_User();
            $modelUser->setDBDriver($this->_driverDB);
            $modelUser->setEmail($modelOperation->getEMail());
            $modelUser->setName($modelOperation->getName());
            $modelUser->setPassword($modelOperation->getPassword());
            $modelUser->setOptionsArray($this->_getShopUserOptions($user, $modelUser->getOptionsArray()));

            $result = array();
            if (($modelUser->validationFields($result))){
                $modelUser->setPassword(Auth::instance()->hashPassword($modelUser->getPassword()));
                $modelUser->setEditUserID($this->_sitePageData->userID);

                $modelOperation->setUserID(Helpers_DB::saveDBObject($modelUser, $this->_sitePageData));
            } else {
                $this->redirect(
                    Request_RequestParams::getParamStr('url') . URL::query(
                        array(
                            'system' =>
                                array(
                                    'user_registration' => array(
                                        'error' => 1,
                                        'error_data' => $result,
                                        'values' => $modelUser->getValues(TRUE, TRUE, $this->_sitePageData->shopID)
                                    )
                                )
                        ),
                        FALSE
                    )
                );
            }
        }

        $modelShop->setEditUserID($this->_sitePageData->userID);
        $modelOperation->shopID =  Helpers_DB::saveDBObject($modelShop, $this->_sitePageData);

        $modelOperation->setPassword(Auth::instance()->hashPassword($modelOperation->getPassword()));
        $modelOperation->setEditUserID($this->_sitePageData->userID);
        Helpers_DB::saveDBObject($modelOperation, $this->_sitePageData, $modelOperation->shopID);

        $this->redirect(Request_RequestParams::getParamStr('redirect_url'));
    }

    /**
     * Добавляем коментарии
     * @throws HTTP_Exception_500
     */
    public function action_commentadd(){
        $this->_sitePageData->url = '/command/commentadd';
        $this->_sitePageData->isIndexRobots = FALSE;

        if(! Helpers_Captcha::checkCaptcha($this->_sitePageData, TRUE)){
            return FALSE;
        }

        $model = new Model_Shop_Comment();
        $model->setDBDriver($this->_driverDB);

        Request_RequestParams::setParamStr("name", $model);
        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("text", $model);
        Request_RequestParams::setParamInt("comment_type_id", $model);
        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);

        $type = Request_RequestParams::getParamInt('type');
        if($type !== NULL) {
            $modelType = new Model_Shop_Table_Catalog();
            $modelType->setDBDriver($this->_driverDB);

            if (! $this->getDBObject($modelType, $type)) {
                throw new HTTP_Exception_500('Comment type not found.');
            }

            $model->setShopTableCatalogID($type);

            $options = Request_RequestParams::getParamArray('options');
            if ($options !== NULL) {
                $fields = $modelType->getOptionsArray();
                $value = array();
                foreach($fields as $field){
                    $s = $field['field'];
                    if(key_exists($s, $options)){
                        $value[$s] = $options[$s];
                    }
                }
                $model->setOptionsArray($value);
            }
        }

        $shopID = intval(Request_RequestParams::getParamInt('branch_id'));
        if($shopID  < 1){
            $shopID = $this->_sitePageData->shopID;
        }
        $model->shopID = $shopID;

        $model->setUserID($this->_sitePageData->userID);
        if($this->_sitePageData->userID > 0) {
            if(!Func::_empty($this->_sitePageData->user->getName())) {
                $model->setUserName($this->_sitePageData->user->getName());
            }
            $model->setUrl($this->_sitePageData->user->getURL());
        }

        $result = array();
        if ($model->validationFields($result)){
            $model->setEditUserID($this->_sitePageData->userID);
            $model->setCreatedAt(date('Y-m-d H:i:s'));
            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            $filePath = Arr::path($_FILES, 'image', NULL);
            if ($filePath !== NULL) {
                $file = new Model_File($this->_sitePageData);
                $tmp = $file->addImage($filePath, $model->id, Model_Shop_Comment::TABLE_ID);
                if (!empty($tmp)) {
                    $model->setFileImage($tmp);
                    Helpers_DB::saveDBObject($model, $this->_sitePageData);

                    $result['values'] = $model->getValues();
                }
            }

            //  дополнительные фотографии
            $images = Arr::path($_FILES, 'images', NULL);
            if(($images !== NULL)) {
                if(key_exists('tmp_name', $images)){
                    $images = array(0 => $images);
                }

                $model->setFilesArray(
                    $file->addImages($images,
                        $model->id, Model_Shop_Comment::TABLE_ID));
                Helpers_DB::saveDBObject($model, $this->_sitePageData);
            }
            $result['values'] = $model->getValues();
        }

        // перенаплавляем на получение списка
        $url = Request_RequestParams::getParamStr('url');
        if(! empty($url)) {
            $this->redirect($url);
        }
    }

    /**
     * Добавляем вопрос / ответ
     * <input name="type" value="4142" style="display: none">
     * <input name="url" value="" style="display: none">
     */
    public function action_question_add(){
        $this->_sitePageData->url = '/command/question_add';

        if(! Helpers_Captcha::checkCaptcha($this->_sitePageData, TRUE)){
            throw new HTTP_Exception_500('Captcha not correct.');
        }

        $model = new Model_Shop_Question();
        $model->setDBDriver($this->_driverDB);

        Request_RequestParams::setParamStr("name", $model);
        Request_RequestParams::setParamStr('text', $model);

        $type = Request_RequestParams::getParamInt('type');
        if($type !== NULL) {
            $modelType = new Model_Shop_Table_Catalog();
            $modelType->setDBDriver($this->_driverDB);

            if (! $this->getDBObject($modelType, $type)) {
                throw new HTTP_Exception_500('Question type not found.');
            }

            $model->setShopTableCatalogID($type);

            $options = Request_RequestParams::getParamArray('options');
            if ($options !== NULL) {
                $fields = $modelType->getOptionsArray();
                $value = array();
                foreach($fields as $field){
                    $s = $field['field'];
                    if(key_exists($s, $options)){
                        $value[$s] = $options[$s];
                    }
                }
                $model->setOptionsArray($value);
            }
        }

        $shopID = intval(Request_RequestParams::getParamInt('branch_id'));
        if($shopID  < 1){
            $shopID = $this->_sitePageData->shopID;
        }
        $model->shopID = $shopID;

        $model->setCreateUserID($this->_sitePageData->userID);
        $model->setCreatedAt(date('Y-m-d H:i:s'));
        if($this->_sitePageData->userID > 0) {
            if(!Func::_empty($this->_sitePageData->user->getName())) {
                $model->setUserName($this->_sitePageData->user->getName());
            }
            $model->setUrl($this->_sitePageData->user->getURL());
        }

        $result = array();
        if ($model->validationFields($result)){
            $model->setEditUserID($this->_sitePageData->userID);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            $result['values'] = $model->getValues();
        }

        // перенаплавляем на получение списка
        $this->redirect(Request_RequestParams::getParamStr('url'));
    }

    /**
     * Добавляем в рассылку
     * От клиента:
     * email
     * type
     * branch_id
     * url - куда перенаправить
     */
    /**
     * Добавляем в рассылку
     * Даные клиента:
     * name - имя клиента (не обязательно)
     * email - E-mail (не обязательно)
     * text - примечание (не обязательно)
     *
     * Вид в HTML
     * <input name="name" value="">
     * <input name="email" value="">
     * <input name="text" value="">
     * <input name="type" value="" style="display:none">
     * <input name="is_not_captcha_hash" value="1" style="display:none">
     * <input name="url" value="" style="display:none">
     */
    public function action_subscribe_add(){
        $this->_sitePageData->url = '/command/subscribe_add';

        if(! Helpers_Captcha::checkCaptcha($this->_sitePageData, TRUE)){
            throw new HTTP_Exception_500('Captcha not correct.');
        }

        $model = new Model_Shop_Subscribe();
        $model->setDBDriver($this->_driverDB);

        Request_RequestParams::setParamStr("email", $model);
        Request_RequestParams::setParamStr("name", $model);
        $model->setShopTableCatalogID(Request_RequestParams::getParamInt('type'));

        $shopID = intval(Request_RequestParams::getParamInt('branch_id'));
        if($shopID  < 1){
            $shopID = $this->_sitePageData->shopID;
        }
        $model->shopID = $shopID;

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)){
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $shopID);

            $result['values'] = $model->getValues();

            // отправить сообщение на e-mail
            Api_EMail::sendAddShopSubscribe($model->getEMail(), $shopID, $model->id, $this->_sitePageData, $this->_driverDB);
        }else{
            throw new HTTP_Exception_500('Error query. '.print_r($result, TRUE));
        }

        // перенаплавляем на получение списка
        $url = Request_RequestParams::getParamStr('url');
        if(!empty($url)) {
            $this->redirect($url);
        }
    }

    /**
     * Добавляем сообщение
     * От клиента:
     * email
     * type
     * text
     * branch_id
     * url - куда перенаправить
     * <input name="type" value="" hidden>
     * <input name="url" value="" hidden>
     */
    public function action_message_add()
    {
        $this->_sitePageData->url = '/command/message_add';
        $this->_sitePageData->isIndexRobots = FALSE;

        if(! Helpers_Captcha::checkCaptcha($this->_sitePageData, FALSE)){
            throw new HTTP_Exception_500('Captcha not correct.');
        }

        $model = new Model_Shop_Message();
        $model->setDBDriver($this->_driverDB);

        $shopID = intval(Request_RequestParams::getParamInt('branch_id'));
        if ($shopID < 1) {
            $shopID = $this->_sitePageData->shopID;
        }
        $model->shopID = $shopID;

        Request_RequestParams::setParamStr("text", $model);

        $model->setName(trim(Request_RequestParams::getParamStr('last_name') . ' ' . Request_RequestParams::getParamStr('name')));

        $options = Request_RequestParams::getParamArray('options');
        $email = Arr::path($options, 'email', Request_RequestParams::getParamStr('email'));
        // временно не отправляем письма, которые не содержат e-mail
        if(empty($email)){
            return FALSE;
        }

        $phone = Arr::path($options, 'phone', '');
        // временно не отправляем письма, которые не содержат телефон
        if(empty($phone)){
            return FALSE;
        }
        $text = Request_RequestParams::getParamStr('text');
        // временно не отправляем письма, которые содержат ссылки
        if(
            (strpos($text, 'https://') !== FALSE)
            or (strpos($text, 'http://') !== FALSE)
            or (strpos($text, 'www.') !== FALSE)
        ){
            return FALSE;
        }

        if(! empty($email)){
            $model->setShopClientID(
                Api_Shop_Client::getShopClientIDByContact(
                    $shopID, $email, Model_ClientContactType::CONTACT_TYPE_EMAIL,
                    $this->_sitePageData, $this->_driverDB, TRUE, $model->getName()
                )
            );
        }

        // тип сообщения
        $type = Request_RequestParams::getParamInt('type');
        $modelType = new Model_Shop_Table_Catalog();
        $modelType->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelType, $type)) {
            throw new HTTP_Exception_500('Message type not found.');
        }

        $model->setShopTableCatalogID($type);

        $result = array();
        if ($model->validationFields($result)) {
            $file = new Model_File($this->_sitePageData, TRUE);

            // загружаем дополнительные поля
            $options = Request_RequestParams::getParamArray('options');
            $files = Helpers_Image::getChildrenFILES('options');
            if ((!empty($files)) && ($options === NULL)){
                $options = array();
            }
            foreach ($files as $key => $child) {
                if ($child['error'] == 0) {
                    $options[$key] = array(
                        'file' => $file->saveDownloadFilePath($child, $model->id, Model_Shop_Message::TABLE_ID, $this->_sitePageData),
                        'name' => $child['name'],
                        'size' => $child['size'],
                    );
                }
            }
            if ($options !== NULL) {
                $model->addOptionsArray($options);
            }

            // базовый чат создаем или используем уже созданны
            $modelChat = Api_Shop_Message_Chat::getShopMessageChatIDByClient(
                $shopID, $model->getShopClientID(),
                $this->_sitePageData, $this->_driverDB, TRUE
            );
            $modelChat->setName($model->getName());
            $modelChat->setText($model->getText());
            $modelChat->setOptions($model->getOptions());
            Helpers_DB::saveDBObject($modelChat, $this->_sitePageData, $shopID);

            $model->setShopMessageChatID($modelChat->id);
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $shopID);

            // отправить сообщение на e-mail
            Api_EMail::sendAddShopMessage('', $shopID, $model->id, $this->_sitePageData, $this->_driverDB);
        } else {
            throw new HTTP_Exception_500('Error: ' . print_r($result, TRUE));
        }

        // перенаплавляем на получение списка
        $url = Request_RequestParams::getParamStr('url');
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

    private function _getShopUserOptions(array $user, array $options){
        $arr = $user;
        if($arr === NULL){
            return $options;
        }

        if($this->_sitePageData->branchID > 0){
            $shopID = $this->_sitePageData->branchID;
        }else{
            $shopID = $this->_sitePageData->shopID;
        }

        foreach($arr as $key => $value){
            $options[$shopID][$key] = $value;
        }

        return $options;
    }

}
