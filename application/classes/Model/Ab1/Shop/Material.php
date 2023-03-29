<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Material extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_materials';
	const TABLE_ID = 79;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_material_rubric_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_material_rubric_id':
                        $this->_dbGetElement($this->getShopMaterialRubricID(), 'shop_material_rubric_id', new Model_Ab1_Shop_Material_Rubric(), $shopID);
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
        $this->isValidationFieldInt('shop_material_rubric_id', $validation);
        $validation->rule('name_1c', 'max_length', array(':value', 250))
			->rule('name_site', 'max_length', array(':value', 250))
			->rule('price', 'max_length', array(':value', 14))
			->rule('unit', 'max_length', array(':value', 250))
			->rule('type_1c', 'max_length', array(':value', 250));

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
            $arr['formula_type_ids'] = $this->getFormulaTypeIDsArray();
            $arr['access_formula_type_ids'] = $this->getFormulaTypeIDsArray();
        }

        return $arr;
    }

    public function setAccessFormulaTypeIDs($value){
        $this->setValue('access_formula_type_ids', $value);
    }
    public function getAccessFormulaTypeIDs(){
        return $this->getValue('access_formula_type_ids');
    }
    public function setAccessFormulaTypeIDsArray(array $value){
        $this->setValueArray('access_formula_type_ids', $value, false);
    }
    public function getAccessFormulaTypeIDsArray(){
        return $this->getValueArray('access_formula_type_ids', null, array(), false);
    }

    public function setFormulaTypeIDs($value){
        $this->setValue('formula_type_ids', $value);
    }
    public function getFormulaTypeIDs(){
        return $this->getValue('formula_type_ids');
    }
    public function setFormulaTypeIDsArray(array $value){
        $this->setValueArray('formula_type_ids', $value, false, true);
    }
    public function getFormulaTypeIDsArray(){
        return $this->getValueArray('formula_type_ids', null, array(), false, true);
    }

    public function setShopMaterialRubricID($value){
        $this->setValueInt('shop_material_rubric_id', $value);
    }
    public function getShopMaterialRubricID(){
        return $this->getValueInt('shop_material_rubric_id');
    }

    public function setShopMaterialRubricMakeID($value){
        $this->setValueInt('shop_material_rubric_make_id', $value);
    }
    public function getShopMaterialRubricMakeID(){
        return $this->getValueInt('shop_material_rubric_make_id');
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
}
