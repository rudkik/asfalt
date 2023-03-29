<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Address extends Model_Shop_Basic_Object{
	
	const TABLE_NAME='ct_shop_addresses';
	const TABLE_ID = 18;

	public function __construct(){
		parent::__construct(
			array(
				'map_type_id',
				'work_time',
				'city_id',
				'land_id',
				'is_main_shop',
				'shop_table_rubric_id',
                'land_ids',
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
					case 'land_id':
						$this->_dbGetElement($this->getLandID(), 'land_id', new Model_Land());
						break;
                    case 'city_id':
                        $this->_dbGetElement($this->getCityID(), 'city_id', new Model_City());
                        break;
					case 'shop_table_rubric_id':
						$this->_dbGetElement($this->getShopTableRubricID(), 'shop_table_rubric_id', new Model_Shop_Table_Rubric());
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

		$validation->rule('is_main_shop', 'max_length', array(':value', 1))
			->rule('shop_table_rubric_id', 'max_length', array(':value', 11))
			->rule('is_main_shop', 'range', array(':value', 0, 1))
			->rule('street', 'max_length', array(':value', 100))
			->rule('street_conv', 'max_length', array(':value', 100))
			->rule('house', 'max_length', array(':value', 100))
			->rule('office', 'max_length', array(':value', 100))
			->rule('work_time', 'max_length', array(':value', 650000))
			->rule('comment', 'max_length', array(':value', 650000))
			->rule('map_data', 'max_length', array(':value', 650000))
			->rule('map_type_id', 'max_length', array(':value', 11))
			->rule('city_id', 'max_length', array(':value', 11))
			->rule('land_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('is_main_shop')) {
			$validation->rule('is_main_shop', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('map_type_id')) {
			$validation->rule('map_type_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('city_id')) {
			$validation->rule('city_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('land_id')) {
			$validation->rule('land_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('shop_table_rubric_id')){
			$validation->rule('shop_table_rubric_id', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['work_time'] = $this->getWorkTimeArray();
            $arr['land_ids'] = $this->getLandIDsArray();
        }

        return $arr;
    }

	// ID рубрики
	public function setShopTableRubricID($value){
		$this->setValueInt('shop_table_rubric_id', $value);
	}
	public function getShopTableRubricID(){
		return $this->getValueInt('shop_table_rubric_id');
	}

	// Основной магазин
	public function setIsMainShop($value){
			$this->setValueBool('is_main_shop', $value);
	}
	public function getIsMainShop(){
		return $this->getValueBool('is_main_shop');
	}

	// ID города
    public function setCityID($value){
        $this->setValueInt('city_id', $value);
    }
    public function getCityID(){
        return $this->getValueInt('city_id');
    }

	public function setMapTypeID($value){
		$this->setValueInt('map_type_id', $value);
	}
	public function getMapTypeID(){
		return $this->getValueInt('map_type_id');
	}

	// ID страны
	public function setLandID($value){
		$this->setValueInt('land_id', $value);
	}
	public function getLandID(){
		return $this->getValueInt('land_id');
	}
	
	// Название улицы
	public function setStreet($value){
		$this->setValue('street', $value);
	}
	
	public function getStreet(){
		return $this->getValue('street');
	}
	
	// Угол улицы
	public function setStreetConv($value){
		$this->setValue('street_conv', $value);
	}
	
	public function getStreetConv(){
		return $this->getValue('street_conv');
	}

	// Номер дома
	public function setHouse($value){
		$this->setValue('house', $value);
	}
	
	public function getHouse(){
		return $this->getValue('house');
	}

	// Номер офиса
	public function setOffice($value){
		$this->setValue('office', $value);
	}
	
	public function getOffice(){
		return $this->getValue('office');
	}

    // Комментарии к адресу
    public function setComment($value){
        $this->setValue('comment', $value);
    }

    public function getComment(){
        return $this->getValue('comment');
    }

    public function setMapData($value){
        $this->setValue('map_data', $value);
    }

    public function getMapData(){
        return $this->getValue('map_data');
    }

    // Время работы
    public function setWorkTime($value){
        $this->setValue('work_time', $value);
    }
    public function getWorkTime(){
        return $this->getValue('work_time');
    }
    public function setWorkTimeArray(array $value){
        $this->setValueArray('work_time', $value);
    }
    public function getWorkTimeArray(){
        return $this->getValueArray('work_time');
    }

    public function setLandIDs($value){
        $this->setValue('land_ids', $value);
    }
    public function getLandIDs(){
        return $this->getValue('land_ids');
    }
    public function setLandIDsArray(array $value){
        $this->setValueArray('land_ids', $value);
    }
    public function getLandIDsArray(){
        return $this->getValueArray('land_ids');
    }
}

