<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Production extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_productions';
	const TABLE_ID = 250;

    public function __construct(){
        parent::__construct(
            array(
                'shop_production_rubric_id',
                'price_cost',
                'quantity_expense',
                'quantity_coming',
                'price',
                'barcode',
                'unit_id',
                'shop_product_id',
                'coefficient',
                'coefficient_rubric',
                'weight_kg',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
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
                    case 'shop_production_rubric_id':
                        $this->_dbGetElement($this->getShopProductionRubricID(), 'shop_production_rubric_id', new Model_Magazine_Shop_Production_Rubric(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
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
            ->rule('price', 'max_length', array(':value', 14))
            ->rule('shop_production_rubric_id', 'max_length', array(':value', 11));
        $this->isValidationFieldInt('unit_id', $validation);
        $this->isValidationFieldStr('barcode', $validation, 20);
        $this->isValidationFieldFloat('price_cost', $validation);
        $this->isValidationFieldFloat('quantity_expense', $validation);
        $this->isValidationFieldFloat('quantity_coming', $validation);
        $this->isValidationFieldFloat('coefficient', $validation);
        $this->isValidationFieldFloat('coefficient_rubric', $validation);
        $this->isValidationFieldFloat('weight_kg', $validation);
        $this->isValidationFieldStr('name_esf', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setWeightKG($value){
        $this->setValueFloat('weight_kg', $value);
    }
    public function getWeightKG(){
        return $this->getValueFloat('weight_kg');
    }

    public function setCoefficient($value){
        $this->setValueFloat('coefficient', $value);
    }
    public function getCoefficient(){
        return $this->getValueFloat('coefficient');
    }

    public function setCoefficientRubric($value){
        $this->setValueFloat('coefficient_rubric', $value);
    }
    public function getCoefficientRubric(){
        return $this->getValueFloat('coefficient_rubric');
    }

    public function setBarcode($value){
        $this->setValue('barcode', $value);
    }
    public function getBarcode(){
        return $this->getValue('barcode');
    }

    public function setShopProductionRubricID($value){
        $this->setValueInt('shop_production_rubric_id', $value);
    }
    public function getShopProductionRubricID(){
        return $this->getValueInt('shop_production_rubric_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setUnitID($value){
        $this->setValueInt('unit_id', $value);
    }
    public function getUnitID(){
        return $this->getValueInt('unit_id');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setQuantityComing($value){
        $this->setValueFloat('quantity_coming', $value);
    }
    public function getQuantityComing(){
        return $this->getValueFloat('quantity_coming');
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
}
