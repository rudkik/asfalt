<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopXML extends Controller_Ab1_Bookkeeping_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopxml';
        $this->objectName = 'xml';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shopxml/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
            )
        );

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_invoices() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/bookkeeping/shopxml/save_invoices';

        $date = Request_RequestParams::getParamDateTime('date');

        $s = microtime(true);
        $data = Api_Ab1_Shop_Invoice::saveXML($date, $this->_sitePageData, $this->_driverDB, FALSE);

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'invoices.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_act_services() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/bookkeeping/shopxml/save_act_services';

        $date = Request_RequestParams::getParamDateTime('date');

        $s = microtime(true);
        $data = Api_Ab1_Shop_Act_Service::saveXML($date, $this->_sitePageData, $this->_driverDB, FALSE);

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'act_services.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }
}
