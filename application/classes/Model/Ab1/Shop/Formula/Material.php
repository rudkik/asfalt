<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Formula_Material extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_formula_materials';
	const TABLE_ID = 107;

	public function __construct(){
		parent::__construct(
			array(
                'shop_material_id',
                'wet',
                'contract_number',
                'contract_date',
                'formula_type_id',
                'from_at',
                'to_at',
                'is_start',
                'shop_formula_group_ids',
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
                    case 'formula_type_id':
                        $this->_dbGetElement($this->getFormulaTypeID(), 'formula_type_id', new Model_Ab1_FormulaType(), 0);
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
        $this->isValidationFieldFloat('wet', $validation);
        $this->isValidationFieldInt('formula_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setFormulaTypeID($value){
        $this->setValueInt('formula_type_id', $value);
    }
    public function getFormulaTypeID(){
        return $this->getValueInt('formula_type_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setWet($value){
        $this->setValueFloat('wet', $value);
    }
    public function getWet(){
        return $this->getValueFloat('wet');
    }

    public function setContractNumber($value){
        $this->setValue('contract_number', $value);
    }
    public function getContractNumber(){
        return $this->getValue('contract_number');
    }

    public function setContractDate($value){
        $this->setValueDate('contract_date', $value);
    }
    public function getContractDate(){
        return $this->getValueDateTime('contract_date');
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

    public function setShopFormulaGroupIDs($value){
        $this->setValue('shop_formula_group_ids', $value);
    }
    public function getShopFormulaGroupIDs(){
        return $this->getValue('shop_formula_group_ids');
    }
    public function setShopFormulaGroupIDsArray(array $value){
        $this->setValueArray('shop_formula_group_ids', $value, false);
    }
    public function getShopFormulaGroupIDsArray(){
        return $this->getValueArray('shop_formula_group_ids', null, array(), false);
    }
}
