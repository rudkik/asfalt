<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_BasicHotel extends Controller_Hotel_BasicList
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'hotel';

        parent::__construct($request, $response);
    }

    public function _putInMain($file, $isMainNot = FALSE)
    {
        return parent::_putInMain($file, Request_RequestParams::getParamBoolean('is_main_not'));
    }

    /**
     * Возвращаем результать сохранения
     * @param array $result
     * @param array $elements
     */
    protected function _redirectSaveResult(array $result, array $elements = array()){
        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            foreach ($elements as $key => $value){
                $model = $value['model'];

                $result['values'][$key] = '';
                $tmp = Arr::path($result['values'], $value['id'], 0);
                if ($tmp > 0){
                    if($this->getDBObject($model, $tmp)){
                        $result['values'][$key] = $model->getValue(Arr::path($value, 'field', 'name'));
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

        return TRUE;
        // каждые 5 минут удаляем брони
        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'action-time'. DIRECTORY_SEPARATOR;
        try {
            $time = file_get_contents($path.$this->_sitePageData->shopID.'_hotel.txt');
        }catch(Exception $e){
            $time = FALSE;
        }

        $newTime = time();
        if((! $time) || ($newTime - strtotime($time) > 5 * 60)) {
            //Api_Hotel_Shop_Bill::deleteRevise($this->_sitePageData, $this->_driverDB);
            file_put_contents($path.$this->_sitePageData->shopID.'_hotel.txt', date('Y-m-d H:i:s', $newTime));
        }
    }
}