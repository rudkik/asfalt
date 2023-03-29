<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Shopuser extends Controller_Cabinet_BasicCabinet {
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_User';
        $this->controllerName = 'shopuser';
        $this->tableID = Model_User::TABLE_ID;
        $this->tableName = Model_User::TABLE_NAME;
        $this->objectName = 'user';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function before() {
        switch(strtolower($this->request->action())) {
            case 'index':
            case 'new':
            case 'edit':
            case 'save':
            case 'del':
                parent::before();
            default:
            $this->_sitePageData->shopShablonPath = 'cabinet';
            // данные о языке
            $this->_readLanguageInterface();
        }
    }

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shopuser/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopusers/index',
                'view::user_type',
            )
        );

        // получаем товары
        $model = new Model_Shop_Table_Catalog();
        $model->setDBDriver($this->_driverDB);
        if(! $this->getDBObject($model, Request_RequestParams::getParamInt('type'), $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_404('Shop user catalog not is found!');
        }
        $this->_sitePageData->replaceDatas['view::user_type'] = Func::mb_strtoupper($model->getName());

        // получаем список
        View_View::find('DB_ShopUser', $this->_sitePageData->shopID,
            "shopusers/index", "shopuser/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/shopuser/index');
    }

    public function action_new(){
        $this->_sitePageData->url = '/cabinet/shopuser/new';

        $typeID = Request_RequestParams::getParamInt('type');

        // получаем товары
        $modelUserCatalog = new Model_Shop_Table_Catalog();
        $modelUserCatalog->setDBDriver($this->_driverDB);
        if(! $this->getDBObject($modelUserCatalog, $typeID, $this->_sitePageData->shopMainID, $this->_sitePageData->languageID)){
            throw new HTTP_Exception_404('Shop user catalog not is found!');
        }
        $this->_sitePageData->replaceDatas['view::user_type'] = Func::mb_strtoupper($modelUserCatalog->getName());


        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopuser/new',
                'view::user_type',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $typeID,
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        // дополнительные поля
        Arr::set_path($dataID->values, '$elements$.shop_user_catalog_id.options', $modelUserCatalog->getOptionsArray());
        $dataID->isFindDB = TRUE;

        $model = new Model_User();
        $datas = Helpers_View::getViewObject($dataID, $model,
            'shopuser/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::shopuser/new'] = $datas;

        $this->_putInMain('/main/shopuser/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopuser/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('User not is found!');
        }else {
            $model = new Model_User();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('User not is found!');
            }
        }

        $typeID = $model->getShopUserCatalogID($this->_sitePageData->shopID);

        // получаем товары
        $modelUserCatalog = new Model_Shop_Table_Catalog();
        $modelUserCatalog->setDBDriver($this->_driverDB);
        if (! $this->getDBObject($modelUserCatalog, $typeID, $this->_sitePageData->shopMainID, $this->_sitePageData->languageID)) {
            throw new HTTP_Exception_404('Shop user catalog not is found!');
        }
        $this->_sitePageData->replaceDatas['view::user_type'] = Func::mb_strtoupper($modelUserCatalog->getName());

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopuser/edit',
                'view::user_type',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $typeID,
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        View_View::findOne('DB_ShopUser', $this->_sitePageData->shopID, "shopuser/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/shopuser/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopuser/save';

        $model = new Model_User();

        $id = Request_RequestParams::getParamInt('id');
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_500('User not found.');
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('email', $model);

        $tmp = Request_RequestParams::getParamStr('password');
        if (($tmp !== NULL) && (! empty($tmp))){
            $model->setPassword(Auth::instance()->hashPassword($tmp));
        }

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->setOptionsArray($options, $this->_sitePageData->shopID);
        }

        if ($model->id < 1) {
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopUserCatalogID($type, $this->_sitePageData->shopID);
        }else{
            $type = $model->getShopUserCatalogID($this->_sitePageData->shopID);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $model->setEditUserID($this->_sitePageData->userID);
            if($model->id < 1) {
                $this->saveDBObject($model);
            }

            $file = new Model_File($this->_sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $this->_sitePageData, $this->_driverDB);

            $this->saveDBObject($model);
            $result['values'] = $model->getValues();
        }

        if (Request_RequestParams::getParamBoolean('json') || $result['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }
            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cabinet/shopuser/edit?is_main=1&id='.$model->id.'&type='.$type.$branchID);
            }else{
                $this->redirect('/cabinet/shopuser/index?is_main=1&type='.$type.'&shop_user_id='.$model->id.$branchID);
            }
        }
    }

    public function action_auth() {
        $this->_sitePageData->url = '/cabinet/shopuser/auth';

        $tmp = Request_RequestParams::getParamInt('s');
        if ($tmp !== NULL) {
            $this->_sitePageData->urlParams['s'] = $tmp;
        }

        // генерируем основную часть
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/login');
        $view->data = array();
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);
        $this->response->body($result);
    }

    public function action_login() {
        $this->_sitePageData->url = '/cabinet/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('cabinet');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/cabinet/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            $this->redirect('/cabinet/shop/edit');
        }
    }

    public function action_registration() {
        $session = Session::instance();
        $session_data =& $session->as_array();

        $this->_sitePageData->url = '/cabinet/shopuser/registration';

        // считываем нужные параметы
        $this->_setRequestUrlParams(array('number_shop', 'ok', 'user', 'email', 'name'));

        $tmp = Request_RequestParams::getParamInt('error');
        if ($tmp === 1) {
            $this->_sitePageData->urlParams['error'] = Arr::path($session_data, 'error');
        }

        // генерируем основную часть
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/main/shopuser-registration');
        $view->data = array();
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);

        // получаем список ID языков
        $LanguageIDs = Request_Request::findAllNotShop(DB_Language::NAME, $this->_sitePageData, $this->_driverDB);

        $model = new Model_Language();
        $model->setDBDriver($this->_driverDB);
        $Languages = $this->getViewObjects($LanguageIDs, $model, "languages", "language");

        // добавляем хидр и футер
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/index');
        $view->data = array();
        $view->data['view::main'] = $result;
        $view->data['view::languages'] = $Languages;
        $view->data['view::phones'] = '';
        $view->data['shop_name'] = '';
        $view->siteData = $this->_sitePageData;
        $view->data['is_not_load_menu'] = TRUE;
        $this->response->body(Helpers_View::viewToStr($view));
    }

    public function action_add() {
        $session = Session::instance();
        $session_data =& $session->as_array();

        $this->_sitePageData->url = '/cabinet/shopuser/add';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');
        $numberShop = Request_RequestParams::getParamStr('number_shop');
        $name = Request_RequestParams::getParamStr('name');

        if (empty($numberShop)) {
            $this->redirect('/cabinet/shopuser/registration?number_shop=1&email=' . $email . '&number_shop=' . $numberShop . '&name=' . $name);
        }

        $shopID = Request_Shop::getShopIDByNumber($this->_sitePageData, $numberShop, $this->_driverDB);
        if ($shopID < 1) {
            $this->redirect('/cabinet/shopuser/registration?number_shop=1&email=' . $email . '&number_shop=' . $numberShop . '&name=' . $name);
        }

        // проверяем зарегистрирован ли пользователь
        $userID = Request_User::getShopUserID($email, $password, $this->_sitePageData, $this->_driverDB);
        if ($userID > 0) {
            $this->redirect('/cabinet/shopuser/registration?user=1&email=' . $email . '&number_shop=' . $numberShop . '&name=' . $name);
        }

        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);

        $model->setEmail($email);
        $model->setPassword($password);
        $model->setName($name);

        $result = array();
        if ($model->validationFields($result)) {
            $model->setPassword(Auth::instance()->hashPassword($model->getPassword()));
            $model->setEditUserID($this->_sitePageData->userID);
            $this->saveDBObject($model);

            $result['values'] = $model->getValues();
        } else {
            $session_data['error'] = $result;
            $this->redirect('/cabinet/shopuser/registration?error=1&email=' . $email . '&number_shop=' . $numberShop . '&name=' . $name);
        }

        $this->redirect('/cabinet/shopuser/registration?ok=1');
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('cabinet');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/cabinet");
    }

    public function action_resetpassword() {
        $this->_sitePageData->url = '/cabinet/shopuser/resetpassword';

        $email = Request_RequestParams::getParamStr('email');

        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);

        if (!$model->getEmail() != $email) {
            throw new HTTP_Exception_404('E-mail is not found.');
        }

        if (mail(!$email, 'Reset password', 'OTO Cabinet')) {
            throw new HTTP_Exception_404('E-mail is not sent!');
        }

        echo 'Новый пароль выслан на Вашу почту';
        //        $this->redirect('/cabinet/shopuser/resetpassword');
    }
}
