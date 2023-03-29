<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Product_Source extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_product_sources';
    const TABLE_ID = 61;

    public function __construct(){
        parent::__construct(
            array(
                'price_min',
                'integrations',
                'price_cost',
                'price_source',
                'price_max',
                'price',
                'shop_rubric_source_id',
                'shop_product_id',
                'shop_source_id',
                'shop_company_id',
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
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_AutoPart_Shop_Product());
                        break;
                    case 'shop_company_id':
                        $this->_dbGetElement($this->getShopCompanyID(), 'shop_company_id', new Model_AutoPart_Shop_Company());
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
        $this->isValidationFieldInt('shop_product_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }

    public function setShopRubricSourceID($value){
        $this->setValueInt('shop_rubric_source_id', $value);
    }
    public function getShopRubricSourceID(){
        return $this->getValueInt('shop_rubric_source_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setPriceMin($value){
        $this->setValueFloat('price_min', $value);
    }
    public function getPriceMin(){
        return $this->getValueFloat('price_min');
    }

    public function setPriceMax($value){
        $this->setValueFloat('price_max', $value);
    }
    public function getPriceMax(){
        return $this->getValueFloat('price_max');
    }

    public function setPriceCost($value){
        $this->setValueFloat('price_cost', $value);
    }
    public function getPriceCost(){
        return $this->getValueFloat('price_cost');
    }

    public function setPriceSource($value){
        $this->setValueFloat('price_source', $value);
    }
    public function getPriceSource(){
        return $this->getValueFloat('price_source');
    }

    public function setProfit($value){
        $this->setValueFloat('profit', $value);
    }
    public function getProfit(){
        return $this->getValueFloat('profit');
    }

    public function setCommission($value){
        $this->setValueFloat('commission', $value);
    }
    public function getCommission(){
        return $this->getValueFloat('commission');
    }

    public function setURL($value){
        $this->setValue('url', $value);
    }
    public function getURL(){
        return $this->getValue('url');
    }

    public function setImageURL($value){
        $this->setValue('image_url', $value);
    }
    public function getImageURL(){
        return $this->getValue('image_url');
    }

    public function setSourceSiteID($value){
        $this->setValue('source_site_id', $value);
    }
    public function getSourceSiteID(){
        return $this->getValue('source_site_id');
    }
}
