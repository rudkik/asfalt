<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Supplier_Material extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_supplier_materials';
	const TABLE_ID = 387;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_supplier_id',
                'shop_material_id',
                'price',
                'date',
                'amount',
                'quantity'
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
                case 'shop_supplier_id':
                    $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_Ab1_Shop_Supplier(), $shopID);
                    break;
                case 'shop_material_id':
                    $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
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
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('quantity', $validation);


        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

	public function setQuantity($value){
    $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
    return $this->getValueFloat('quantity');
    }

}
