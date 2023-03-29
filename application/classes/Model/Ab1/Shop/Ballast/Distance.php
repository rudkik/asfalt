<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Ballast_Distance extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_ballast_distances';
	const TABLE_ID = 203;

	public function __construct(){
		parent::__construct(
			array(
                'distance',
                'shop_ballast_distance_tariff_id',
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
     * @param int $shopID
     * @param null $elements
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_ballast_distance_tariff_id':
                        $this->_dbGetElement($this->getShopBallastDistanceTariffID(), 'shop_ballast_distance_tariff_id', new Model_Ab1_Shop_Ballast_Distance_Tariff());
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
        $this->isValidationFieldFloat('distance', $validation);
        $this->isValidationFieldInt('shop_ballast_distance_tariff_id', $validation);
        $this->isValidationFieldFloat('tariff', $validation);
        $this->isValidationFieldFloat('tariff_holiday', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setDistance($value){
        $this->setValueFloat('distance', $value);
    }
    public function getDistance(){
        return $this->getValueFloat('distance');
    }

    public function setShopBallastDistanceTariffID($value){
        $this->setValueFloat('shop_ballast_distance_tariff_id', $value);
    }
    public function getShopBallastDistanceTariffID(){
        return $this->getValueFloat('shop_ballast_distance_tariff_id');
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
}
