<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Good_To_Operation extends Model_Shop_Basic_Object{

	const TABLE_NAME='ct_shop_good_to_operations';
	const TABLE_ID = 70;

	public function __construct(){
		parent::__construct(
			array(
				'shop_good_id',
				'shop_operation_id',
				'price',
			),
			self::TABLE_NAME,
			self::TABLE_ID,
			FALSE
		);
	}
	
	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());
	
		if ($this->id < 1){
			$validation->rule('shop_good_id', 'not_empty')
				->rule('shop_operation_id', 'not_empty');
		}

	
		$validation->rule('shop_good_id', 'max_length', array(':value', 11))
			->rule('shop_operation_id', 'max_length', array(':value', 11))
			->rule('price', 'max_length', array(':value', 14));

		if ($this->isFindFieldAndIsEdit('shop_good_id')){
			$validation->rule('shop_good_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('shop_operation_id')){
			$validation->rule('shop_operation_id', 'digit');
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
                    case 'shop_good_id':
                        $this->_dbGetElement($this->getShopGoodID(), 'shop_good_id', new Model_Shop_Good());
                        break;
                    case 'shop_operation_id':
                        $this->_dbGetElement($this->getShopOperationtID(), 'shop_operation_id', new Model_Shop_Operation());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    // товар
    public function setShopGoodID($value){
        $this->setValueInt('shop_good_id', $value);
    }
    public function getShopGoodID(){
        return $this->getValueInt('shop_good_id');
    }

    // оператор
    public function setShopOperationID($value){
        $this->setValueInt('shop_operation_id', $value);
    }
    public function getShopOperationtID(){
        return $this->getValueInt('shop_operation_id');
    }

    // цена
    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }
}
