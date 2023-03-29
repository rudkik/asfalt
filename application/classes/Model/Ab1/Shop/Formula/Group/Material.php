<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Formula_Group_Material extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_formula_group_materials';
	const TABLE_ID = 331;

	public function __construct(){
		parent::__construct(
			array(
                'shop_material_id',
                'shop_formula_material_id',
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
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
                    case 'shop_formula_group_id':
                        $this->_dbGetElement($this->getShopFormulaGroupID(), 'shop_formula_group_id', new Model_Ab1_Shop_Formula_Group(), $shopID);
                        break;
                    case 'shop_formula_material_id':
                        $this->_dbGetElement($this->getShopFormulaMaterialID(), 'shop_formula_material_id', new Model_Ab1_Shop_Formula_Material(), $shopID);
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
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_formula_group_id', $validation);
        $this->isValidationFieldInt('shop_formula_material_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopFormulaGroupID($value){
        $this->setValueInt('shop_formula_group_id', $value);
    }
    public function getShopFormulaGroupID(){
        return $this->getValueInt('shop_formula_group_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setShopFormulaMaterialID($value){
        $this->setValueInt('shop_formula_material_id', $value);
    }
    public function getShopFormulaMaterialID(){
        return $this->getValueInt('shop_formula_material_id');
    }
}
