<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_AddressContact extends Model_Shop_Basic_Object{

	const TABLE_NAME='ct_shop_address_contacts';
	const TABLE_ID = 19;

	public function __construct(){
		parent::__construct(
			array(
				'contact_type_id',
                'shop_address_id',
                'shop_table_rubric_id',
				'city_id',
				'land_id',
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
	public function dbGetElements($shopID = 0, $elements = NULL)
	{
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
					case 'contact_type_id':
						$this->_dbGetElement($this->getContactTypeID(), 'contact_type_id', new Model_ContactType());
						break;
                    case 'shop_address_id':
                        $this->_dbGetElement($this->getShopAddressID(), 'shop_address_id', new Model_Shop_Address());
                        break;
                    case 'shop_table_rubric_id':
                        $this->_dbGetElement($this->getShopTableRubricID(), 'shop_table_rubric_id', new Model_Shop_Table_Rubric());
                        break;
                    case 'land_id':
                        $this->_dbGetElement($this->getLandID(), 'land_id', new Model_Land());
                        break;
                    case 'city_id':
                        $this->_dbGetElement($this->getCityID(), 'city_id', new Model_City());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['land_ids'] = $this->getLandIDsArray();
        }

        return $arr;
    }


	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('shop_address_id', 'max_length', array(':value', 11))
		->rule('shop_table_rubric_id', 'max_length', array(':value', 11))
			->rule('land_id', 'max_length', array(':value', 11))
			->rule('city_id', 'max_length', array(':value', 11))
		->rule('contact_type_id', 'max_length', array(':value', 11));
	
		if ($this->isFindFieldAndIsEdit('shop_address_id')){
			$validation->rule('shop_address_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_table_rubric_id')){
			$validation->rule('shop_table_rubric_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('contact_type_id')){
			$validation->rule('contact_type_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('city_id')){
			$validation->rule('city_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('land_id')){
			$validation->rule('land_id', 'digit');
		}
	
		return $this->_validationFields($validation, $errorFields);
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

	// ID рубрики
	public function setShopTableRubricID($value){
		$this->setValueInt('shop_table_rubric_id', $value);
	}
	public function getShopTableRubricID(){
		return $this->getValueInt('shop_table_rubric_id');
	}

	// ID контакта магазина
	public function setShopAddressID($value){
		$this->setValueInt('shop_address_id', $value);
	}

	public function getShopAddressID(){
		return $this->getValueInt('shop_address_id');
	}

	// Тип контакта (телефона, e-mail, vk  и т.д.)
	public function setContactTypeID($value){
		$this->setValueInt('contact_type_id', $value);
	}

	public function getContactTypeID(){
		return $this->getValueInt('contact_type_id');
	}

    // ID города
    public function setCityID($value){
        $this->setValueInt('city_id', $value);
    }

    public function getCityID(){
        return $this->getValueInt('city_id');
    }

    // ID страны
    public function setLandID($value){
        $this->setValueInt('land_id', $value);
    }

    public function getLandID(){
        return $this->getValueInt('land_id');
    }
}
