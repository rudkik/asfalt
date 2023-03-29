<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client_Balance_Day_Item extends Model_Shop_Basic_Object{

	const TABLE_NAME = 'ab_shop_client_balance_day_items';
	const TABLE_ID = 425;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'amount',
                'shop_client_balance_day_id',
                'shop_car_id',
                'shop_piece_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
            return FALSE;
        }

        foreach($elements as $key => $element){
            if (is_array($element)){
                $element = $key;
            }

            switch ($element) {
                case 'shop_client_id':
                    $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                    break;
                case 'shop_client_balance_day_id':
                    $this->_dbGetElement($this->getShopClientBalanceDayID(), 'shop_client_balance_day_id', new Model_Ab1_Shop_Client_Balance_Day(), $shopID);
                    break;
                case 'shop_car_id':
                    $this->_dbGetElement($this->getShopCarID(), 'shop_car_id', new Model_Ab1_Shop_Car());
                    break;
                case 'shop_piece_id':
                    $this->_dbGetElement($this->getShopPieceID(), 'shop_piece_id', new Model_Ab1_Shop_Piece());
                    break;
            }
        }

        return parent::dbGetElements($shopID, $elements);
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

        return $arr;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldInt('shop_client_balance_day_id', $validation);
        $this->isValidationFieldInt('shop_car_id', $validation);
        $this->isValidationFieldInt('shop_piece_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsAdditionAmount($value){
        $this->setValueBool('is_addition_amount', $value);
    }
    public function getIsAdditionAmount(){
        return $this->getValueBool('is_addition_amount');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', $value);
        $this->setBalance($this->getAmount() - $this->getBlockAmount());
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setShopClientBalanceDayID($value){
        $this->setValueInt('shop_client_balance_day_id', $value);
    }
    public function getShopClientBalanceDayID(){
        return $this->getValueInt('shop_client_balance_day_id');
    }

    public function setShopCarID($value){
        $this->setValueInt('shop_car_id', $value);
    }
    public function getShopCarID(){
        return $this->getValueInt('shop_car_id');
    }

    public function setShopPieceID($value){
        $this->setValueInt('shop_piece_id', $value);
    }
    public function getShopPieceID(){
        return $this->getValueInt('shop_piece_id');
    }
}
