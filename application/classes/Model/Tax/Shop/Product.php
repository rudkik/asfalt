<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Product extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_products';
	const TABLE_ID = 99;

	public function __construct(){
		parent::__construct(
			array(
                'is_service',
                'price',
                'unit_id',
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
                    case 'unit_id':
                        $this->_dbGetElement($this->getUnitID(), 'unit_id', new Model_Tax_Unit());
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
        $validation->rule('is_service', 'max_length', array(':value', 1))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('unit_id', 'max_length', array(':value', 11))
            ->rule('unit_name', 'max_length', array(':value', 100));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setIsService($value){
		$this->setValueBool('is_service', $value);
	}
	public function getIsService(){
		return $this->getValueBool('is_service');
	}

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setUnitName($value){
        $this->setValue('unit_name', $value);
    }
    public function getUnitName(){
        return $this->getValue('unit_name');
    }

    public function setUnitID($value){
        $this->setValueInt('unit_id', $value);
    }
    public function getUnitID(){
        return $this->getValueInt('unit_id');
    }
}
