<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Product extends Model_Shop_Table_Basic_Table{
    const COMPARE_STOCK_EQUALLY = 0; // = равно
    const COMPARE_STOCK_MORE = 1; // > больше
    const COMPARE_STOCK_LESS = 2; // < меньше

	const TABLE_NAME = 'ap_shop_products';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(
                'quantity',
                'price',
                'paid_quantity',
                'total_quantity',
                'shop_storage_id',
                'barcode',
                'work_type_id',
                'name_url',
                'discount',
                'discount_from_at',
                'discount_to_at',
                'shop_mark_id',
                'shop_model_id',
                'shop_brand_id',
                'article',
                'integrations',
                'tnved',
                'price_cost',
                'shop_supplier_id',
                'shop_rubric_id',
                'shop_status_id',
                'shop_supplier_parser_id',
                'name_supplier',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }
    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
                        break;
                    case 'work_type_id':
                        $this->_dbGetElement($this->getWorkTypeID(), 'work_type_id', new Model_WorkType());
                        break;
                    case 'shop_mark_id':
                        $this->_dbGetElement($this->getShopMarkID(), 'shop_mark_id', new Model_AutoPart_Shop_Mark());
                        break;
                    case 'shop_model_id':
                        $this->_dbGetElement($this->getShopModelID(), 'shop_mark_id', new Model_AutoPart_Shop_Model());
                        break;
                    case 'shop_brand_id':
                        $this->_dbGetElement($this->getShopBrandID(), 'shop_brand_id', new Model_AutoPart_Shop_Brand());
                        break;
                    case 'shop_supplier_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_AutoPart_Shop_Supplier());
                        break;
                    case 'shop_rubric_id':
                        $this->_dbGetElement($this->getShopRubricID(), 'shop_rubric_id', new Model_AutoPart_Shop_Rubric());
                        break;
                    case 'shop_status_id':
                        $this->_dbGetElement($this->getShopStatusID(), 'shop_status_id', new Model_AutoPart_Shop_Product_Status());
                        break;
                    case 'shop_supplier_parcer_id':
                        $this->_dbGetElement($this->getShopSupplierParserID(), 'shop_supplier_parser_id', new Model_AutoPart_Shop_Supplier_Parser());
                        break;
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }
    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldStr('name_url', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('work_type_id', $validation);
        $this->isValidationFieldInt('shop_mark_id', $validation);
        $this->isValidationFieldInt('shop_model_id', $validation);
        $this->isValidationFieldInt('shop_brand_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('paid_quantity', $validation);
        $this->isValidationFieldFloat('total_quantity', $validation);
        $this->isValidationFieldFloat('discount', $validation);
        $this->isValidationFieldStr('barcode', $validation);
        $this->isValidationFieldStr('article', $validation);
        $this->isValidationFieldStr('integrations', $validation);
        $this->isValidationFieldStr('tnved', $validation);
        $this->isValidationFieldFloat('price_cost', $validation);
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldInt('shop_supplier_parser_id', $validation);
        $this->isValidationFieldInt('shop_rubric_id', $validation);
        $this->isValidationFieldInt('shop_status_id', $validation);
        $this->isValidationFieldStr('name_supplier', $validation);

        return $this->_validationFields($validation, $errorFields);

    }

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['integrations'] = $this->getIntegrationsArray();
            $arr['params'] = $this->getParamsArray();
        }

        return $arr;
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setNameURL($value){
        $this->setValue('name_url', $value);
    }
    public function getNameURL(){
        return $this->getValue('name_url');
    }

    public function setNameSupplier($value){
        $this->setValue('name_supplier', $value);
    }
    public function getNameSupplier(){
        return $this->getValue('name_supplier');
    }

    public function setShopBrandID($value){
        $this->setValueInt('shop_brand_id', $value);
    }
    public function getShopBrandID(){
        return $this->getValueInt('shop_brand_id');
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setShopSupplierParserID($value){
        $this->setValueInt('shop_supplier_parser_id', $value);
    }
    public function getShopSupplierParserID(){
        return $this->getValueInt('shop_supplier_parser_id');
    }

    public function setShopMarkID($value){
        $this->setValueInt('shop_mark_id',$value);
    }
    public function getShopMarkID(){
        return $this->getValueInt('shop_mark_id');
    }

    public function setShopStatusID($value){
        $this->setValueInt('shop_status_id',$value);
    }
    public function getShopStatusID(){
        return $this->getValueInt('shop_status_id');
    }

    public function setWorkTypeID($value){
        $this->setValueInt('work_type_id', $value);
    }
    public function getWorkTypeID(){
        return $this->getValueInt('work_type_id');
    }

    public function setShopModelID($value){
        $this->setValueInt('shop_model_id', $value);
    }
    public function getShopModelID(){
        return $this->getValueInt('shop_model_id');
    }

    public function setShopRubricID($value){
        $this->setValueInt('shop_rubric_id', $value);
    }
    public function getShopRubricID(){
        return $this->getValueInt('shop_rubric_id');
    }

    public function setDiscountFromAt($value){
        $this->setValueDateTime('discount_from_at',$value);
    }
    public function getDiscountFromAt(){
        return $this->getValue('discount_from_at');
    }
    //Время окончанияя акции
    public function setDiscountToAt($value){
        $this->setValueDateTime('discount_to_at',$value);
    }
    public function getDiscountToAt(){
        return $this->getValue('discount_to_at');
    }

    public function setDiscount($value){
        $this->setValueFloat('discount', $value);
    }
    public function getDiscount(){
        return $this->getValueFloat('discount');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setPaidQuantity($value){
        $this->setValueFloat('paid_quantity', $value);
    }
    public function getPaidQuantity(){
        return $this->getValueFloat('paid_quantity');
    }

    public function setTotalQuantity($value){
        $this->setValueFloat('total_quantity', $value);
    }
    public function getTotalQuantity(){
        return $this->getValueFloat('total_quantity');
    }

    public function setBarcode($value){
        $this->setValue('barcode', $value);
    }
    public function getBarcode(){
        return $this->getValue('barcode');
    }

    public function setArticle($value){
        $this->setValue('article', $value);
    }
    public function getArticle(){
        return $this->getValue('article');
    }

    public function setTNVED($value){
        $this->setValue('tnved', $value);
    }
    public function getTNVED(){
        return $this->getValue('tnved');
    }

    public function setPriceCost($value){
        $this->setValueFloat('price_cost', $value);
    }
    public function getPriceCost(){
        return $this->getValueFloat('price_cost');
    }

    // JSON интеграции с другими системами
    public function setIntegrations($value){
        $this->setValue('integrations', $value);
    }
    public function getIntegrations(){
        return $this->getValue('integrations');
    }
    public function setIntegrationsArray(array $value){
        $this->setValueArray('integrations', $value);
    }
    public function getIntegrationsArray(){
        return $this->getValueArray('integrations');
    }
    public function addIntegration($value){
        $arr = $this->getIntegrationsArray();
        $arr[] = $value;
        $this->setIntegrationsArray(array_unique($arr));
    }

    public function setStockQuantity($value){
        $this->setValueFloat('stock_quantity', $value);
    }
    public function getStockQuantity(){
        return $this->getValueFloat('stock_quantity');
    }

    public function setIsOnOrder($value){
        $this->setValueBool('is_on_order', $value);
    }
    public function getIsOnOrder(){
        return $this->getValueBool('is_on_order');
    }

    public function setIsLoadSiteSupplier($value){
        $this->setValueBool('is_load_site_supplier', $value);
    }
    public function getIsLoadSiteSupplier(){
        return $this->getValueBool('is_load_site_supplier');
    }

    public function setIsInStock($value){
        $this->setValueBool('is_in_stock', $value);

        if(!$this->getIsInStock()){
            $this->setStockQuantity(0);
            $this->setStockCompareTypeID(0);
        }
    }
    public function getIsInStock(){
        return $this->getValueBool('is_in_stock');
    }

    public function setStockCompareTypeID($value){
        $this->setValueInt('stock_compare_type_id', $value);
    }
    public function getStockCompareTypeID(){
        return $this->getValueInt('stock_compare_type_id');
    }

    public function setChildProductCount($value){
        $this->setValueInt('child_product_count', $value);
    }
    public function getChildProductCount(){
        return $this->getValueInt('child_product_count');
    }

    public function setRootShopProductID($value){
        $this->setValueInt('root_shop_product_id', $value);
    }
    public function getRootShopProductID(){
        return $this->getValueInt('root_shop_product_id');
    }

    public function setURL($value){
        $this->setValue('url', $value);
    }
    public function getURL(){
        return $this->getValue('url');
    }

    // JSON настройки списка полей
    public function setParams($value){
        $this->setValue('params', $value);
    }
    public function getParams(){
        return $this->getValue('params');
    }
    public function setParamsArray(array $value){
        $this->setValueArray('params', $value);
    }
    public function getParamsArray(){
        return $this->getValueArray('params');
    }

    public function getParamsValue($field, $default = ''){
        return Arr::path($this->getParamsArray(), $field, $default);
    }
    public function setParamsValue($field, $value){
        $params = $this->getParamsArray();
        $params[$field] = $value;

        return $this->setParamsArray($params);
    }

    /**
     * Добавление параметра дополнительные поля
     * @param $name
     * @param $value
     * @param bool $isReplace
     */
    public function addParamInParams($name, $value, $isReplace = TRUE){
        $tmp = $this->getParamsArray();
        if($isReplace || (!key_exists($name, $tmp))) {
            $tmp[$name] = $value;
        }

        $this->setParamsArray($tmp);
    }

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     * @param array $value
     * @param bool $isAddAll
     * @param null $key
     */
    public function addParamsArray(array $value, $isAddAll = TRUE, $key = null){
        $tmp = $this->getParamsArray();

        if(empty($key)){
            $list = $tmp;
        }else{
            $list = Arr::path($tmp, $key, []);
            if(!is_array($list)){
                $list = [];
            }
        }

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $list) || empty($list[$k]))) {
                $list[$k] = $v;
            }
        }

        if(!empty($key)) {
            $tmp[$key] = $list;
        }else{
            $tmp = $list;
        }

        $this->setParamsArray($tmp);
    }

    public function setIsFoundSupplier($value){
        $this->setValueBool('is_found_supplier', $value);
    }
    public function getIsFoundSupplier(){
        return $this->getValueBool('is_found_supplier');
    }
}
