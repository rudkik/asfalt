<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_BasicAds extends Controller_Ads_BasicShop
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'ads';
        $this->prefixView = 'ads';

        parent::__construct($request, $response);
    }

    public function _putInMain($file, $isMainNot = FALSE)
    {
        return parent::_putInMain($file, Request_RequestParams::getParamBoolean('is_main_not'));
    }

    /**
     * Возвращаем результать сохранения
     * @param array $result
     */
    protected function _redirectSaveResult(array $result, array $elements = array()){
        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            foreach ($elements as $key => $value){
                $model = $value['model'];

                $result['values'][$key] = '';
                $tmp = $result['values'][$value['id']];
                if ($tmp > 0){
                    if($this->getDBObject($model, $tmp)){
                        $result['values'][$key] = $model->getName();
                    }
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $params = array(
                'is_public_ignore' => TRUE,
            );
            foreach($result as $key => $value){
                if(!is_array($value)){
                    $params[$key] = $value;
                }
            }
            $params = URL::query($params, FALSE).$branchID;

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $params = 'edit'.$params;
            }else{
                $params = 'index'.$params;
            }

            $this->redirect('/'.$this->_sitePageData->actionURLName.'/'.$this->controllerName.'/'.$params);
        }
    }

    /**
     * Проверяем права доступа
     * @return  void
     */
    public function before()
    {
        parent::before();

        // каждую среду после 12:00 переносим посылки со склада в отправленные
        $currentTime = time();
        $newTime = date('Y-m-d');
        if((strftime('%u', $currentTime) == '3') && (strtotime($newTime . ' 12:00:00') < $currentTime)) {

            $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'action-time' . DIRECTORY_SEPARATOR;
            try {
                $time = file_get_contents($path . $this->_sitePageData->shopID . '_ads.txt');
            } catch (Exception $e) {
                $time = FALSE;
            }

            if ((!$time) || ($newTime != $time)) {
                Api_Ads_Shop_Parcel::setInStockToSend($this->_sitePageData, $this->_driverDB);
                file_put_contents($path . $this->_sitePageData->shopID . '_ads.txt', $newTime);
            }
        }
    }
}