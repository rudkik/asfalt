<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Material_Moisture extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_material_moistures';
	const TABLE_ID = 347;

	public function __construct(){
		parent::__construct(
			array(
                'shop_material_id',
                'shop_raw_id',
                'moisture',
                'density',
                'date',
                'quantity',
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
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
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
        $this->isValidationFieldFloat('moisture', $validation);
        $this->isValidationFieldFloat('density', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldInt('shop_raw_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setShopRawID($value){
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
    }

    public function setShopDaughterID($value){
        $this->setValueInt('shop_daughter_id', $value);
    }
    public function getShopDaughterID(){
        return $this->getValueInt('shop_daughter_id');
    }

    public function setShopBranchDaughterID($value){
        $this->setValueInt('shop_branch_daughter_id', $value);
    }
    public function getShopBranchDaughterID(){
        return $this->getValueInt('shop_branch_daughter_id');
    }

    public function setMoisture($value){
        $this->setValueFloat('moisture', $value);
    }
    public function getMoisture(){
        return $this->getValueFloat('moisture');
    }

    public function setDensity($value){
        $this->setValueFloat('density', $value);
    }
    public function getDensity(){
        return $this->getValueFloat('density');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }
}
