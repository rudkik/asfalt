<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_SvetKZ extends Controller_BasicControler {
    // шаг список ссылок на продукцию рубрики
    const STEP_PRODUCT_RUBRIC = 1;

    /**
     * Запускае разные потоки для считывания ссылок на товары, каждую рубрику в отдельной потоке
     */
    public function action_load_rubrics() {
        $this->_sitePageData->url = '/smg/svetkz/load_rubrics';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');


        $data = Helpers_URL::getPageHTMLRandomProxy(
            Drivers_ParserSite_SvetKZ::URL_RUBRICS, Helpers_Path::getFilesProxies()
        );
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        preg_match_all('/<div class="left-menu-list-item-content">[\S\s]*<a href="(.+)" class="left-menu-list-item__link icon3-/U', $data, $result);
        if (count($result) < 2) {
            echo 'Ошибка распознания рубрик';
            return;
        }

        foreach($result[1] as $url) {
            $url = $this->_sitePageData->urlBasic . '/smg/svetkz/load_rubric' . URL::query(
                [
                    'rubric' => 'https://svet.kz' . $url,
                    'shop_branch_id' => $this->_sitePageData->shopID,
                    'shop_supplier_id' => $shopSupplierID,
                ]
            );
            $result = Helpers_URL::getDataURLEmulationBrowser($url,2);

            echo 'Запущен поток url: ' . $url . '<br>' . "\r\n";

            if(!empty($result)){
                echo $result.'<br>';
            }
        }

        echo 'Конец';
    }

    /**
     * Загружаем список ссылок на продукции рубрики, результат записываем в базу данных
     */
    public function action_load_rubric() {
        $this->_sitePageData->url = '/smg/svetkz/load_rubric';
        $microtime = microtime(true);

        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');
        $rubric = Request_RequestParams::getParamStr('rubric');

        $urls = Drivers_ParserSite_SvetKZ::getProductURLsByRubric(
            $rubric,  Helpers_Path::getFilesProxies()
        );

        $model = Request_Request::findOneModel(
            DB_AutoPart_Shop_Supplier_Parser::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_supplier_id' => $shopSupplierID,
                    'step' => self::STEP_PRODUCT_RUBRIC,
                    'name_full' => $rubric,
                ]
            )
        );

        if($model === false){
            $model = new Model_AutoPart_Shop_Supplier_Parser();
            $model->setDBDriver($this->_driverDB);

            $model->setStep(self::STEP_PRODUCT_RUBRIC);
            $model->setShopSupplierID($shopSupplierID);
            $model->setName($rubric);
        }

        $model->setOptionsArray($urls);
        $model->setQuantity(count($urls));
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        echo Helpers_DateTime::secondToTime((microtime(true) - $microtime)) . '<br>';
        echo 'Конец';
    }

    /**
     * Загружаем список ссылок на продукции рубрики, результат записываем в базу данных
     */
    public function action_load_rubrics_products() {
        $this->_sitePageData->url = '/smg/svetkz/load_rubrics_products';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');

        $params = [
            'shop_supplier_id' => $shopSupplierID,
        ];
        $shopSupplierParserIDs = Request_Request::find(
            DB_AutoPart_Shop_Supplier_Parser::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        foreach ($shopSupplierParserIDs->childs as $child) {
            $url = $this->_sitePageData->urlBasic . '/smg/svetkz/load_rubric_products' . URL::query(
                    [
                        'shop_supplier_parser_id' => $child->id,
                        'shop_branch_id' => $this->_sitePageData->shopID,
                        'shop_supplier_id' => $shopSupplierID,
                    ]
                );
            $result = Helpers_URL::getDataURLEmulationBrowser($url,2);

            echo 'Запущен поток url: ' . $url . '<br>' . "\r\n";

            if(!empty($result)){
                echo $result.'<br>';
            }
        }

        echo 'Конец';
    }

    /**
     * Загружаем список ссылок на продукции рубрики, результат записываем в базу данных
     */
    public function action_load_rubric_products() {
        $this->_sitePageData->url = '/smg/svetkz/load_rubric_products';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $this->_sitePageData->shopID = Request_RequestParams::getParamInt('shop_branch_id');
        $shopSupplierID = Request_RequestParams::getParamInt('shop_supplier_id');
        $shopSupplierParserID = Request_RequestParams::getParamInt('shop_supplier_parser_id');

        $modelParser = new Model_AutoPart_Shop_Supplier_Parser();
        $modelParser->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelParser, $shopSupplierParserID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Supplier parser not found.');
        }
        $offers = $modelParser->getOptionsArray();

        $params = [
            'shop_supplier_id' => $shopSupplierID,
            'shop_supplier_parser_id' => $shopSupplierParserID,
            'is_public_ignore' => true,
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        $fileProxies =  Helpers_Path::getFilesProxies();
        foreach ($shopProductIDs->childs as $child) {
            $child->setModel($model);

            $key = '';
            foreach ($model->getIntegrationsArray() as $integration) {
                if (key_exists($integration, $offers)) {
                    $key = $integration;
                    break;
                }
            }

            $model->setIsPublic(!empty($key));
            if($model->getIsPublic()){
                $url = $offers[$key];

                // считываем параметры товара
                Drivers_ParserSite_SvetKZ::loadProduct($url, $model, $this->_sitePageData,  $this->_driverDB, $fileProxies, false);

                if(Func::_empty($model->getURL())) {
                    $model->setURL($url);
                }

                unset($offers[$key]);
            }

            $model->setShopSupplierParserID($shopSupplierParserID);
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        foreach ($offers as $key => $url) {
            $model->clear();

            // считываем параметры товара
            Drivers_ParserSite_SvetKZ::loadProduct($url, $model, $this->_sitePageData, $this->_driverDB, $fileProxies, false);

            $model->addIntegration($key);

            if($model->getPriceCost() < 2000){
                continue;
            }

            $model->setURL($url);
            $model->setShopSupplierID($shopSupplierID);
            $model->setShopSupplierParserID($shopSupplierParserID);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            $model->setArticle('I'.$model->id);
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $this->_sitePageData->shopID);
        }
    }

    public function isAccess(){}
}