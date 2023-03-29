<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopProduct extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_AutoPart_Shop_Product::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/market/shopproduct/index';

        $this->_requestListDB('DB_AutoPart_Shop_Rubric');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Product_Status');

        parent::_actionIndex(
            array(
                'shop_rubric_id' => array('name'),
                'shop_brand_id' => array('name'),
                'shop_supplier_id' => array('name'),
                'shop_product_status_id' => array('name'),
                'root_shop_product_id' => array('article'),
            )
        );
    }

    public function action_work() {
        $this->_sitePageData->url = '/market/shopproduct/work';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Rubric');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Product_Status');

        $params = [
            'limit_page' => 25,
            'limit' => intval(Request_RequestParams::getParamInt('limit')),
            'shop_source_id_empty' => true,
        ];

        // получаем список
        View_View::find(
            $this->dbObject, $this->_sitePageData->shopID,
            '_shop/product/list/work', '_shop/product/one/work',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params, false),
            array(
                'shop_rubric_id' => array('name'),
                'shop_brand_id' => array('name'),
                'shop_supplier_id' => array('name'),
                'shop_product_status_id' => array('name'),
                'root_shop_product_id' => array('article'),
            )
        );

        $this->_putInMain('/main/_shop/product/work');
    }

    public function action_identify() {
        $this->_sitePageData->url = '/market/shopproduct/identify';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Rubric');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Product_Status');

        $params = [
            'limit_page' => 25,
            'limit' => intval(Request_RequestParams::getParamInt('limit')),
            'shop_source_id_empty' => true,
            'is_found_supplier' => true,
            'root_shop_product_id' => 0,
            'is_public' => true,
            'is_is_stock' => true,
            'price_cost_from' => 0,
        ];

        // получаем список
        View_View::find(
            $this->dbObject, $this->_sitePageData->shopID,
            '_shop/product/list/identify', '_shop/product/one/identify',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params, false),
            array(
                'shop_rubric_id' => array('name'),
                'shop_brand_id' => array('name'),
                'shop_supplier_id' => array('name'),
                'shop_product_status_id' => array('name'),
                'root_shop_product_id' => array('article'),
            )
        );

        $this->_putInMain('/main/_shop/product/identify');
    }

    public function action_child_product() {
        $this->_sitePageData->url = '/market/shopproduct/child_product';

        $params = [
            'limit_page' => 25,
            'limit' => intval(Request_RequestParams::getParamInt('limit')),
            'is_root_child' => true,
        ];

        $id = Request_RequestParams::getParamInt('id_or_root_shop_product_id');
        if($id > 0){
            $params['id_or_root_shop_product_id'] = $id;
        }

        // получаем список
        View_View::find(
            $this->dbObject, $this->_sitePageData->shopID,
            '_shop/product/list/index', '_shop/product/one/index',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params, false),
            array(
                'shop_rubric_id' => array('name'),
                'shop_brand_id' => array('name'),
                'shop_supplier_id' => array('name'),
                'shop_product_status_id' => array('name'),
                'root_shop_product_id' => array('article'),
            )
        );

        $this->_putInMain('/main/_shop/product/child-product');
    }

    public function action_set_child_product()
    {
        $this->_sitePageData->url = '/market/shopproduct/set_child_product';

        $article1 = Request_RequestParams::getParamStr('article1');
        $article2 = Request_RequestParams::getParamStr('article2');
        if(empty($article1) || empty($article2)){
            self::redirect('/market/shopproduct/child_product' . URL::query(['message' => 'Оба артикула должны быть заданы.'], true));
            return;
        }

        if($article1 == $article2){
            self::redirect('/market/shopproduct/child_product' . URL::query(['message' => 'Артикулы должны быть разными.'], true));
            return;
        }

        /** @var Model_AutoPart_Shop_Product $model1 */
        $model1 = Request_Request::findOneModel(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'article_full' => $article1,
                    'is_public_ignore' => true,
                ]
            )
        );
        if($model1 === false){
            self::redirect('/market/shopproduct/child_product' . URL::query(['message' => 'Не найден артикул "' . $article1 . '".']));
            return;
        }

        /** @var Model_AutoPart_Shop_Product $model2 */
        $model2 = Request_Request::findOneModel(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'article_full' => $article2,
                    'is_public_ignore' => true,
                ]
            )
        );
        if($model2 === false){
            self::redirect('/market/shopproduct/child_product' . URL::query(['message' => 'Не найден артикул "' . $article2 . '".']));
            return;
        }

        if($model1->getChildProductCount() > 0 && $model2->getChildProductCount() > 0){
            self::redirect('/market/shopproduct/child_product' . URL::query(['message' => 'Оба товара являются родителями.']));
            return;
        }

        $params = [
            'is_public_ignore' => true,
            'sort_by' => [
                'root_shop_product_id' => 'asc'
            ]
        ];

        if($model1->getRootShopProductID() == 0 && $model2->getRootShopProductID() > 0 ){
            $model2->setRootShopProductID($model1->id);
            Helpers_DB::saveDBObject($model2, $this->_sitePageData);

            $params['id_or_root_shop_product_id'] = $model1->id;
            self::redirect('/market/shopproduct/child_product' . URL::query($params, false));
            return;
        }

        if($model1->getRootShopProductID() == $model2->id){
            $model1->setRootShopProductID(0);
            Helpers_DB::saveDBObject($model1, $this->_sitePageData);

            $model2->setRootShopProductID($model1->id);
            Helpers_DB::saveDBObject($model2, $this->_sitePageData);

            $params['id_or_root_shop_product_id'] = $model1->id;
            self::redirect('/market/shopproduct/child_product' . URL::query($params, false));
            return;
        }

        if($model2->getRootShopProductID() == 0 && $model1->getRootShopProductID() > 0 ){
            print_r($model1->getRootShopProductID());die;
            $model1->setRootShopProductID($model2->id);
            Helpers_DB::saveDBObject($model1, $this->_sitePageData);

            $params['id_or_root_shop_product_id'] = $model2->id;
            self::redirect('/market/shopproduct/child_product' . URL::query($params, false));
            return;
        }

        if(!Helpers_Array::_empty($model1->getOptionsValue('sources'))){
            $model2->setRootShopProductID($model1->id);
            Helpers_DB::saveDBObject($model2, $this->_sitePageData);

            $params['id_or_root_shop_product_id'] = $model1->id;
            self::redirect('/market/shopproduct/child_product' . URL::query($params, false));
            return;
        }

        $model2->setRootShopProductID($model1->id);
        Helpers_DB::saveDBObject($model2, $this->_sitePageData);

        $params['id_or_root_shop_product_id'] = $model1->id;
        self::redirect('/market/shopproduct/child_product' . URL::query($params, false));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/market/shopproduct/new';

        $this->_requestListDB('DB_AutoPart_Shop_Rubric');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Product_Status');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/market/shopproduct/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Rubric', $model->getShopRubricID());
        $this->_requestListDB('DB_AutoPart_Shop_Brand', $model->getShopBrandID());
        $this->_requestListDB('DB_AutoPart_Shop_Supplier', $model->getShopSupplierID());
        $this->_requestListDB('DB_AutoPart_Shop_Product_Status', $model->getShopStatusID());
        $this->_requestListDB('DB_AutoPart_Shop_Attribute_Type', $model->getShopStatusID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_double()
    {
        $this->_sitePageData->url = '/market/shopproduct/double';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $modelNew = new Model_AutoPart_Shop_Product();
        $modelNew->setDBDriver($this->_driverDB);
        $modelNew->copy($model, true);

        $modelNew->setOptionsValue('sources', []);

        Helpers_DB::saveDBObject($modelNew, $this->_sitePageData);

        $modelNew->setArticle('I'.$modelNew->id);
        Helpers_DB::saveDBObject($modelNew, $this->_sitePageData);

        self::redirect('/market/shopproduct/index' . URL::query(['name_full' => $modelNew->getName(), 'is_public_ignore' => true], false));
    }

    public function action_save_kaspi() {
        $this->_sitePageData->url = '/market/shopproduct/save_kaspi';

        $filePath = Helpers_Path::getPathFile(
            APPPATH, array('views', 'smg', '_report', $this->_sitePageData->dataLanguageID, 'product'), 'kaspi.xlsx'
        );
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        // ищем связанные товары
        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ,
                    'root_shop_product_id_from' => 0,
                    'article_empty' => false,
                ]
            ),
            0, true
        );

        // группируем товары по родителю и ищем минимальную себестоимость
        $bindIDs = [];
        foreach ($ids->childs as $child){
            $root = $child->values['root_shop_product_id'];
            if(!key_exists($root, $bindIDs)){
                $bindIDs[$root] = [
                    'price_cost' => null,
                    'list' => [],
                ];
            }

            $bindIDs[$root]['list'][] = $child;

            if($child->values['is_public'] = 1 && $bindIDs[$root]['price_cost'] > $child->values['price_cost'] || $bindIDs[$root]['price_cost'] === null){
                $bindIDs[$root]['price_cost'] = $child->values['price_cost'];
            }
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'is_public_ignore' => true,
                    'shop_source_id' => Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ,
                    'root_shop_product_id' => 0,
                ]
            ),
            0, true,
            [
                'shop_brand_id' => array('name', 'is_disable_dumping'),
                'shop_supplier_id' => array('is_disable_dumping', 'min_markup'),
                'shop_rubric_source_id' => array('is_sale', 'commission', 'commission_sale', 'markup'),
            ],
            Request_Request::SELECT_FIELDS_EXCLUSION_TEXT
        );

        $products = [];
        foreach ($ids->childs as $child){
            $model = new Model_AutoPart_Shop_Product();
            $model->setDBDriver($this->_driverDB);

            if($child->getElementValue('shop_rubric_source_id', 'is_sale', 0) == 0){
                $commission = $child->getElementValue('shop_rubric_source_id', 'commission', 0);
            }else{
                $commission = $child->getElementValue('shop_rubric_source_id', 'commission_sale', 0);
            }
            $rubricMarkup = floatval($child->getElementValue('shop_rubric_source_id', 'markup', 0));

            $child->setModel($model);

            $priceCost = $model->getPriceCost();
            if(key_exists($model->id, $bindIDs)
                && $bindIDs[$model->id]['price_cost'] !== null
                && $priceCost > $bindIDs[$model->id]['price_cost']){
                $child->values['is_public'] = 1;
            }else{
                $child->values['is_public'] = $child->values['is_in_stock'];
            }

            $child->values['price'] = Controller_Smg_Kaspi::getPrice(
                $priceCost, $model, $shopCompanyID,
                $child->getElementValue('shop_supplier_id', 'is_disable_dumping', false)
                    || $child->getElementValue('shop_brand_id', 'is_disable_dumping', false),
                floatval($child->getElementValue('shop_supplier_id', 'min_markup', 5000)),
                $rubricMarkup,
                floatval($commission)
            );

            if($model->getIsDelete() && $model->getOptionsValue('sources.kaspi', null) == null){
                continue;
            }

            if($model->getIsPublic()){
                $child->values['is_in_stock'] = 'yes';
            }else{
                $child->values['is_in_stock'] = 'no';
            }

            $products[] = $child->values;
        }
        unset($ids);

        Helpers_Excel::saleInFile(
            $filePath,
            array(),
            array('products' => $products),
            'php://output',
            'ExcelFormatTemplate1.xlsx'
        );
        exit();
    }

    public function action_get_price_kaspi() {
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");
        $this->_sitePageData->url = '/market/shopproduct/get_price_kaspi';

        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(array('sort_by' => ['updated_at' => 'asc']), false), 0, true
        );

        $proxies = include Helpers_Path::getFilesProxies();
        $user = $proxies['user'];
        $password = $proxies['password'];
        $proxies = $proxies['proxies'];

        $cookies = [];
        foreach ($proxies as $proxy){
            $cookies[$proxy] = '';
        }

        $getPrice = function ($url, $getPrice, &$i, &$proxies, &$cookies, &$n, $user, $password){
            $proxy = $proxies[$i++ % count($proxies)];
            try {
                $prices = Drivers_ParserSite_Kaspi::getProductPrices($url, $cookies[$proxy], $proxy, $user, $password);
            }catch (Drivers_ParserSite_Kaspi_Exception $e){
                $n++;
                if($n > count($proxies)){
                    throw new HTTP_Exception_500('Ни один прокси не работает. :(');
                }

                $prices = $getPrice($url, $getPrice, $i, $proxies, $cookies, $n, $user, $password);
            }

            return $prices;
        };

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);
        $i = random_int(0, count($proxies));
        foreach ($shopProductIDs->childs as $child){
            $child->setModel($model);

            $url = $model->getOptionsValue('sources.kaspi.url');
            if(empty($url)){
                continue;
            }

            $options = $model->getOptionsValue('sources');

            $date = Arr::path($options, 'kaspi.prices.update');
            $update = date('Y-m-d H:i:s');
            if($date != null && Helpers_DateTime::diffMinutes($update, $date) < 60){
                continue;
            }

            $n = 0;
            $prices = $getPrice($url, $getPrice, $i, $proxies, $cookies, $n, $user, $password);

            $proxy = $proxies[$i++ % count($proxies)];
           /* try {
                $prices = Drivers_ParserSite_Kaspi::getProductPrices($url, $cookies[$proxy], $proxy);
            }catch (Drivers_ParserSite_Kaspi_Exception $e){
                $i++;
            }*/
            if($prices === false){
                continue;
            }

            $options['kaspi']['price_data'] = $prices;

            $options['kaspi']['prices'] = [
                'max' => Arr::path($prices, 'maxPrice'),
                'min' => Arr::path($prices, 'minPrice'),
                'update' => $update,
            ];
            $model->setOptionsValue('sources', $options);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        self::redirect('/market/shopproduct/index'. URL::query());
    }

    public function action_sync_price() {
        $this->_sitePageData->url = '/market/shopproduct/sync_price';

        $this->_putInMain('/main/_shop/product/sync-price');
    }

    public function action_sync_kama_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_kama_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        Drivers_ParserSite_KamaKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'), $this->_sitePageData, $this->_driverDB
        );
    }

    public function action_sync_al_style_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_al_style_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        Drivers_ParserSite_AlStyleKZNotToken::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'), $this->_sitePageData, $this->_driverDB
        );
    }

    public function action_sync_ak_cent_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_ak_cent_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        Drivers_ParserSite_AkCentKZNotToken::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'), $this->_sitePageData, $this->_driverDB
        );
    }

    public function action_sync_alfastar_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_alfastar_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        Drivers_ParserSite_AlfastarKz::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'), $this->_sitePageData, $this->_driverDB
        );
    }

    public function action_add_list_kaspi() {
        $this->_sitePageData->url = '/market/shopproduct/add_list_kaspi';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');
        $isCheck = Request_RequestParams::getParamBoolean('is_check');

        $shopSupplierID = Request_RequestParams::getParam('shop_supplier_id');
        if(!empty($shopSupplierID) && !is_array($shopSupplierID)){
            $shopSupplierID = explode(',', $shopSupplierID);
        }

        $params = [
            'is_public_ignore' => true,
            'shop_supplier_id' => $shopSupplierID,
            'root_shop_product_id' => 0,
            'is_in_stock' => Request_RequestParams::getParamBoolean('is_in_stock'),
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $curl = Drivers_ParserSite_Kaspi::authMerchantСabinetV2($shopCompanyID);

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);


        foreach ($shopProductIDs->childs as $child){
            $source = Arr::path(json_decode($child->values['options'], true), 'sources.kaspi', array());
            if(empty($source)){
                continue;
            }

            $url = $source['url'];
            if(empty($url)){
                continue;
            }

            $id = str_replace('/', '', substr($url, strrpos($url, '-') + 1));
            if(empty($id)){
                continue;
            }

            if($isCheck){
                $shopProductSource = Request_Request::findOne(
                    DB_AutoPart_Shop_Product_Source::NAME, 0, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        [
                            'source_site_id_full' => $id,
                            'shop_product_id_not' => $child->id,
                        ]
                    ), 0, true
                );

                if($shopProductSource != null){
                    if($shopProductSource->values['source_site_id'] != $id){
                        echo 'Запрос не сработал.';
                    }

                    $child->setModel($model);

                    $model->setRootShopProductID($shopProductSource->values['shop_product_id']);
                    Helpers_DB::saveDBObject($model, $this->_sitePageData);
                }
            }else {
                $curl->post('https://kaspi.kz/merchantcabinet/api/offer/mapToMasterProduct?merchantProductCode=' . $child->values['article'] . '&masterProductCode=' . $id);
                $data = $curl->getRawResponse();

                $json = json_decode($data, true);
                if(!is_array($json) || !key_exists('status', $json)){
                    $data = 'Ошибка, товара нет кабинете kaspi.kz';
                }
                echo $child->values['article'] . '=' . $id . ' - ' . $data . '<br>';
            }
        }
    }

    public function action_del_list_kaspi() {
        $this->_sitePageData->url = '/market/shopproduct/del_list_kaspi';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');

        $params = [
            'is_public_ignore' => true,
            'shop_supplier_id' => Request_RequestParams::getParamInt('shop_supplier_id'),
            'root_shop_product_id' => 0,
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $curl = Drivers_ParserSite_Kaspi::authMerchantСabinetV2($shopCompanyID);

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);


        foreach ($shopProductIDs->childs as $child){
            $source = Arr::path(json_decode($child->values['options'], true), 'sources.kaspi', array());
            if(empty($source)){
                continue;
            }

            $url = $source['url'];
            if(empty($url)){
                continue;
            }

            $id = str_replace('/', '', substr($url, strrpos($url, '-') + 1));
            if(empty($id)){
                continue;
            }

            $curl->post('https://kaspi.kz/merchantcabinet/api/offer/unlinkMerchantProduct', json_encode($child->values['article']));
            $data = $curl->getRawResponse();
            echo $child->values['article'] . '=' . $id . ' - ' . $data . '<br>';
        }
    }

    public function action_sync_intant_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_intant_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        Drivers_ParserSite_IntantKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_hatber_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_hatber_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $model = new Model_AutoPart_Shop_Product();

        /*Drivers_ParserSite_HatberKZ::loadProduct(
            'https://hatber.kz/osvezhitel-vozdukha-frosch-lavanda-90ml-smennyy-ballon.html',
            $model, $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies()
        );die;*/

        Drivers_ParserSite_HatberKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_shop_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_shop_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $model = new Model_AutoPart_Shop_Product();

        /*Drivers_ParserSite_ShopKZ::loadProduct(
            'https://shop.kz/search/?q=156639',
            $model, $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies()
        );die;*/

        Drivers_ParserSite_ShopKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_alser_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_alser_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $model = new Model_AutoPart_Shop_Product();

        /*Drivers_ParserSite_AlserKZ::loadProduct(
            'https://alser.kz/p/noutbuk-hp-15-eu0016ur-hp-envyx360-touch-156-fhd-ips-amd-ryzen-7-5700u16gbssd-1000gbamd-radeon-graphicswin10nightfall-black4e0u9eaacb',
            $model, $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies()
        );die;*/

        Drivers_ParserSite_AlserKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_pulser_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_pulser_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $model = new Model_AutoPart_Shop_Product();

       /* Drivers_ParserSite_PulserKZ::loadProduct(
            'http://pulser.kz/?card=152499',
            $model, $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies()
        );die;*/

        Drivers_ParserSite_PulserKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_tgrad_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_tgrad_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        /*$model = new Model_AutoPart_Shop_Product();
        Drivers_ParserSite_TGradKZ::loadProduct(
            'https://tgrad.kz/robot-pylesos-mi-robot-vacuum-mop-stytj01zhm-belyy/',
            $model, $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies()
        );die;*/

        Drivers_ParserSite_TGradKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_price_tgrad_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_price_tgrad_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        /*$model = new Model_AutoPart_Shop_Product();
        Drivers_ParserSite_TGradKZ::loadProductPrice(
            'https://tgrad.kz/pylesos-artel-vcb-0316-belyy/',
            $model, $this->_sitePageData, $this->_driverDB,
            []
        );die;*/

        Drivers_ParserSite_TGradKZ::loadProductsPrice(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_bt24_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_bt24_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        /*$model = new Model_AutoPart_Shop_Product();
        Drivers_ParserSite_Bt24KZ::loadProduct(
            'https://bt24.kz/stiralnaya-mashina-vestfrost-vft-8143ddc/',
            $model, $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies()
        );die;*/

        Drivers_ParserSite_Bt24KZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'),
            $this->_sitePageData, $this->_driverDB,
            Helpers_Path::getFilesProxies(), false
        );
    }

    public function action_sync_marvel_kz() {
        $this->_sitePageData->url = '/market/shopproduct/sync_marvel_kz';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        Drivers_ParserSite_MarvelKZ::loadProducts(
            Request_RequestParams::getParamInt('shop_supplier_id'), $this->_sitePageData, $this->_driverDB
        );
    }

    public function action_sync_cron() {
        $this->_sitePageData->url = '/market/shopproduct/sync_cron';

        $this->_putInMain('/main/_shop/product/sync-cron');
    }

    public function action_cron_urls() {
        $this->_sitePageData->url = '/market/shopproduct/cron_urls';
        set_time_limit(3600000);
        ini_set("max_execution_time", "3600000");

        $urls = include Helpers_Path::getPathFile(APPPATH, ['config'], 'cronURLs.php');

        foreach ($urls as $url){
            Helpers_URL::getDataURLEmulationBrowser($url, 200);

            echo 'Запущен поток url: ' . $url . '<br>' . "\r\n";
        }

        echo 'Конец';
    }

    public function action_del_params() {
        $this->_sitePageData->url = '/market/shopproduct/del_params';

        $id = Request_RequestParams::getParamInt('id');

        $params = [
            'is_public_ignore' => true,
            'options_empty' => false,
            'id' => $id,
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($this->_driverDB);

        foreach ($shopProductIDs->childs as $child){
            $child->setModel($model);

            $options = $model->getOptionsArray();
            if($id > 0) {
                echo '<pre>';
                print_r($options);
                die;
            }
            if(!key_exists('params', $options)){
                continue;
            }

            unset($options['params']);
            $model->setOptionsArray($options);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            echo $model->id . '<br>';
        }

        echo '<br>';

        $params = [
            'is_public_ignore' => true,
            'options_empty' => false,
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product_Source::NAME, 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams($params), 0, true
        );

        $model = new Model_AutoPart_Shop_Product_Source();
        $model->setDBDriver($this->_driverDB);

        foreach ($shopProductIDs->childs as $child){
            $child->setModel($model);

            $options = $model->getOptionsArray();
            if(!key_exists('params', $options)){
                continue;
            }

            unset($options['params']);

            $model->setOptionsArray($options);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            echo $model->id . '<br>';
        }

        echo 'конец';
    }
}
