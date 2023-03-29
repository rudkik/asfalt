<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transportation extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_transportations';
	const TABLE_ID = 348;

	public function __construct(){
		parent::__construct(
			array(
                'shop_ballast_car_id',
                'shop_ballast_driver_id',
                'shop_transportation_place_id',
                'shop_ballast_distance_id',
                'flight',
                'date',
                'tariff',
                'tariff_holiday',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements)){
			foreach($elements as $element){
				switch($element){
                    case 'shop_ballast_car_id':
                        $this->_dbGetElement($this->getShopBallastCarID(), 'shop_ballast_car_id', new Model_Ab1_Shop_Ballast_Car());
                        break;
                    case 'shop_ballast_driver_id':
                        $this->_dbGetElement($this->getShopBallastDriverID(), 'shop_ballast_driver_id', new Model_Ab1_Shop_Ballast_Driver());
                        break;
                    case 'shop_transportation_place_id':
                        $this->_dbGetElement($this->getShopTransportationPlaceID(), 'shop_transportation_place_id', new Model_Ab1_Shop_Transportation_Place());
                        break;
                    case 'shop_ballast_distance_id':
                        $this->_dbGetElement($this->getShopBallastDistanceID(), 'shop_ballast_distance_id', new Model_Ab1_Shop_Ballast_Distance());
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
        $this->isValidationFieldInt('shop_ballast_car_id', $validation);
        $this->isValidationFieldInt('shop_ballast_driver_id', $validation);
        $this->isValidationFieldInt('shop_transportation_place_id', $validation);
        $this->isValidationFieldInt('shop_ballast_distance_id', $validation);
        $this->isValidationFieldFloat('flight', $validation);
        $this->isValidationFieldFloat('tariff', $validation);
        $this->isValidationFieldFloat('tariff_holiday', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBallastCarID($value){
        $this->setValueInt('shop_ballast_car_id', $value);
    }
    public function getShopBallastCarID(){
        return $this->getValueInt('shop_ballast_car_id');
    }

    public function setShopBallastDriverID($value){
        $this->setValueInt('shop_ballast_driver_id', $value);
    }
    public function getShopBallastDriverID(){
        return $this->getValueInt('shop_ballast_driver_id');
    }

    public function setShopTransportationPlaceID($value){
        $this->setValueInt('shop_transportation_place_id', $value);
    }
    public function getShopTransportationPlaceID(){
        return $this->getValueInt('shop_transportation_place_id');
    }

    public function setShopBallastDistanceID($value){
        $this->setValueInt('shop_ballast_distance_id', $value);
    }
    public function getShopBallastDistanceID(){
        return $this->getValueInt('shop_ballast_distance_id');
    }

    public function setShopWorkShiftID($value){
        $this->setValueInt('shop_work_shift_id', $value);
    }
    public function getShopWorkShiftID(){
        return $this->getValueInt('shop_work_shift_id');
    }

    public function setFlight($value){
        $this->setValueFloat('flight', $value);
    }
    public function getFlight(){
        return $this->getValueFloat('flight');
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setTariff($value){
        $this->setValueFloat('tariff', $value);
    }
    public function getTariff(){
        return $this->getValueFloat('tariff');
    }

    public function setTariffHoliday($value){
        $this->setValueFloat('tariff_holiday', $value);
    }
    public function getTariffHoliday(){
        return $this->getValueFloat('tariff_holiday');
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }

    public function setShopTransportWaybillID($value){
        $this->setValueInt('shop_transport_waybill_id', $value);
    }
    public function getShopTransportWaybillID(){
        return $this->getValueInt('shop_transport_waybill_id');
    }
}
