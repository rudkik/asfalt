<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Stock_Material extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_stock_materials';
	const TABLE_ID = 386;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_client_material_id',
                'shop_material_id',
                'date',
                'quantity',
                'shop_storage_id',
                'shop_making_id',
                'shop_equipment_id',
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
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'shop_client_material_id':
                    $this->_dbGetElement($this->getShopClientMaterialID(), 'shop_client_material_id', new Model_Ab1_Shop_Client_Material(), $shopID);
                    break;
                case 'shop_material_id':
                    $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material());
                    break;
                case 'shop_storage_id':
                    $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
                    break;
                case 'shop_equipment_id':
                    $this->_dbGetElement($this->getShopEquipmentID(), 'shop_equipment_id', new Model_Ab1_Shop_Equipment(), $shopID);
                    break;
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
        $this->isValidationFieldInt('shop_client_material_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_making_id', $validation);
        $this->isValidationFieldInt('shop_equipment_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }
    /**
     * Возвращаем cписок всех переменных
     */

    public function setShopClientMaterialID($value){
        $this->setValueInt('shop_client_material_id', $value);
    }
    public function getShopClientMaterialID(){
        return $this->getValueInt('shop_client_material_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopEquipmentID($value){
        $this->setValueInt('shop_equipment_id', $value);
    }
    public function getShopEquipmentID(){
        return $this->getValueInt('shop_equipment_id');
    }
}
