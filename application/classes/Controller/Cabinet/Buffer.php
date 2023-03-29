<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Buffer extends Controller_Cabinet_File
{
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
    }

    public function action_set()
    {
        $this->_sitePageData->url = '/cabinet/buffer/set';

        // имя компьютера берем по IP
        $name = self::_getName();

        parse_str(urldecode(Request_RequestParams::getParamStr('data')), $data);
        $key = Request_RequestParams::getParamStr('key');

        $result = self::_getData($name);
        Arr::set_path($result, $this->_sitePageData->dataLanguageID. '.'.$key, $data);

        self::_setData($name, $result);
    }

    public function action_get()
    {
        $this->_sitePageData->url = '/cabinet/buffer/get';

        $key = Request_RequestParams::getParamStr('key');

        // имя компьютера берем по IP
        $name = self::_getName();
        $result = self::_getData($name);
        $data = Arr::path($result, $this->_sitePageData->dataLanguageID. '.'.$key, '');

        $this->response->body(json_encode($data));
    }

    /**
     * Получаем данные из буфера
     * @param $name
     * @return array|bool|mixed|string
     */
    private static function _getData($name)
    {
        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR .'buffer' .DIRECTORY_SEPARATOR . md5($name) . EXT;
        if (file_exists($path)) {
            $data = file_get_contents($path);
            try{
                $data = json_decode($data, TRUE);
                if (! is_array($data)) {
                    $data = array();
                }
            }catch(Exception $e) {
                $data = array();
            }
        } else {
            $data = array();
        }

        return $data;
    }

    /**
     * Записываем данные в буфер
     * @param $name
     * @param $data
     */
    private static function _setData($name, $data)
    {
        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR .'buffer' .DIRECTORY_SEPARATOR;
        Helpers_Path::createPath($path);
        $path .= md5($name) . EXT;

        $html = json_encode($data);
        for($i = 0; $i < 20; $i++){
            $html = $html. '                                 ';
        }

        $file = fopen($path, 'w');
        fwrite($file, $html);
        fclose($file);
    }

    /**
     * Получаем имя компьютера из буфера
     * @return int|string
     */
    private static function _getName(){
        $result = '';
        if(key_exists('HTTP_CLIENT_IP', $_SERVER)){
            $result = $result.$_SERVER['HTTP_CLIENT_IP'].'_';
        }
        if(key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
            $result = $result.$_SERVER['HTTP_X_FORWARDED_FOR'].'_';
        }
        if(key_exists('REMOTE_ADDR', $_SERVER)){
            $result = $result.$_SERVER['REMOTE_ADDR'].'_';
        }

        return $result;
    }

}
