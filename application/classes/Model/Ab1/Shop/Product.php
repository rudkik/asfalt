<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_products';
	const TABLE_ID = 61;

	public function __construct(){
		parent::__construct(
			array(
			    'coefficient_weight_quantity',
                'shop_product_group_id',
                'shop_product_rubric_id',
                'product_type_id',
                'product_view_id',
                'shop_subdivision_id',
                'shop_storage_id',
                'shop_heap_id',
                'shop_product_pricelist_rubric_id',
                'formula_type_ids',
                'shop_material_id',
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
                    case 'shop_product_pricelist_rubric_id':
                        $this->_dbGetElement($this->getShopProductPricelistRubricID(), 'shop_product_pricelist_rubric_id', new Model_Ab1_Shop_Product_Pricelist_Rubric());
                        break;
                    case 'shop_head_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_head_id', new Model_Ab1_Shop_Heap());
                        break;
                    case 'product_type_id':
                        $this->_dbGetElement($this->getProductTypeID(), 'product_type_id', new Model_Ab1_ProductType(), $shopID);
                        break;
                    case 'product_view_id':
                        $this->_dbGetElement($this->getProductTypeID(), 'product_view_id', new Model_Ab1_ProductView(), $shopID);
                        break;
                    case 'shop_product_rubric_id':
                        $this->_dbGetElement($this->getShopProductRubricID(), 'shop_product_rubric_id', new Model_Ab1_Shop_Product_Rubric(), $shopID);
                        break;
                    case 'shop_product_group_id':
                        $this->_dbGetElement($this->getShopProductGroupID(), 'shop_product_group_id', new Model_Ab1_Shop_Product_Group(), $shopID);
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisionID(), 'shop_subdivision_id', new Model_Ab1_Shop_Turn_Type());
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Turn_Type());
                        break;
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material());
                        break;
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
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
            $arr['formula_type_ids'] = $this->getFormulaTypeIDsArray();
        }

        return $arr;
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
			->rule('name_site', 'max_length', array(':value', 250))
            ->rule('price', 'max_length', array(':value', 14))
            ->rule('tare', 'max_length', array(':value', 14))
            ->rule('shop_product_rubric_id', 'max_length', array(':value', 11))
			->rule('unit', 'max_length', array(':value', 250))
            ->rule('coefficient_weight_quantity', 'max_length', array(':value', 8))
			->rule('type_1c', 'max_length', array(':value', 250));


        $this->isValidationFieldStr('name_short', $validation, 30);
        $this->isValidationFieldInt('shop_product_group_id', $validation);
        $this->isValidationFieldInt('product_type_id', $validation);
        $this->isValidationFieldInt('product_view_id', $validation);
        $this->isValidationFieldInt('shop_subdivision_id', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);
        $this->isValidationFieldInt('shop_product_pricelist_rubric_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductPricelistRubricID($value){
        $this->setValueInt('shop_product_pricelist_rubric_id', $value);
    }
    public function getShopProductPricelistRubricID(){
        return $this->getValueInt('shop_product_pricelist_rubric_id');
    }

    public function setCoefficientWeightQuantity($value){
        $this->setValueFloat('coefficient_weight_quantity', $value);
    }
    public function getCoefficientWeightQuantity(){
        return $this->getValueFloat('coefficient_weight_quantity');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setShopProductGroupID($value){
        $this->setValueInt('shop_product_group_id', $value);
    }
    public function getShopProductGroupID(){
        return $this->getValueInt('shop_product_group_id');
    }

    public function setProductTypeID($value){
        $this->setValueInt('product_type_id', $value);
    }
    public function getProductTypeID(){
        return $this->getValueInt('product_type_id');
    }

    public function setProductViewID($value){
        $this->setValueInt('product_view_id', $value);
    }
    public function getProductViewID(){
        return $this->getValueInt('product_view_id');
    }

    public function setType1C($value){
        $this->setValue('type_1c', $value);
    }
    public function getType1C(){
        return $this->getValue('type_1c');
    }

	public function setName1C($value){
		$this->setValue('name_1c', $value);
	}
	public function getName1C(){
		return $this->getValue('name_1c');
	}

	public function setNameSite($value){
		$this->setValue('name_site', $value);
	}
	public function getNameSite(){
		return $this->getValue('name_site');
	}

	public function setPrice($value){
		$this->setValueFloat('price', $value);
	}
	public function getPrice(){
		return $this->getValueFloat('price');
	}

	public function setUnit($value){
		$this->setValue('unit', $value);
	}
	public function getUnit(){
		return $this->getValue('unit');
	}

    public function setTare($value){
        $this->setValueFloat('tare', $value);
    }
    public function getTare(){
        return $this->getValueFloat('tare');
    }

    public function setIsPacked($value){
        $this->setValueBool('is_packed', $value);
    }
    public function getIsPacked(){
        return $this->getValueBool('is_packed');
    }

    public function setNameShort($value){
        $this->setValue('name_short', $value);
    }
    public function getNameShort(){
        return $this->getValue('name_short');
    }

    public function setShopTurnTypeID($value){
        $this->setValueInt('shop_turn_type_id', $value);
    }
    public function getShopTurnTypeID(){
        return $this->getValueInt('shop_turn_type_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopHeapID($value){
        $this->setValueInt('shop_heap_id', $value);
    }
    public function getShopHeapID(){
        return $this->getValueInt('shop_heap_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    // JSON настройки списка полей
    public function setFormulaTypeIDs($value){
        $this->setValue('formula_type_ids', $value);
    }
    public function getFormulaTypeIDs(){
        return $this->getValue('formula_type_ids');
    }
    public function getFormulaTypeIDsArray(){
        return $this->getValueArray('formula_type_ids', NULL, array(), false, true);
    }
    public function setFormulaTypeIDsArray(array $value){
        return $this->setValueArray('formula_type_ids', $value, false, true);
    }
}
