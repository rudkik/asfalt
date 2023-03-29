<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Product_Source_Price extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_product_source_prices';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'price_min',
			'price_cost',
			'shop_source_id',
			'price_max',
			'shop_rubric_source_id',
			'shop_product_id',
			'profit',
			'price_source',
			'shop_company_id',
			'commission',
			'price_supplier',
			'shop_product_source_id',
			'position_number',
			'position_count',
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
                   case 'shop_source_id':
                            $this->_dbGetElement($this->getShopSourceID(), 'shop_source_id', new Model_AutoPart_Shop_Source(), $shopID);
                            break;
                   case 'shop_rubric_source_id':
                            $this->_dbGetElement($this->getShopRubricSourceID(), 'shop_rubric_source_id', new Model_AutoPart_Shop_Rubric_Source(), $shopID);
                            break;
                   case 'shop_product_id':
                            $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_AutoPart_Shop_Product(), $shopID);
                            break;
                   case 'shop_company_id':
                            $this->_dbGetElement($this->getShopCompanyID(), 'shop_company_id', new Model_AutoPart_Shop_Company(), $shopID);
                            break;
                   case 'shop_product_source_id':
                            $this->_dbGetElement($this->getShopProductSourceID(), 'shop_product_source_id', new Model_AutoPart_Shop_Product_Source(), $shopID);
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

        $validation->rule('price_min', 'max_length', array(':value',13));

        $validation->rule('price_cost', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_source_id', $validation);
        $validation->rule('price_max', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_rubric_source_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $validation->rule('profit', 'max_length', array(':value',13));

        $validation->rule('price_source', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_company_id', $validation);
        $this->isValidationFieldInt('commission', $validation);
        $validation->rule('price_supplier', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_product_source_id', $validation);
        $validation->rule('position_number', 'max_length', array(':value',13));

        $validation->rule('position_count', 'max_length', array(':value',13));


        return $this->_validationFields($validation, $errorFields);
    }

    public function setPriceMin($value){
        $this->setValueFloat('price_min', $value);
    }
    public function getPriceMin(){
        return $this->getValueFloat('price_min');
    }

    public function setPriceCost($value){
        $this->setValueFloat('price_cost', $value);
    }
    public function getPriceCost(){
        return $this->getValueFloat('price_cost');
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id', $value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }

    public function setPriceMax($value){
        $this->setValueFloat('price_max', $value);
    }
    public function getPriceMax(){
        return $this->getValueFloat('price_max');
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

    public function setProfit($value){
        $this->setValueFloat('profit', $value);
    }
    public function getProfit(){
        return $this->getValueFloat('profit');
    }

    public function setPriceSource($value){
        $this->setValueFloat('price_source', $value);
    }
    public function getPriceSource(){
        return $this->getValueFloat('price_source');
    }

    public function setShopCompanyID($value){
        $this->setValueInt('shop_company_id', $value);
    }
    public function getShopCompanyID(){
        return $this->getValueInt('shop_company_id');
    }

    public function setCommission($value){
        $this->setValueInt('commission', $value);
    }
    public function getCommission(){
        return $this->getValueInt('commission');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setShopProductSourceID($value){
        $this->setValueInt('shop_product_source_id', $value);
    }
    public function getShopProductSourceID(){
        return $this->getValueInt('shop_product_source_id');
    }

    public function setPositionNumber($value){
        $this->setValueFloat('position_number', $value);
    }
    public function getPositionNumber(){
        return $this->getValueFloat('position_number');
    }

    public function setPositionCount($value){
        $this->setValueFloat('position_count', $value);
    }
    public function getPositionCount(){
        return $this->getValueFloat('position_count');
    }


}
