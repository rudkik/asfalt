<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopXML extends Controller_Magazine_Accounting_BasicMagazine {

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopxml/index';

        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_load_talons() {
        $this->_sitePageData->url = '/accounting/shopxml/load_talons';

        if(key_exists('file', $_FILES)) {
            foreach ($_FILES['file']['tmp_name'] as $fileName) {
                if(!file_exists($fileName)){
                    throw new HTTP_Exception_500('File not found. #170220');
                }
                Api_Magazine_Shop_Talon::loadXML($fileName, $this->_sitePageData, $this->_driverDB);
            }
        }

        self::redirect('/accounting/shopxml/index'.URL::query(array('msg' => 'Талоны загрузижены'), FALSE));
    }

    public function action_load_esf_products() {
        $this->_sitePageData->url = '/accounting/shopxml/load_esf_products';

        if(key_exists('file', $_FILES)) {
            foreach ($_FILES['file']['tmp_name'] as $fileName) {
                Api_Magazine_Shop_Product::loadESF($fileName, $this->_sitePageData, $this->_driverDB);
            }
        }
    }

    public function action_save_all() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_all';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_receives'] = $dateTo;
        $times['save_realizations'] = $dateTo;
        $times['save_write_offs'] = $dateTo;
        $times['save_returns'] = $dateTo;
        $times['save_move_outs'] = $dateTo;
        $times['save_move_ins'] = $dateTo;
        $times['save_realization_returns'] = $dateTo;
        $times['save_invoices'] = $dateTo;
        $times['save_return_invoices'] = $dateTo;
        $times['save_realization_workers'] = $dateTo;
        $times['save_talon_realizations'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);

        $data = Api_Magazine_Shop_Receive::saveXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_receive.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Realization::saveRealizationXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_realization.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Realization::saveWriteOffXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_write_off.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Return::saveXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_return.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Move::saveMoveExpenseXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_move_out.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Move::saveMoveComingXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_move_in.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Realization_Return::saveXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_realization_return.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Invoice::saveMainXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_invoice.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Invoice::saveReturnXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_return_invoice.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Realization::saveRealizationWorkerXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_realization_worker.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Talon::saveXML(
            Helpers_DateTime::getMonth($dateFrom), Helpers_DateTime::getYear($dateFrom),
            $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_talon_spent_old.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        $data = Api_Magazine_Shop_Realization::saveRealizationTalonXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );
        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_talon_spent.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_talon_realizations() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_talon_realizations';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_talon_realizations'] = $dateFrom;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Realization::saveRealizationTalonXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_talon_spent.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_return_invoices() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/return_invoices';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_return_invoices'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Invoice::saveReturnXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_return_invoice.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_invoices() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_invoices';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_invoices'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Invoice::saveMainXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_invoice.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_realization_workers() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_realization_workers';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_realization_workers'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Realization::saveRealizationWorkerXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_realization_worker.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_receives() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_receives';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_receives'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Receive::saveXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_receive.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_realizations() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_realizations';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_realizations'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Realization::saveRealizationXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_realization.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_realization_returns() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_realization_returns';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_realization_returns'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Realization_Return::saveXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_realization_return.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_write_offs() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_write_offs';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_write_offs'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Realization::saveWriteOffXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_write_off.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_returns() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_returns';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_returns'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Return::saveXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_return.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_move_outs() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_move_outs';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_move_outs'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Move::saveMoveExpenseXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_move_out.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_move_ins() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_move_ins';

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');

        // сохраняем время последней загрузки
        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        $times['save_move_ins'] = $dateTo;

        $file = fopen($options, 'w');
        fwrite($file, '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($times) . ';');
        fclose($file);

        $s = microtime(true);
        $data = Api_Magazine_Shop_Move::saveMoveComingXML(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, FALSE
        );

        $filepath = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'magazine_move_in.xml';
        $file = fopen($filepath, 'w');
        fwrite($file, $data);
        fclose($file);

        echo '<!--'.(microtime(true) - $s).'--!>';
        $this->_putInMain('/main/_shop/xml/index');
    }

    public function action_save_invoice_esf() {
        set_time_limit(36000);
        ini_set("max_execution_time", "36000");

        $this->_sitePageData->url = '/accounting/shopxml/save_invoice_esf';

        $id = Request_RequestParams::getParamInt('id');
        Api_Magazine_Shop_Invoice::saveEFSXML($id, $this->_sitePageData, $this->_driverDB, true);
    }
}