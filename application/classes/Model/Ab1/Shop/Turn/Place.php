<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Turn_Place extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_turn_places';
	const TABLE_ID = 67;

	public function __construct(){
		parent::__construct(
			array(
                'shop_turn_type_id',
                'shop_subdivision_id',
                'shop_storage_id',
                'shop_heap_id',
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
                    case 'shop_turn_type_id':
                        $this->_dbGetElement($this->getShopTurnTypeID(), 'shop_turn_type_id', new Model_Ab1_Shop_Turn_Type());
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisionID(), 'shop_subdivision_id', new Model_Ab1_Shop_Subdivision());
                        break;
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopStorageID(), 'shop_storage_id', new Model_Ab1_Shop_Storage());
                        break;
                    case 'shop_heap_id':
                        $this->_dbGetElement($this->getShopHeapID(), 'shop_heap_id', new Model_Ab1_Shop_Heap());
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
        $this->isValidationFieldInt('shop_turn_type_id', $validation);
        $this->isValidationFieldInt('shop_subdivision_id', $validation);
        $this->isValidationFieldInt('shop_storage_id', $validation);
        $this->isValidationFieldInt('shop_heap_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTurnTypeID($value){
        $this->setValueInt('shop_turn_type_id', $value);
    }
    public function getShopTurnTypeID(){
        return $this->getValueInt('shop_turn_type_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopHeapID($value){
        $this->setValueInt('shop_heap_id', $value);
    }
    public function getShopHeapID(){
        return $this->getValueInt('shop_heap_id');
    }
}
