<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_ShopExcel extends Controller_Ads_BasicAds {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
    }

    /** Клиенты в Excel **/
    public function action_clients() {
        $this->_sitePageData->url = '/ads/shopexcel/clients';
        set_time_limit(36000);

        $shopClientIDs = Request_Request::find('DB_Ads_Shop_Client', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 0, TRUE, array());

        $filePath = 'ads' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'clients';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $shopClientIDs->childs;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Список клиентов.xls"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Посылки в Excel **/
    public function action_parcels() {
        $this->_sitePageData->url = '/ads/shopexcel/parcels';
        set_time_limit(36000);

        $shopParcelIDs = Request_Request::find('DB_Ads_Shop_Parcel', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 0, TRUE, array('shop_client_id' => 'name', 'parcel_status_id' => 'name'));

        $filePath = 'ads' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'parcels';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->parcels = $shopParcelIDs->childs;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Список посылок.xls"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

}