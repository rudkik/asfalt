<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Material_Balance extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_material_balances';
	const TABLE_ID = 340;

	public function __construct(){
		parent::__construct(
			array(
                'quantity',
                'shop_subdivision_id',
                'shop_heap_id',
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
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements !== NULL) && (! is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopFormulaProductID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
                    case 'shop_head_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_head_id', new Model_Ab1_Shop_Heap());
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisionID(), 'shop_subdivision_id', new Model_Ab1_Shop_Subdivision());
                        break;
                }
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
        $validation->rule('quantity', 'max_length', array(':value', 12));

        $this->isValidationFieldInt('shop_subdivision_id', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
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
}
