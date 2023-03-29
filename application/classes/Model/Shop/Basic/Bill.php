<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Basic_Bill extends Model_Shop_Basic_Options{

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        $overallLanguageFields[] = 'is_paid';
        $overallLanguageFields[] = 'paid_at';
        $overallLanguageFields[] = 'amount';
        $overallLanguageFields[] = 'paid_amount';
        $overallLanguageFields[] = 'shop_paid_type_id';

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
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
                    case 'shop_paid_type_id':
                        $this->_dbGetElement($this->getShopPaidTypeID(), 'shop_paid_type_id', new Model_Shop_PaidType(), $shopID);
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

        $validation->rule('is_paid', 'max_length', array(':value', 1))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('paid_amount', 'max_length', array(':value', 12))
            ->rule('shop_paid_type_id', 'max_length', array(':value', 11))
            ->rule('is_paid', 'range', array(':value', 0, 1));

        if ($this->isFindFieldAndIsEdit('paid_at')) {
            $validation->rule('paid_at', 'date');
        }
        if ($this->isFindFieldAndIsEdit('is_paid')) {
            $validation->rule('is_paid', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('shop_paid_type_id')) {
            $validation->rule('shop_paid_type_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * сохранение записи в базу данных
     * @param int $languageID
     * @param int $userID
     * @param int $shopID
     * @return mixed
     * @throws Kohana_Kohana_Exception
     */
    public function dbSave($languageID = 0, $userID = 0, $shopID = 0)
    {
        $this->_preDBSave(0, $userID, $shopID);

        if ($this->isEdit()) {
            $this->_isDBDriver();
            $this->id = $this->getDBDriver()->saveObject($this, 0, $this->shopID);
        }

        return $this->id;
    }

    // Скидка в процентах
    public function setIsPercent($value){
        $this->setValueBool('is_percent', $value);
        $this->calcAmount();
    }
    public function getIsPercent(){
        return $this->getValueBool('is_percent');
    }

    // Скидка на заказ
    public function setDiscount($value){
        $this->setValueFloat('discount', $value);
        $this->calcAmount();
    }
    public function getDiscount(){
        return $this->getValueFloat('discount');
    }

    public function setPaidAmount($value){
        $this->setValueFloat('paid_amount', $value);
    }
    public function getPaidAmount(){
        return $this->getValueFloat('paid_amount');
    }

    // Тип оплаты заказа
    public function setShopPaidTypeID($value){
        $this->setValueInt('shop_paid_type_id', $value);
    }
    public function getShopPaidTypeID(){
        return $this->getValueInt('shop_paid_type_id');
    }

    // Оплачен ли заказ
    public function setIsPaid($value){
        $this->setValueBool('is_paid', $value);
    }
    public function getIsPaid(){
        return $this->getValueBool('is_paid');
    }

    // Дата оплаты клиентом
    public function setPaidAt($value){
        $this->setValueDateTime('paid_at', $value);
    }
    public function getPaidAt(){
        return $this->getValue('paid_at');
    }

    // Стоимость заказа
    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setGoodsAmount($value){
        $this->setValueFloat('goods_amount', $value);
        $this->calcAmount();
    }
    public function getGoodsAmount(){
        return $this->getValueFloat('goods_amount');
    }

    public function calcAmount(){
        $goodsAmount = $this->getGoodsAmount();

        if($this->getDiscount() != 0){
            if($this->getIsPercent()){
                $goodsAmount = round($goodsAmount / 100 * (100 - $this->getDiscount()));
            }else{
                $goodsAmount = $goodsAmount - $this->getDiscount();
            }
        }

        $this->setAmount($goodsAmount);
    }
}
