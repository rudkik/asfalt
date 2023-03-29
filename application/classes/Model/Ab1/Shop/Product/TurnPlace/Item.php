<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Product_TurnPlace_Item extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_product_turn_place_items';
	const TABLE_ID = 328;

	public function __construct(){
		parent::__construct(
			array(
                'shop_product_id',
                'shop_turn_place_id',
                'shop_product_turn_place_id',
                'from_at',
                'to_at',
                'norm',
                'price',
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
                    case 'shop_product_turn_place_id':
                        $this->_dbGetElement($this->getShopProductTurnPlaceID(), 'shop_product_turn_place_id', new Model_Ab1_Shop_Product_TurnPlace());
                        break;
                    case 'shop_turn_place_id':
                        $this->_dbGetElement($this->getShopTurnPlaceID(), 'shop_turn_place_id', new Model_Ab1_Shop_Turn_Place());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
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
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_turn_place_id', $validation);
        $this->isValidationFieldInt('shop_product_turn_place_id', $validation);
        $this->isValidationFieldFloat('norm', $validation);
        $this->isValidationFieldFloat('price', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

	public function setShopProductID($value){
		$this->setValueInt('shop_product_id', $value);
	}
	public function getShopProductID(){
		return $this->getValueInt('shop_product_id');
	}

    public function setShopTurnPlaceID($value){
        $this->setValueInt('shop_turn_place_id', $value);
    }
    public function getShopTurnPlaceID(){
        return $this->getValueInt('shop_turn_place_id');
    }

	public function setShopProductTurnPlaceID($value){
		$this->setValueInt('shop_product_turn_place_id', $value);
	}
	public function getShopProductTurnPlaceID(){
		return $this->getValueInt('shop_product_turn_place_id');
	}

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setNorm($value){
        $this->setValueFloat('norm', $value);
    }
    public function getNorm(){
        return $this->getValueFloat('norm');
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
