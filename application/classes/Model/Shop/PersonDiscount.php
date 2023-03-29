<?php defined('SYSPATH') or die('No direct script access.');

class  Model_Shop_PersonDiscount extends  Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_persone_discounts';
	const TABLE_ID = 444;

	public function __construct(){
		parent::__construct(
			array(
                'is_percent',
                'discount',
                'data',
                'to_at',
                'from_at',
				'user_id',
				'phone',
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
                    case 'user_id':
                        $this->_dbGetElement($this->getUserID(), 'user_id', new Model_User());
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

		if ($this->id < 1) {
			$validation->rule('phone', 'not_empty');
		}

		$validation->rule('phone', 'max_length', array(':value', 50))
			->rule('phone', 'not_null')
			->rule('user_id', 'max_length', array(':value', 11))
			->rule('from_at', 'max_length', array(':value', 20))
			->rule('to_at', 'max_length', array(':value', 20))
			->rule('discount', 'max_length', array(':value', 15))
			->rule('data', 'max_length', array(':value', 65000))
			->rule('is_percent', 'max_length', array(':value', 1))
			->rule('is_percent', 'range', array(':value', 0, 1));

		if ($this->isFindFieldAndIsEdit('to_at')) {
			$validation->rule('to_at', 'date');
		}
		if ($this->isFindFieldAndIsEdit('from_at')) {
			$validation->rule('from_at', 'date');
		}
		if ($this->isFindFieldAndIsEdit('is_percent')) {
			$validation->rule('is_percent', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('user_id')) {
			$validation->rule('user_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('is_group')) {
			$validation->rule('is_group', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['shop_table_rubric_ids'] = $this->getShopTableRubricIDsArray();
        }

        return $arr;
    }

	//Данные настройки скидки
	public function setData($value){
		$this->setValue('data',$value);
	}

	public function getData(){
		return $this->getValue('data');
	}

	public function setDataArray($value){
		$this->setValueArray('data', $value);
	}

	public function getDataArray(){
		return $this->getValueArray('data');
	}

	public function setPhone($value){
		$this->setValue('phone', $value);
	}
	public function getPhone(){
		return $this->getValue('phone');
	}

	public function setUserID($value){
		$this->setValueInt('user_id', $value);
	}

	public function getUserID(){
		return $this->getValueInt('user_id');
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

	// Скидка по купону
	public function setDiscount($value){
		$this->setValueFloat('discount');
	}
	public function getDiscount(){
		return $this->getValueFloat('discount');
	}

    // Скидка в процентах
    public function setIsPercent($value){
        $this->setValueBool('is_percent', $value);
    }
    public function getIsPercent(){
        return $this->getValueBool('is_percent');
    }

    public function setShopTableRubricIDsArray($value){
        $this->setValueArray('shop_table_rubric_ids', $value, false, true);
    }
    public function getShopTableRubricIDsArray(){
        return $this->getValueArray('shop_table_rubric_ids', null, [], false, true);
    }
}
