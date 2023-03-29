<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Discount extends Model_Shop_Basic_Collations{

	const TABLE_NAME='ct_shop_discounts';
	const TABLE_ID = 24;

	public function __construct(){
		parent::__construct(
			array(
				'discount',
				'is_percent',
				'data',
				'to_at',
				'from_at',
                'discount_type_id',
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

        $validation->rule('discount_type_id', 'max_length', array(':value', 11))
            ->rule('gift_type_id', 'max_length', array(':value', 11))
            ->rule('to_at', 'max_length', array(':value', 20))
            ->rule('from_at', 'max_length', array(':value', 20))
            ->rule('data', 'max_length', array(':value', 650000))
            ->rule('bill_comment', 'max_length', array(':value', 650000))
			->rule('discount', 'max_length', array(':value', 13))
			->rule('is_percent', 'max_length', array(':value', 1));

        if ($this->isFindFieldAndIsEdit('discount_type_id')) {
            $validation->rule('discount_type_id', 'digit');
        }

		if ($this->isFindFieldAndIsEdit('is_percent')) {
			$validation->rule('is_percent', 'digit');
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

		if ($this->isFindFieldAndIsEdit('to_at')) {
			$validation->rule('to_at', 'date');
		}

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['data'] = $this->getDataArray();
		}

		return $arr;
	}
	
	//ID типа акции
	public function setDiscountTypeID($value){
		$this->setValue('discount_type_id', intval($value));
	}

	public function getDiscountTypeID(){
		return intval($this->getValue('discount_type_id'));
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
	
	public function setDiscount($value){
		$this->setValueFloat('discount', $value);
	}

	public function getDiscount(){
		return $this->getValueFloat('discount');
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

	public function setIsPercent($value)
	{
		$this->setValueBool('is_percent', $value);
	}

	public function getIsPercent()
	{
		return $this->getValueBool('is_percent');
	}

    //ID товара
    public function setShopGoodID($value){
        $this->setValue('shop_good_id', intval($value));
    }
    public function getShopGoodID(){
        return intval($this->getValue('shop_good_id'));
    }
}
