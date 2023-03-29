<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Action extends Model_Shop_Basic_Collations{

	const TABLE_NAME='ct_shop_actions';
	const TABLE_ID = 17;

	public function __construct(){
		parent::__construct(
			array(
				'gift_ids',
				'data',
				'to_at',
				'from_at',
                'action_type_id',
                'gift_type_id',
				'is_run',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}


	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $validation->rule('action_type_id', 'max_length', array(':value', 11))
            ->rule('gift_type_id', 'max_length', array(':value', 11))
            ->rule('to_at', 'max_length', array(':value', 20))
            ->rule('from_at', 'max_length', array(':value', 20))
            ->rule('data', 'max_length', array(':value', 650000))
            ->rule('bill_comment', 'max_length', array(':value', 650000))
            ->rule('gift_ids', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('action_type_id')) {
            $validation->rule('action_type_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('gift_type_id')) {
            $validation->rule('gift_type_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('from_at')) {
            $validation->rule('from_at', 'date');
        }

        if ($this->isFindFieldAndIsEdit('to_at')) {
            $validation->rule('to_at', 'date');
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
			$arr['data'] = $this->getDataArray();
			$arr['gift_ids'] = $this->getGiftIDsArray();
		}

		return $arr;
	}
	
	//ID типа акции
	public function setActionTypeID($value){
		$this->setValue('action_type_id', intval($value));
	}

	public function getActionTypeID(){
		return intval($this->getValue('action_type_id'));
	}

	//ID типа подарка
	public function setGiftTypeID($value){
		$this->setValue('gift_type_id', intval($value));
	}

	public function getGiftTypeID(){
		return intval($this->getValue('gift_type_id'));
	}

	public function setBillComment($value){
		$this->setValue('bill_comment', $value);
	}

	public function getBillComment(){
		return $this->getValue('bill_comment');
	}

	//Время начала акции
	public function setFromAt($value){
		$this->setValueDateTime('from_at',$value);
	}

	public function getFromAt(){
		return $this->getValue('from_at');
	}
	
	//Время окончанияя акции
	public function setToAt($value){
		$this->setValueDateTime('to_at',$value);
	}

	public function getToAt(){
		return $this->getValue('to_at');
	}

	//Данные настройки акции
	public function setData($value){
		$this->setValue('data', $value);
	}

	/*
	 * Массив array(0 => array('id' => '', 'count' => ''))
	 * Массив array('bill_amount' => '')
	 */
	public function getData(){
		return $this->getValue('data');
	}
	
	public function setDataArray(array $value){
		$this->setValueArray('data', $value);
	}
	
	public function getDataArray(){
        return $this->getValueArray('data');
	}
	
	//ID товаров для подарка с количеством
	public function setGiftIDs($value){
		$this->setValue('gift_ids', $value);
	}

	public function getGiftIDs(){
		return $this->getValue('gift_ids');
	}
	
	public function setGiftIDsArray(array $value){
		$this->setValueArray('gift_ids', $value);
	}
	
	public function getGiftIDsArray(){
        return $this->getValueArray('gift_ids');
	}

	// Опубликована ли запись
	public function setIsRun($value)
	{
        $this->setValueBool('is_run', $value);
	}

	public function getIsRun()
	{
		return $this->getValueBool('is_run');
	}
}
