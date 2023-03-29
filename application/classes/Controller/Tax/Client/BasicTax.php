<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_BasicTax extends Controller_Tax_Client_BasicList
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'tax';

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
}