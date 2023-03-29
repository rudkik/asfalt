<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Formula_Material_Item extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_formula_material_items';
	const TABLE_ID = 106;

	public function __construct(){
		parent::__construct(
			array(
                'shop_formula_material_id',
                'shop_raw_id',
                'shop_material_id',
                'norm',
                'from_at',
                'to_at',
                'is_start',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
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
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
                        break;
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
					case 'shop_formula_material_id':
						$this->_dbGetElement($this->getShopFormulaMaterialID(), 'shop_formula_material_id', new Model_Ab1_Shop_Formula_Material());
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
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_formula_material_id', $validation);
        $this->isValidationFieldFloat('norm', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setNorm($value){
        $this->setValueFloat('norm', $value);
    }
    public function getNorm(){
        return $this->getValueFloat('norm');
    }

    public function setLosses($value){
        $this->setValueFloat('losses', $value);
    }
    public function getLosses(){
        return $this->getValueFloat('losses');
    }

    public function setNormWeight($value){
        $this->setValueFloat('norm_weight', $value);
    }
    public function getNormWeight(){
        return $this->getValueFloat('norm_weight');
    }

    public function setShopRawID($value){
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
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

    public function setFromAt($value){
        $this->setValueDateTime('from_at', $value);
    }
    public function getFromAt(){
        return $this->getValue('from_at');
    }

    public function setToAt($value){
        $this->setValueDateTime('to_at', $value);
    }
    public function getToAt(){
        return $this->getValue('to_at');
    }

    public function setIsStart($value){
        $this->setValueBool('is_start', $value);
    }
    public function getIsStart(){
        return $this->getValueBool('is_start');
    }

    public function setIsSide($value){
        $this->setValueBool('is_side', $value);
    }
    public function getIsSide(){
        return $this->getValueBool('is_side');
    }
}
