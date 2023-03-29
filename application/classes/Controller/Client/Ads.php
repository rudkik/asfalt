<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_Ads extends Controller_Client_BasicShop {

    public function action_test()
    {
        $model = new Model_Ads_Shop_Parcel();
        Api_Ads_Shop_Parcel::sendShipitoKGAddParcel($model, $this->_sitePageData);
    }

    /**
     * Проверяем статус посылки на складе
     */
    public function action_check_status()
    {
        $this->_sitePageData->url = '/adsgs/check_status';

        $params = Request_RequestParams::setParams(
            array(
                'parcel_status_id' => Model_Ads_ParcelStatus::PARCEL_STATUS_AWAIT,
            )
        );
        $ids = Request_Request::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, $params, 0);

        $model = new Model_Ads_Shop_Parcel();
        $model->setDBDriver($this->_driverDB);
        foreach ($ids->childs as $child){
            if (Helpers_DB::getDBObject($model, $child->id, $this->_sitePageData)){
                Api_Ads_Shop_Parcel::sendShipitoKGAddParcel($model, $this->_sitePageData);
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'tracker' => '#',
            )
        );
        $ids = Request_Request::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, $params, 0);

        $model = new Model_Ads_Shop_Parcel();
        $model->setDBDriver($this->_driverDB);
        foreach ($ids->childs as $child){
            if (Helpers_DB::getDBObject($model, $child->id, $this->_sitePageData)){
                $model->setTracker(str_replace('#', '', $model->getTracker()));
                Helpers_DB::saveDBObject($model, $this->_sitePageData);
                Api_Ads_Shop_Parcel::sendShipitoKGAddParcel($model, $this->_sitePageData);
            }
        }


        $count = intval(Request_RequestParams::getParamInt('count')) + 1;
        if ($count > 100){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'parcel_status_id' => Model_Ads_ParcelStatus::PARCEL_STATUS_AWAIT,
                'warehouse_id_from' => 0,
            )
        );
        $ids = Request_Request::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, $params, 0);
        foreach ($ids->childs as $child){
            Api_Ads_Shop_Parcel::sendShipitoKGGetParcelStatus($child->id, $this->_sitePageData, $this->_driverDB);
        }
    }

    /**
     * Создание магазина и оператора
     */
    public function action_user_registration()
    {
        $this->_sitePageData->url = '/adsgs/user_registration';


        if(! Helpers_Captcha::checkCaptcha($this->_sitePageData)){
            $url = Request_RequestParams::getParamStr('error_url');
            if(!empty($url)){
                $this->redirect($url);
            }else{
                $this->response->body(
                    json_encode(
                        array(
                            'error' => TRUE,
                            'error_type' => 'captcha',
                        )
                    )
                );
                return FALSE;
            }
            exit;
        }

        $user = Request_RequestParams::getParamArray('user');
        if($user === NULL){
            return FALSE;
        }

        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);
        $model->setEmail(Arr::path($user, 'email', ''));
        $model->setName(trim(Arr::path($user, 'first_name', '') . ' '. Arr::path($user, 'last_name', '')));

        // генерируем случайный пароль
        $password = Func::generatePassword();
        $model->setPassword($password);

        // находим пользователя по email
        $userID = Request_User::getShopUserIDByEMail($model->getEmail(), $this->_driverDB);

        $result = array();
        if (($model->validationFields($result)) && ($userID == 0)){
            $model->setPassword(Auth::instance()->hashPassword($model->getPassword()));
            $model->setEditUserID($this->_sitePageData->userID);

            $modelClient = new Model_Ads_Shop_Client();
            $modelClient->setDBDriver($this->_driverDB);
            $modelClient->setUserID(Helpers_DB::saveDBObject($model, $this->_sitePageData));
            $modelClient->setFirstName(Arr::path($user, 'first_name', ''));
            $modelClient->setLastName(Arr::path($user, 'last_name', ''));
            $modelClient->setEmail($model->getEMail());

            $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'address_code\') as id;')->as_array(NULL, 'id')[0];
            $modelClient->setAddressCode($n);
            Helpers_DB::saveDBObject($modelClient, $this->_sitePageData);

            // отправка сообщения о регистрации пользователю на почту
            Api_EMail::sendCreateShopUser($model->getEmail(), $this->_sitePageData->shopID, $model->id,
                $this->_sitePageData, $this->_driverDB, array('password' => $password, 'address_code' => $n));

            $this->response->body(
                json_encode(
                    array(
                        'error' => FALSE,
                        'password' => $password,
                        'email' => $model->getEMail(),
                    )
                )
            );
        } else {
            $this->response->body(
                json_encode(
                    array(
                        'error' => TRUE,
                        'error_type' => 'email',
                    )
                )
            );
            return TRUE;
        }
    }

    /**
     * Добавление посылки
     */
    public function action_add_parcel()
    {
        $this->_sitePageData->url = '/adsgs/add_parcel';

        $result = Api_Ads_Shop_Parcel::add($this->_sitePageData, $this->_driverDB);

        $url = Request_RequestParams::getParamStr('url');
        if (!empty($url)){
            $this->redirect($url);
        }else{
            $this->response->body(json_encode($result));
        }
    }

    /**
     * Сохранение адреса посылки
     */
    public function action_save_parcel()
    {
        $this->_sitePageData->url = '/adsgs/save_parcel';

        $address = Request_RequestParams::getParamStr('address');
        if(empty($address)){
            throw new HTTP_Exception_500('Address not empty.');
        }

        $model = new Model_Ads_Shop_Parcel();
        $model->setDBDriver($this->_driverDB);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, -1, FALSE)) {
            throw new HTTP_Exception_500('Parcel not found.');
        }


        $model->setAddress($address);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);
    }

    /**
     * Сохранение данных клиента
     */
    public function action_save_client()
    {
        $this->_sitePageData->url = '/adsgs/save_client';

        $result = Api_Ads_Shop_Client::saveAuthUser($this->_sitePageData, $this->_driverDB);

        if ($result['is_filled']){
            $url = Request_RequestParams::getParamStr('url');
        }else{
            $url = Request_RequestParams::getParamStr('url_error');
        }

        if (!empty($url)){
            $this->redirect($url);
        }else{
            $this->response->body(json_encode($result));
        }
    }
}
