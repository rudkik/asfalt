<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopXML extends Controller_Ab1_Sales_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopxml';
        $this->objectName = 'xml';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sales/shopxml/index';

        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_sitePageData->replaceDatas['view::date'] = Arr::path($times, 'save_invoices', '');

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_all() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/sales/shopxml/save_all';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        if($dateFrom == null){
            $dateFrom = Arr::path($times, 'save_invoices', null);
        }
        $times['save_invoices'] = date('Y-m-d H:i:s');

        $s = microtime(true);

        // наклданые
        $data = Api_Ab1_Shop_Invoice::saveXML($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE);
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'realization.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        // акты сверки
        $data = Api_Ab1_Shop_Act_Service::saveXML($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE);
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'act_services.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        // сохраняем время до
        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';

        self::redirect('/sales/shopxml/index');
    }

    public function action_save_invoices() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/sales/shopxml/save_invoices';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $s = microtime(true);
        $data = Api_Ab1_Shop_Invoice::saveXML($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE);

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'realization.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        self::redirect('/sales/shopxml/index');
    }

    public function action_save_act_services() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/sales/shopxml/save_act_services';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        $s = microtime(true);
        $data = Api_Ab1_Shop_Act_Service::saveXML($dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE);

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'act_services.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        self::redirect('/sales/shopxml/index');
    }

    public function action_load_act_revises()
    {
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR . 'act_revise'.DIRECTORY_SEPARATOR;
        print_r(glob($filepath . '*.xml'));
        foreach (glob($filepath . '*.xml') as $file) {
            $info = pathinfo($file);
            $new = $info['dirname'].DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.$info['filename'].'_'.random_int(1,100000).'.txt';
            rename($file, $new);
            Api_Ab1_Shop_Act_Revise::loadXML($new, $this->_sitePageData, $this->_driverDB);
            //unlink($new);
        }
    }

}
