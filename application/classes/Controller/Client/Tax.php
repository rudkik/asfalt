<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_Tax extends Controller_Client_BasicClient {

    /**
     * Восстановление пароля
     */
    public function action_forgot()
    {
        $this->_sitePageData->url = '/client-tax/forgot';

        $email = Request_RequestParams::getParamStr('email');

        // находим пользователя по email
        $userID = Request_Shop_Operation::findIDByEMail($email, -1, $this->_sitePageData, $this->_driverDB);

        if ($userID === NULL) {
            $this->redirect(Request_RequestParams::getParamStr('error_url') . URL::query(
                    array(
                        'system' =>
                            array(
                                'error' => 1,
                            )
                    ),
                    FALSE
                )
            );
        }

        // генерируем случайный пароль
        $password = Func::generatePassword();

        // сохраняем новый пароль
        $model = new Model_Shop_Operation();
        $model->setDBDriver($this->_driverDB);
        $model->__setArray(array('values' => $userID->values));
        $model->setPassword(Auth::instance()->hashPassword($password));
        Helpers_DB::saveDBObject($model, $this->_sitePageData, $userID->values['shop_id']);

        // отправка сообщения о воостановление пароля на почту
        Api_EMail::sendRememberPasswordShopOperationByEMail($email, $userID->values['shop_id'], $userID->id,
            $this->_sitePageData, $this->_driverDB, array('password' => $password));

        $url = Request_RequestParams::getParamStr('url');
        if($url !== NULL) {
            $this->redirect($url);
        }
    }
}
