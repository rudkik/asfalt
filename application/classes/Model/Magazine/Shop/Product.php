<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Product extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_products';
	const TABLE_ID = 243;

	public function __construct(){
		parent::__construct(
			array(
                'shop_product_rubric_id',
                'price_purchase',
                'price_cost',
                'quantity_coming',
                'quantity_expense',
                'coefficient_revise',
                'price_cost_without_nds',
                'product_type_id',
                'price_average',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->setMarkup(5);
		$this->setIsMarkupPercent(true);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_product_rubric_id':
                        $this->_dbGetElement($this->getShopProductRubricID(), 'shop_product_rubric_id', new Model_Magazine_Shop_Product_Rubric(), $shopID);
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
        $validation->rule('name_1c', 'max_length', array(':value', 250))
            ->rule('shop_product_rubric_id', 'max_length', array(':value', 11));
        $this->isValidationFieldInt('unit_id', $validation);
        $this->isValidationFieldStr('barcode', $validation, 20);
        $this->isValidationFieldFloat('price_purchase', $validation);
        $this->isValidationFieldFloat('price_cost', $validation);
        $this->isValidationFieldFloat('price_average', $validation);
        $this->isValidationFieldFloat('quantity_coming', $validation);
        $this->isValidationFieldFloat('quantity_expense', $validation);
        $this->isValidationFieldFloat('coefficient_revise', $validation);
        $this->isValidationFieldStr('name_esf', $validation);
        $this->isValidationFieldFloat('price_cost_without_nds', $validation);
        $this->isValidationFieldInt('product_type_id', $validation);

        if($this->getCoefficientRevise() == 0){
            $this->setCoefficientRevise(1);
        }

        return $this->_validationFields($validation, $errorFields);
    }

    public function setProductTypeID($value){
        $this->setValueInt('product_type_id', $value);
    }
    public function getProductTypeID(){
        return $this->getValueInt('product_type_id');
    }

    public function setBarcode($value){
        $this->setValue('barcode', $value);
    }
    public function getBarcode(){
        return $this->getValue('barcode');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setUnitID($value){
        $this->setValueInt('unit_id', $value);
    }
    public function getUnitID(){
        return $this->getValueInt('unit_id');
    }

    public function setQuantityComing($value){
        $this->setValueFloat('quantity_coming', $value);
    }
    public function getQuantityComing(){
        return $this->getValueFloat('quantity_coming');
    }

    public function setCoefficientRevise($value){
        $this->setValueFloat('coefficient_revise', $value);
    }
    public function getCoefficientRevise(){
        return $this->getValueFloat('coefficient_revise');
    }

    public function setQuantityExpense($value){
        $this->setValueFloat('quantity_expense', $value);
    }
    public function getQuantityExpense(){
        return $this->getValueFloat('quantity_expense');
    }

    public function setPriceCost($value){
        $this->setValueFloat('price_cost', $value);
    }
    public function getPriceCost(){
        return $this->getValueFloat('price_cost');
    }

    // Средняя стоимость продукта (по остатку на начало дня приемки) без НДС
    public function setPriceAverage($value){
        $this->setValueFloat('price_average', round($value, 2));
    }
    public function getPriceAverage(){
        return $this->getValueFloat('price_average');
    }

    public function setPriceCostWithoutNDS($value){
        $this->setValueFloat('price_cost_without_nds', $value);
    }
    public function getPriceCostWithoutNDS(){
        return $this->getValueFloat('price_cost_without_nds');
    }

    public function setPricePurchase($value){
        $this->setValueFloat('price_purchase', $value);
    }
    public function getPricePurchase(){
        return $this->getValueFloat('price_purchase');
    }

    // Название
    public function setName($value){
        parent::setName($value);
        $this->setNames($value);
    }

    public function setName1C($value){
        $this->setValue('name_1c', $value);
        $this->setNames($value);
    }
    public function getName1C(){
        return $this->getValue('name_1c');
    }

    public function setNameESF($value){
        $this->setValue('name_esf', $value);
        $this->setNames($value);
    }
    public function getNameESF(){
        return $this->getValue('name_esf');
    }

    public function setMarkup($value){
        $this->setValueFloat('markup', $value);
    }
    public function getMarkup(){
        return $this->getValueFloat('markup');
    }

    public function setIsMarkupPercent($value){
        $this->setValueBool('is_markup_percent', $value);
    }
    public function getIsMarkupPercent(){
        return $this->getValueBool('is_markup_percent');
    }

    public function setNames($name)
    {
        if (Func::_empty($name)) {
            return;
        }

        if (Func::_empty($this->getName())) {
            $this->setName($name);
        }
        if (Func::_empty($this->getName1C())) {
            $this->setName1C($name);
        }
        if (Func::_empty($this->getNameESF())) {
            $this->setNameESF($name);
        }
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
