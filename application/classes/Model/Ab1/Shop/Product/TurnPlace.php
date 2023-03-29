<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_TurnPlace extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_product_turn_places';
	const TABLE_ID = 327;

	public function __construct(){
		parent::__construct(
			array(
                'shop_turn_place_id',
                'from_at',
                'to_at',
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
					case 'shop_turn_place_id':
						$this->_dbGetElement($this->getShopTurnPlaceID(), 'shop_turn_place_id', new Model_Ab1_Shop_Turn_Place(), $shopID);
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
		$validation->rule('shop_turn_place_id', 'max_length', array(':value', 11));

		return $this->_validationFields($validation, $errorFields);
	}

	public function setShopTurnPlaceID($value){
		$this->setValueInt('shop_turn_place_id', $value);
	}
	public function getShopTurnPlaceID(){
		return $this->getValueInt('shop_turn_place_id');
	}

	public function setFromAt($value){
		$this->setValueDateTime('from_at', $value);
	}
	public function getFromAt(){
		return $this->getValue('from_at');
	}

	public function setToAt($value){
		$this->setValueDateTime('to_at', $value);
	}
	public function getToAt(){
		return $this->getValue('to_at');
	}
}
