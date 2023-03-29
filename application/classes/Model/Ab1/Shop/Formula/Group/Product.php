<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Formula_Group_Product extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_formula_group_products';
	const TABLE_ID = 332;

	public function __construct(){
		parent::__construct(
			array(
                'shop_product_id',
                'shop_formula_product_id',
                'shop_formula_group_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product(), $shopID);
                        break;
                    case 'shop_formula_group_id':
                        $this->_dbGetElement($this->getShopFormulaGroupID(), 'shop_formula_group_id', new Model_Ab1_Shop_Formula_Group(), $shopID);
                        break;
                    case 'shop_formula_product_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_formula_product_id', new Model_Ab1_Shop_Formula_Material(), $shopID);
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
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
        $this->isValidationFieldInt('shop_formula_group_id', $validation);
        $this->isValidationFieldInt('shop_formula_product_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setShopFormulaProductID($value){
        $this->setValueInt('shop_formula_product_id', $value);
    }
    public function getShopFormulaProductID(){
        return $this->getValueInt('shop_formula_product_id');
    }
}
