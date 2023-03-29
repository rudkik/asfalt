<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Car extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_cars';
	const TABLE_ID = 195;

	public function __construct(){
		parent::__construct(
			array(
				'price_old',
                'price',
				'shop_mark_id',
				'shop_model_id',
				'production_land_id',
				'location_land_id',
				'location_city_id',
                'currency_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

        $this->isAddUUID = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements)){
			foreach($elements as $element){
				switch($element){
                    case 'currency_id':
                        $this->_dbGetElement($this->getCurrencyID(), 'currency_id', new Model_Currency());
                        break;
                    case 'shop_mark_id':
                        $this->_dbGetElement($this->getShopMarkID(), 'shop_mark_id', new Model_Shop_Mark());
                        break;
                    case 'shop_model_id':
                        $this->_dbGetElement($this->getShopModelID(), 'shop_model_id', new Model_Shop_Model());
                        break;
                    case 'production_land_id':
                        $this->_dbGetElement($this->getProductionLandID(), 'production_land_id', new Model_Land());
                        break;
                    case 'location_land_id':
                        $this->_dbGetElement($this->getLocationLandID(), 'location_land_id', new Model_Land());
                        break;
                    case 'location_city_id':
                        $this->_dbGetElement($this->getLocationCityID(), 'location_city_id', new Model_City());
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

        $this->isValidationFieldFloat('price_old', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldInt('shop_mark_id', $validation);
        $this->isValidationFieldInt('shop_model_id', $validation);
        $this->isValidationFieldInt('production_land_id', $validation);
        $this->isValidationFieldInt('location_land_id', $validation);
        $this->isValidationFieldInt('location_city_id', $validation);
        $this->isValidationFieldInt('currency_id', $validation);

		return $this->_validationFields($validation, $errorFields);
	}

    // Старая цена
    public function setPriceOld($value){
        $this->getValueFloat('price_old', $value);
    }
    public function getPriceOld(){
        return $this->getValueFloat('price_old');
    }

    // Цена
    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    // ID страны производства
    public function setProductionLandID($value){
        $this->setValueInt('production_land_id', $value);
    }
    public function getProductionLandID(){
        return $this->getValueInt('production_land_id');
    }

    // ID местонахождения страна
    public function setLocationLandID($value){
        $this->setValueInt('location_land_id', $value);
    }
    public function getLocationLandID(){
        return $this->getValueInt('location_land_id');
    }

    // ID местонахождения город
    public function setLocationCityID($value){
        $this->setValueInt('location_city_id', $value);
    }
    public function getLocationCityID(){
        return $this->getValueInt('location_city_id');
    }

    // ID модель
    public function setShopModelID($value){
        $this->setValueInt('shop_model_id', $value);
    }
    public function getShopModelID(){
        return $this->getValueInt('shop_model_id');
    }

    // ID марка
    public function setShopMarkID($value){
        $this->setValueInt('shop_mark_id', $value);
    }
    public function getShopMarkID(){
        return $this->getValueInt('shop_mark_id');
    }

    public function setNameTotal($value){
        $this->setValue('name_total', $value);
    }
    public function getNameTotal(){
        return $this->getValue('name_total');
    }

    // ID курса валют
    public function setCurrencyID($value){
        $this->setValueInt('currency_id', $value);
    }
    public function getCurrencyID(){
        return $this->getValueInt('currency_id');
    }
}
