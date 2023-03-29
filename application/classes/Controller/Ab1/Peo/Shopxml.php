<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopXML extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopxml';
        $this->objectName = 'xml';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shopxml/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_load_client_txt()
    {
        $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR;
        foreach (glob($filePath . '*.txt') as $file) {
            try {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'_'.random_int(1,100000).'.txt';
                rename($file, $new);
                Api_Ab1_Shop_Client::loadXMLOne($new, $this->_sitePageData, $this->_driverDB);
                //unlink($new);
            }catch (Exception $e){}
        }
    }

    public function action_load_1s()
    {
        $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR;
        print_r(glob($filePath . '*.xml'));
        foreach (glob($filePath . '*.xml') as $file) {
            $info = pathinfo($file);
            $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'_'.random_int(1,100000).'.txt';
            rename($file, $new);
            Api_Ab1_Shop_Client::loadXMLOne($new, $this->_sitePageData, $this->_driverDB);
            //unlink($new);
        }
    }

    public function action_load_act_revise() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/peo/shopxml/load_act_revise';

        $s = microtime(true);
        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Ab1_Shop_Act_Revise::loadXML($_FILES['file']['tmp_name'], $this->_sitePageData, $this->_driverDB);
        }else{
            $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'iz1S'.DIRECTORY_SEPARATOR;
            foreach (glob($filePath . 'AutoRate*.xml') as $file) {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'.txt';
                rename($file, $new);
                Api_Ab1_Shop_Act_Revise::loadXML($new, $this->_sitePageData, $this->_driverDB);
            }
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_loaddelivery() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/peo/shopxml/loaddelivery';

        $s = microtime(true);
        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Ab1_Shop_Delivery::loadXML($_FILES['file']['tmp_name'], $this->_sitePageData, $this->_driverDB);
        }else{
            $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'iz1S'.DIRECTORY_SEPARATOR;
            foreach (glob($filePath . 'AutoRate*.xml') as $file) {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'.txt';
                rename($file, $new);
                Api_Ab1_Shop_Delivery::loadXML($new, $this->_sitePageData, $this->_driverDB);
            }
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_loadproduct() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/peo/shopxml/loadproduct';

        $s = microtime(true);
        if(key_exists('file', $_FILES)) {
            if(is_array($_FILES['file']['tmp_name'])){
                $files = $_FILES['file']['tmp_name'];
            }else{
                $files = array($_FILES['file']['tmp_name']);
            }

            foreach ($files as $file){
                if(file_exists($file)) {
                    Api_Ab1_Shop_Product::loadXML(
                        $file, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamDate('date')
                    );
                }
            }
        }else{
            $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'iz1S'.DIRECTORY_SEPARATOR;
            foreach (glob($filePath . 'tovar*.xml') as $file) {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'.txt';
                rename($file, $new);
                Api_Ab1_Shop_Product::loadXML(
                    $new, $this->_sitePageData, $this->_driverDB, Request_RequestParams::getParamDate('date')
                );
            }
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_loadclient() {
       /* set_time_limit(36000);
        ini_set("max_execution_time", "36000");*/

        $this->_sitePageData->url = '/peo/shopxml/loadclient';

        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $s = microtime(true);
        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Ab1_Shop_Client::loadXMLALL($_FILES['file']['tmp_name'], $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::getParamBoolean('is_clear_block_amount'));
        }else{
            $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'iz1S'.DIRECTORY_SEPARATOR;
            foreach (glob($filePath . 'Kontragent*.xml') as $file) {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'.txt';
                rename($file, $new);
                Api_Ab1_Shop_Client::loadXMLALL($new, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::getParamBoolean('is_clear_block_amount'));
            }
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_loadmoveclient() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/peo/shopxml/loadmoveclient';

        $s = microtime(true);
        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Ab1_Shop_Move_Client::loadXML($_FILES['file']['tmp_name'], $this->_sitePageData, $this->_driverDB,
                TRUE);
        }else{
            $filePath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'iz1S'.DIRECTORY_SEPARATOR;
            foreach (glob($filePath . 'Development*.xml') as $file) {
                $info = pathinfo($file);
                $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'.txt';;
                rename($file, $new);
                Api_Ab1_Shop_Move_Client::loadXMLALL($new, $this->_sitePageData, $this->_driverDB);
            }
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->_putInMain('/main/_shop/xml/index');
    }
}
