<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Ballast_Car_To_Driver extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_ballast_car_to_drivers';
	const TABLE_ID = 223;

	public function __construct(){
		parent::__construct(
			array(
                'shop_ballast_driver_id',
                'shop_ballast_car_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_ballast_driver_id':
                        $this->_dbGetElement($this->getShopBallastDriverID(), 'shop_ballast_driver_id', new Model_Ab1_Shop_Ballast_Driver(), $shopID);
                        break;
                    case 'shop_ballast_car_id':
                        $this->_dbGetElement($this->getShopBallastCarID(), 'shop_ballast_car_id', new Model_Ab1_Shop_Ballast_Car(), $shopID);
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
        $this->isValidationFieldInt('shop_ballast_driver_id', $validation);
        $this->isValidationFieldInt('shop_ballast_car_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBallastDriverID($value){
        $this->setValueInt('shop_ballast_driver_id', $value);
    }
    public function getShopBallastDriverID(){
        return $this->getValueInt('shop_ballast_driver_id');
    }

    public function setShopBallastCarID($value){
        $this->setValueInt('shop_ballast_car_id', $value);
    }
    public function getShopBallastCarID(){
        return $this->getValueInt('shop_ballast_car_id');
    }
}
