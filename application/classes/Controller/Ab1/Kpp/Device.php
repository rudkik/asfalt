<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Kpp_Device extends Controller_BasicControler {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Worker_Passage';
        $this->controllerName = 'shopworkerpassage';
        $this->tableID = Model_Ab1_Shop_Worker_Passage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Worker_Passage::TABLE_NAME;
        $this->objectName = 'workerpassage';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
    }

    public function action_command_z5rweb()
    {
        $this->_sitePageData->url = '/kpp/device/command_z5rweb';

        $request = Request_RequestParams::getParamStr('cmd');
        $message = json_decode($request, true);
        if(!empty($message)){
            $result = Drivers_IronLogic_Z5RWeb::requestMessage($message, $this->_sitePageData, $this->_driverDB);
        }else{
            $result = [];
        }
        $result = json_encode($result);

        $this->response->body($result);
    }

    public function action_z5rweb()
    {
        $this->_sitePageData->url = '/kpp/device/z5rweb';

        $request = $this->request->body();
        if(empty($request)){
            $request = '{"type":"Z5RWEB","sn":46263,"messages":[{"id":478307629,"operation":"power_on","fw":"3.24","conn_fw":"1.0.153","active":0,"mode":0,"controller_ip":"192.168.10.1","reader_protocol":"wiegand"}]}';
            //$request = '{"type":"Z5RWEB","sn":46263,"messages":[{"id":1943410399,"operation":"events","events":[{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:27","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:28","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:29","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:31","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:32","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:33","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:34","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:35","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:37","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:37","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:39","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:39","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:40","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:42","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:43","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:44","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:45","card": "000000000000"},{"flag": 1291,"event": 39,"time": "2021-01-07 15:06:46","card": "000000000000"},{"flag": 1025,"event": 39,"time": "2021-01-07 15:06:47","card": "000000000000"}]}]}';
            //$request = '{"type":"Z5RWEB","sn":46263,"messages":[{"id":424238335,"operation":"check_access","card":"0000008D5722","reader":1}]}';
            $request = '{"type":"Z5RWEB","sn":46263,"messages":[{"id":1315209188,"operation":"check_access","card":"00000069F69E","reader":1},{"id":235649157,"operation":"ping","active":1,"mode":0}]}';
        }
        //file_put_contents(APPPATH . 'device.txt', 'Запрос:' . $request."\r\n", FILE_APPEND);

        $result = Helpers_URL::getDataURLEmulationBrowser($this->_sitePageData->urlBasic . '/kpp/device/command_z5rweb' . URL::query(), 5, ['cmd' => $request]);

        $b = mb_strpos($result, '{');
        $e = mb_strrpos($result, '}');
        if($b !== false && $e !== false){
            $result = str_replace('﻿{', '{', $result);
            $result = '{' . mb_substr($result, $b, $e - $b). '}';
        }

        //file_put_contents(APPPATH . 'device.txt', 'Ответ:' .  $result ."\r\n", FILE_APPEND);

        $this->response->body($result);
    }
}
