<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Plan_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_plan_items';
	const TABLE_ID = 215;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_product_id',
                'quantity',
                'quantity_fact',
                'shop_plan_id',
                'shop_turn_place_id',
                'date_from',
                'date_to',
                'working_shift',
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
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements)){
			foreach($elements as $element){
				switch($element){
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client());
                        break;
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
						break;
                    case 'shop_plan_id':
                        $this->_dbGetElement($this->getShopPlanID(), 'shop_plan_id', new Model_Ab1_Shop_Plan());
                        break;
                    case 'shop_turn_place_id':
                        $this->_dbGetElement($this->getShopTurnPlaceID(), 'shop_turn_place_id', new Model_Ab1_Shop_Turn_Place());
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
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_plan_id', $validation);
        $this->isValidationFieldInt('shop_turn_place_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('quantity_fact', $validation);
        $this->isValidationFieldInt('working_shift', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopPlanID($value){
        $this->setValueInt('shop_plan_id', $value);
    }
    public function getShopPlanID(){
        return $this->getValueInt('shop_plan_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopTurnPlaceID($value){
        $this->setValueInt('shop_turn_place_id', $value);
    }
    public function getShopTurnPlaceID(){
        return $this->getValueInt('shop_turn_place_id');
    }

    public function setWorkingShift($value){
        $this->setValueInt('working_shift', $value);
    }
    public function getWorkingShift(){
        return $this->getValueInt('working_shift');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setQuantityFact($value){
        $this->setValueFloat('quantity_fact', $value);
    }
    public function getQuantityFact(){
        return $this->getValueFloat('quantity_fact');
    }

    public function setDateFrom($value){
        $this->setValueDateTime('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDateTime('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }
}
