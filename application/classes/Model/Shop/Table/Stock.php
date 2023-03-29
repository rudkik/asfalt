<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Stock extends Model_Shop_Table_Basic_Rubric{

	const TABLE_NAME = "ct_shop_table_stocks";
	const TABLE_ID = 76;

    public function __construct()
    {
        parent::__construct(
            array(
                'order',
                'root_id',
                'path',
                'storage_count',
                'barcode',
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

        $validation->rule('path', 'max_length', array(':value', 250))
            ->rule('barcode', 'max_length', array(':value', 50))
            ->rule('root_id', 'max_length', array(':value', 11))
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
                    case 'root_id':
                        $this->_dbGetElement($this->getRootID(), 'root_id', new Model_Shop_Table_Stock());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    public function setBarcode($value){
        $this->setValue('barcode', $value);
    }
    public function getBarcode(){
        return $this->getValue('barcode');
    }

	// Путь для
	public function setPath($value){
		$this->setValue('path', $value);
	}
	public function getPath(){
		return $this->getValue('path');
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
