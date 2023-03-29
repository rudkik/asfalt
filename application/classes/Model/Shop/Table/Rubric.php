<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Rubric extends Model_Shop_Table_Basic_Object{

	const TABLE_NAME = "ct_shop_table_rubrics";
	const TABLE_ID = 14;

    public function __construct()
    {
        parent::__construct(
            array(
                'order',
                'root_id',
                'path',
                'storage_count',
                'shop_table_select_id',
                'shop_table_unit_id',
                'shop_table_brand_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
    }

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        if ($this->id < 1) {
            $validation->rule('name', 'not_empty');
        }

        $validation->rule('name', 'max_length', array(':value', 250))
            ->rule('path', 'max_length', array(':value', 250))
            ->rule('root_id', 'max_length', array(':value', 11))
            ->rule('shop_table_select_id', 'max_length', array(':value', 11))
            ->rule('shop_table_unit_id', 'max_length', array(':value', 11))
            ->rule('shop_table_brand_id', 'max_length', array(':value', 11))
            ->rule('storage_count', 'max_length', array(':value', 11))
            ->rule('order', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('root_id')) {
            $validation->rule('root_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('order')) {
            $validation->rule('order', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('storage_count')) {
            $validation->rule('storage_count', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('shop_table_select_id')) {
            $validation->rule('shop_table_select_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_table_unit_id')) {
            $validation->rule('shop_table_unit_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_table_brand_id')) {
            $validation->rule('shop_table_brand_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        $arr['info'] = $this->getText();

        return $arr;
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
					case 'root_id':
						$this->_dbGetElement($this->getRootID(), 'root_id', new Model_Shop_Table_Rubric());
						break;
                    case 'shop_table_select_id':
                        $this->_dbGetElement($this->getShopTableSelectID(), 'shop_table_select_id', new Model_Shop_Table_Select(), $shopID);
                        break;
                    case 'shop_table_unit_id':
                        $this->_dbGetElement($this->getShopTableUnitID(), 'shop_table_unit_id', new Model_Shop_Table_Unit(), $shopID);
                        break;
                    case 'shop_table_brand_id':
                        $this->_dbGetElement($this->getShopTableBrandID(), 'shop_table_brand_id', new Model_Shop_Table_Brand(), $shopID);
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    // ID типа выделения
    public function setShopTableSelectID($value){
        $this->setValueInt('shop_table_select_id', $value);
    }
    public function getShopTableSelectID(){
        return $this->getValueInt('shop_table_select_id');
    }

    public function setShopTableUnitID($value){
        $this->setValueInt('shop_table_unit_id', $value);
    }
    public function getShopTableUnitID(){
        return $this->getValueInt('shop_table_unit_id');
    }

    public function setShopTableBrandID($value){
        $this->setValueInt('shop_table_brand_id', $value);
    }
    public function getShopTableBrandID(){
        return $this->getValueInt('shop_table_brand_id');
    }

	// Название каталога
	public function setName($value){
		$this->setValue('name', $value);
	}

	public function getName(){
		return $this->getValue('name');
	}

	// Путь для каталога
	public function setPath($value){
		$this->setValue('path', $value);
	}

	public function getPath(){
		return $this->getValue('path');
	}

    //	Описание каталога (HTML-код)
    public function setText($value){
        $this->setValue('text', $value);
    }

    public function getText(){
        return $this->getValue('text');
    }

	// ID родителя каталога
	public function setRootID($value){
		$this->setValue('root_id', intval($value));
	}

	public function getRootID(){
		return intval($this->getValue('root_id'));
	}

	public function setOrder($value){
		$this->setValue('order', intval($value));
	}
	
	public function getOrder(){
		return intval($this->getValue('order'));
	}

    // количество на складе
    public function setStorageCount($value){
        $this->setValue('storage_count', intval($value));
    }

    public function getStorageCount(){
        return intval($this->getValue('storage_count'));
    }
}
