<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Formula_Product_Item extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_formula_product_items';
	const TABLE_ID = 200;

	public function __construct(){
		parent::__construct(
			array(
                'shop_formula_product_id',
                'shop_product_id',
                'shop_material_id',
                'norm',
                'losses',
                'norm_weight',
                'from_at',
                'to_at',
                'is_start',
                'is_side',
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
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Product());
                        break;
                    case 'shop_formula_product_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_formula_product_id', new Model_Ab1_Shop_Formula_Product());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
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
        $this->isValidationFieldInt('shop_formula_product_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldFloat('norm', $validation);
        $this->isValidationFieldFloat('norm_weight', $validation);
        $this->isValidationFieldFloat('losses', $validation);
        $this->isValidationFieldBool('is_start', $validation);
        $this->isValidationFieldBool('is_side', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setNorm($value){
        $this->setValueFloat('norm', $value);
    }
    public function getNorm(){
        return $this->getValueFloat('norm');
    }

    public function setNormWeight($value){
        $this->setValueFloat('norm_weight', $value);
    }
    public function getNormWeight(){
        return $this->getValueFloat('norm_weight');
    }

    public function setLosses($value){
        $this->setValueFloat('losses', $value);
    }
    public function getLosses(){
        return $this->getValueFloat('losses');
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

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
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

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addOptionsArray(array $value, $isAddAll = TRUE, $key = null){
        parent::addOptionsArray($value, $isAddAll);

        $this->setNorm($this->getOptionsValue('norm_percent', $this->getNorm()));
    }
}
