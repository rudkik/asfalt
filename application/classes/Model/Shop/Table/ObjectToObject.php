<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Table_ObjectToObject extends Model_Shop_Basic_Object{

	const TABLE_NAME='ct_shop_table_object_to_objects';
	const TABLE_ID = 10;

	public function __construct($tableName = self::TABLE_NAME, $tableID = self::TABLE_ID){
		parent::__construct(
			array(
			    'root_table_id',
                'shop_root_object_id',
                'shop_root_catalog_id',
                'child_table_id',
                'shop_child_object_id',
                'shop_child_catalog_id',
            ),
            $tableName,
            $tableID,
			FALSE
		);

		$this->isAddUpdated = FALSE;
        $this->isAddCreated = FALSE;
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());
	
		if ($this->id < 1){
			$validation->rule('root_table_id', 'not_empty')
				->rule('shop_root_object_id', 'not_empty')
				->rule('shop_root_catalog_id', 'not_empty')
				->rule('child_table_id', 'not_empty')
				->rule('shop_child_object_id', 'not_empty')
				->rule('shop_child_catalog_id', 'not_empty');
		}

	
		$validation->rule('root_table_id', 'max_length', array(':value', 11))
			->rule('shop_root_object_id', 'max_length', array(':value', 11))
			->rule('shop_root_catalog_id', 'max_length', array(':value', 11))
			->rule('child_table_id', 'max_length', array(':value', 11))
			->rule('shop_child_object_id', 'max_length', array(':value', 11))
			->rule('shop_child_catalog_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('root_table_id')){
			$validation->rule('root_table_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_root_object_id')){
			$validation->rule('shop_root_object_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_root_catalog_id')){
			$validation->rule('shop_root_catalog_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('child_table_id')){
			$validation->rule('child_table_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_child_object_id')){
			$validation->rule('shop_child_object_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_child_catalog_id')){
			$validation->rule('shop_child_catalog_id', 'digit');
		}
	
		return $this->_validationFields($validation, $errorFields);
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
                    case 'root_table_id':
                        $this->_dbGetElement($this->getRootTableID(), 'root_table_id', new Model_Table());
                        break;
                    case 'shop_root_object_id':
                        $this->_dbGetElement($this->getShopRootObjectID(), 'shop_root_object_id', Model_ModelList::createModel($this->getRootTableID()));
                        break;
                    case 'shop_root_catalog_id':
                        $this->_dbGetElement($this->getShopRootCatalogID(), 'shop_root_catalog_id', new Model_Shop_Table_Catalog());
                        break;
                    case 'child_table_id':
                        $this->_dbGetElement($this->getChildTableID(), 'child_table_id', new Model_Table());
                        break;
                    case 'shop_child_object_id':
                        $this->_dbGetElement($this->getShopChildObjectID(), 'shop_child_object_id', Model_ModelList::createModel($this->getChildTableID()));
                        break;
                    case 'shop_child_catalog_id':
                        $this->_dbGetElement($this->getShopChildCatalogID(), 'shop_child_catalog_id', new Model_Shop_Table_Catalog());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    //
    public function setRootTableID($value){
        $this->setValue('root_table_id', intval($value));
    }
    public function getRootTableID(){
        return intval($this->getValue('root_table_id'));
    }

    //
    public function setShopRootObjectID($value){
        $this->setValue('shop_root_object_id', intval($value));
    }
    public function getShopRootObjectID(){
        return intval($this->getValue('shop_root_object_id'));
    }

    //
    public function setShopRootCatalogID($value){
        $this->setValue('shop_root_catalog_id', intval($value));
    }
    public function getShopRootCatalogID(){
        return intval($this->getValue('shop_root_catalog_id'));
    }

    //
    public function setChildTableID($value){
        $this->setValue('child_table_id', intval($value));
    }
    public function getChildTableID(){
        return intval($this->getValue('child_table_id'));
    }

    //
    public function setShopChildObjectID($value){
        $this->setValue('shop_child_object_id', intval($value));
    }
    public function getShopChildObjectID(){
        return intval($this->getValue('shop_child_object_id'));
    }

    //
    public function setShopChildCatalogID($value){
        $this->setValue('shop_child_catalog_id', intval($value));
    }
    public function getShopChildCatalogID(){
        return intval($this->getValue('shop_child_catalog_id'));
    }
}
