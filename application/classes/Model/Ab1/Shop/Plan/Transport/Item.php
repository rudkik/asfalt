<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Plan_Transport_Item extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ab_shop_plan_transport_items';
	const TABLE_ID = 233;

	public function __construct(){
		parent::__construct(
			array(
                'shop_plan_transport_id',
                'shop_special_transport_id',
                'count',
                'date',
                'working_shift',
                'is_bsu',
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
					case 'shop_special_transport_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_special_transport_id', new Model_Ab1_Shop_Special_Transport());
						break;
                    case 'shop_plan_transport_id':
                        $this->_dbGetElement($this->getShopPlanTransportID(), 'shop_plan_transport_id', new Model_Ab1_Shop_Plan_Transport);
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
        $this->isValidationFieldInt('shop_special_transport_id', $validation);
        $this->isValidationFieldInt('shop_plan_transport_id', $validation);
        $this->isValidationFieldInt('count', $validation);
        $this->isValidationFieldInt('working_shift', $validation);
        $this->isValidationFieldBool('is_bsu', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSpecialTransportID($value){
        $this->setValueInt('shop_special_transport_id', $value);
    }
    public function getShopSpecialTransportID(){
        return $this->getValueInt('shop_special_transport_id');
    }

    public function setShopPlanTransportID($value){
        $this->setValueInt('shop_plan_transport_id', $value);
    }
    public function getShopPlanTransportID(){
        return $this->getValueInt('shop_plan_transport_id');
    }

    public function setCount($value){
        $this->setValueInt('count', $value);
    }
    public function getCount(){
        return $this->getValueInt('count');
    }

    public function setIsBSU($value){
        $this->setValueBool('is_bsu', $value);
    }
    public function getIsBSU(){
        return $this->getValueBool('is_bsu');
    }

    public function setWorkingShift($value){
        $this->setValueInt('working_shift', $value);
    }
    public function getWorkingShift(){
        return $this->getValueInt('working_shift');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }
}
