<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopProductSource extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product_Source';
        $this->controllerName = 'shopproductsource';
        $this->tableID = Model_AutoPart_Shop_Product_Source::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product_Source::TABLE_NAME;

        parent::__construct($request, $response);
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/market/shopproductsource/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Rubric_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Supplier');

        parent::_actionIndex(
            array(
                'shop_source_id' => array('name'),
                'shop_rubric_source_id' => array('name', 'commission', 'commission_sale', 'is_sale'),
                'shop_product_id' => array('name', 'article', 'price', 'root_shop_product_id', 'child_product_count', 'url'),
                'shop_product_id.shop_brand_id' => array('name'),
                'shop_product_id.shop_supplier_id' => array('name'),
            )
        );
    }

    public function action_yml() {
        $this->_sitePageData->url = '/market/shopproductsource/yml';

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');
        $model = new Model_AutoPart_Shop_Company();
        if (! $this->getDBObject($model, $shopCompanyID, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Company not is found!');
        }

        $params = Request_RequestParams::setParams(
            [
                'shop_product_id' => Request_RequestParams::getParamInt('shop_product_id'),
                'shop_source_id' => Request_RequestParams::getParamInt('shop_source_id'),
                'shop_company_id' => $shopCompanyID,
                'shop_rubric_source_id_from' => 0,
                'shop_product_id.root_shop_product_id' => 0,
            ]
        );

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Product_Source_Price::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams($params),
            0, true,
            [
                'shop_rubric_source_id' => ['name'],
                'shop_product_id.shop_brand_id' => ['id', 'name'],
                'shop_product_id' => ['is_public', 'is_in_stock', 'text', 'name', 'params'],
                'shop_product_source_id' => ['image_url'],
            ]
        );

        $fileName = Helpers_Path::getPathFile(DOCROOT, ['sources'], 'alfa_c' . $shopCompanyID . '.xml');
        if(file_exists($fileName)) {
            unlink($fileName);
        }

        $fh = fopen($fileName, 'w');

        $text = '<yml_catalog date="' . Helpers_DateTime::getCurrentDateTimePHP() . '">'
            . '<shop>'
            . '<name>Товары</name>'
            . '<company>' . htmlspecialchars($model->getName(), ENT_XML1) . '</company>'
            . '<url>https://opto.kz</url>'
            . '<phone></phone>'
            . '<platform>ALfa YML-генератор</platform>'
            . '<version>1.3</version>'
            . '<currencies><currency id="KZT" rate="1"/></currencies>'
            . '<categories>';
        fwrite($fh, $text);

        $rubrics = [];
        foreach ($ids->childs as $child){
            $rubric = $child->values['shop_rubric_source_id'];
            if(key_exists($rubric, $rubrics)){
               continue;
            }
            $rubrics[$rubric] = '';

            $text = '<category id="' . $rubric . '">' . htmlspecialchars($child->getElementValue('shop_rubric_source_id'), ENT_XML1) . '</category>';
            fwrite($fh, $text);
        }

        $text = '</categories>'
            . '<offers>';
        fwrite($fh, $text);

        foreach ($ids->childs as $child){
            $text = '<offer id="' . $child->values['shop_product_id'] . '" available="'
                . Func::boolToStr(
                    $child->getElementValue('shop_product_id', 'is_public') == 1
                    && $child->getElementValue('shop_product_id', 'is_in_stock') == 1
                    && $child->values['price'] > 0
                ) . '">'
                . '<url></url>'
                . '<price>' . $child->values['price'] . '</price>'
                . '<currencyId>KZT</currencyId>'
                . '<categoryId>' . $child->values['shop_rubric_source_id'] . '</categoryId>'
                . '<pickup>true</pickup>'
                . '<delivery>true</delivery>'
                . '<name>' . htmlspecialchars($child->getElementValue('shop_product_id'), ENT_XML1) . '</name>'
                . '<vendor>' . htmlspecialchars($child->getElementValue('shop_brand_id'), ENT_XML1) . '</vendor>'
                . '<vendorCode>' . $child->getElementValue('shop_brand_id', 'id') . '</vendorCode>'
                . '<description>' . htmlspecialchars($child->getElementValue('shop_product_id', 'text'), ENT_XML1) . '</description>'
                . '<image>' . htmlspecialchars($child->getElementValue('shop_product_source_id', 'image_url'), ENT_XML1) . '</image>';


            $text .= '<attributes>';

            $params = json_decode($child->getElementValue('shop_product_id', 'params'), true);
            if(is_array($params)) {
                foreach ($params as $paramName => $paramValue){
                    $text .= '<attribute>'
                        . '<name>' . htmlspecialchars($paramName, ENT_XML1) . '</name>'
                        . '<value>' . htmlspecialchars($paramValue, ENT_XML1) . '</value>'
                        . '</attribute>';
                }
            }

            $text .= '</attributes>';
            $text .= '</offer>';
            fwrite($fh, $text);
        }

        $text = '</offers>'
            . '</shop>'
            . '</yml_catalog>';
        fwrite($fh, $text);
        fclose($fh);

        if(Request_RequestParams::getParamBoolean('is_file')) {
           // self::redirect('/sources/alfa_c' . $shopCompanyID . '.xml');die;
            header('Content-Type: text/xml');
            echo file_get_contents($fileName); die;
        }else {
            echo 'ok';
        }
    }
}
