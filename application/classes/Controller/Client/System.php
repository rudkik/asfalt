<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_System extends Controller_BasicControler
{
    /**
     * Получаем курс валют с Национальный Банк Республики Казахстан
     * Описание: https://data.egov.kz/datasets/view?index=valutalar_bagamdary4
     * Примечание: проверку SSL сертификать необходимо игнорировать (CURLOPT_SSL_VERIFYPEER => FALSE)
     */
    public function action_currency_kz(){
        $this->_sitePageData->url = '/system/currency_kz';

        $url = 'https://data.egov.kz/datasets/getdata?index=valutalar_bagamdary4&version=v524&page=1&count=20&text=#code#&column=id&order=ascending';

        $currencyIDs = Request_Currency::getCurrencyIDs($this->_sitePageData, $this->_driverDB);

        $model = new Model_Currency();
        $model->setDBDriver($this->_driverDB);
        foreach ($currencyIDs->childs as $child){
            if (Helpers_DB::getDBObject($model, $child->id, $this->_sitePageData)){
                $data = json_decode(
                    Helpers_URL::getDataURLEmulationBrowser(str_replace('#code#', $model->getCode(), $url)),
                TRUE
                );

                $model->setCurrencyRate(1 / Arr::path($data, 'elements.0.kurs', 1));
                Helpers_DB::saveDBObject($model, $this->_sitePageData);
            }
        }
    }

    public function action_client_passport(){
        $this->_sitePageData->url = '/system/client_passport';

        for ($i = 0; $i < 100; $i++){
            $ids = Request_LandToIP::findLandToIPIDs($this->_sitePageData, $this->_driverDB, array('ip_from_int' => 0, 'page' => $i), 5000);

            $model = new Model_LandToIP();
            $model->setDBDriver($this->_driverDB);
            foreach ($ids->childs as $child){
                $child->setModel($model);
                $model->setIPFrom($model->getIPFrom());
                $model->setIPTo($model->getIPTo());

                Helpers_DB::saveDBObject($model, $this->_sitePageData, 0);
            }
        }
    }

    public function action_get_ip()
    {
        echo Helpers_IP::getCountryIDByIP('2.100.100.100', $this->_sitePageData, $this->_driverDB);
    }


   public function action_send()
   {
       $d = '';
       Mail::sendEMailHTML($this->_sitePageData, 'naymushin.s@mail.ru', 'Заголовок', $d);
   }

    /**
     * Считаем рейтинг для магазина
     */
    public function action_setimages()
    {
        set_time_limit(3600000);
        $arr = Request_Request::find('DB_Shop_Image', 0, $this->_sitePageData, $this->_driverDB);

        $model = new Model_Shop_Good();
        $model->setDBDriver(GlobalData::newModelDriverDBSQLMem());

        foreach ($arr->childs as $value) {
            if (($value->values['table_name'] != 'ct_shop_goods') ||
                (empty($value->values['shop_object_language_ids']))
            ) {
                continue;
            }

            $objects = json_decode($value->values['shop_object_language_ids'], TRUE);
            if (!is_array($objects)) {
                continue;
            }
            foreach ($objects as $value2) {
                $id = $value2['id'];
                break;
            }
            $model->clear();
            $model->id = $id;

            foreach ($arr->childs as $value1) {
                if (($value1->values['table_name'] != 'ct_shop_goods') ||
                    (empty($value1->values['shop_object_language_ids']))
                ) {
                    continue;
                }

                $objects = json_decode($value1->values['shop_object_language_ids'], TRUE);
                if (is_array($objects)) {
                    foreach ($objects as $value2) {
                        if ($value2['id'] == $id) {
                            $ff = $model->getFilesArray();
                            $ff[] = array(
                                'title' => '',
                                'file' => str_replace('http://new.thermory.kz', '', str_replace('http://promo.parketmaster.kz', '', $value1->values['image_path'])),
                                'file_name' => $value1->values['file_name'],
                                'file_size' => $value1->values['file_size'],
                                'id' => $value1->id,
                                'type' => $value1->values['image_path'],
                                'options' => $value1->values['options'],
                                'w' => $value1->values['width'],
                                'h' => $value1->values['height'],
                            );

                            $model->setFilesArray($ff);

                            if (Func::_empty($model->getImagePath())) {
                                $model->setImagePath(str_replace('http://new.thermory.kz', '', str_replace('http://promo.parketmaster.kz', '', $value1->values['image_path'])));
                            }
                        }
                    }
                }
            }

            print_r($model->dbSave());
            file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'id.txt', $id."\r\n");
        }
    }

    /**
     * Запускаем и скидки
     */
    public function action_rundiscount()
    {
        $shopID = Request_RequestParams::getParamInt('shop_id');

        if ($shopID > 0) {
            Helpers_Discount::runShopDiscounts($shopID, $this->_sitePageData, $this->_driverDB);
        }
    }

    /**
     * Запускаем и акции
     */
    public function action_runaction()
    {
        $shopID = Request_RequestParams::getParamInt('shop_id');

        if ($shopID > 0) {
            Helpers_Action::runShopActions($shopID, $this->_sitePageData, $this->_driverDB);
        }
    }
}