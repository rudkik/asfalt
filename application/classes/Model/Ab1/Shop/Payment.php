<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Payment extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_payments';
    const TABLE_ID = 59;

    public function __construct(){
        parent::__construct(
            array(
                'shop_car_id',
                'shop_cashbox_id',
                'payment_type_id',
                'fiscal_check',
                'is_fiscal_check',
                'shop_client_id',
                'shop_client_contract_id',
                'shop_client_balance_day_id',
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
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_cashbox_id':
                        $this->_dbGetElement($this->getShopCashboxID(), 'shop_cashbox_id', new Model_Ab1_Shop_Cashbox(), $shopID);
                        break;
                    case 'shop_car_id':
                        $this->_dbGetElement($this->getShopCarID(), 'shop_car_id', new Model_Ab1_Shop_Car());
                        break;
                    case 'shop_piece_id':
                        $this->_dbGetElement($this->getShopCarID(), 'shop_piece_id', new Model_Ab1_Shop_Piece());
                        break;
                    case 'payment_type_id':
                        $this->_dbGetElement($this->getPaymentTypeID(), 'payment_type_id', new Model_Ab1_PaymentType());
                        break;
                    case 'shop_client_balance_day_id':
                        $this->_dbGetElement($this->getShopClientBalanceDayID(), 'shop_client_balance_day_id', new Model_Ab1_Shop_Client_Balance_Day(), $shopID);
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
        $validation->rule('shop_car_id', 'max_length', array(':value', 11))
            ->rule('shop_piece_id', 'max_length', array(':value', 11))
            ->rule('number', 'max_length', array(':value', 250))
            ->rule('amount', 'max_length', array(':value', 14));
        $this->isValidationFieldStr('fiscal_check', $validation, 50);
        $this->isValidationFieldBool('is_fiscal_check', $validation);
        $this->isValidationFieldInt('shop_cashbox_id', $validation);
        $this->isValidationFieldInt('payment_type_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_client_balance_day_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCashboxID($value){
        $this->setValueInt('shop_cashbox_id', $value);
    }
    public function getShopCashboxID(){
        return $this->getValueInt('shop_cashbox_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
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

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', round($value, 0));
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setPaymentTypeID($value){
        $this->setValueInt('payment_type_id', $value);
    }
    public function getPaymentTypeID(){
        return $this->getValueInt('payment_type_id');
    }

    public function setFiscalCheck($value){
        $this->setValue('fiscal_check', $value);

        if(!$this->getIsFiscalCheck()){
            $this->setIsFiscalCheck(!Func::_empty($this->getFiscalCheck()));
        }
    }
    public function getFiscalCheck(){
        return $this->getValue('fiscal_check');
    }

    public function setIsFiscalCheck($value){
        $this->setValueBool('is_fiscal_check', $value);
    }
    public function getIsFiscalCheck(){
        return $this->getValueBool('is_fiscal_check');
    }

    public function setShopClientBalanceDayID($value){
        $this->setValueInt('shop_client_balance_day_id', $value);
    }
    public function getShopClientBalanceDayID(){
        return $this->getValueInt('shop_client_balance_day_id');
    }

    public function setCashboxTerminalID($value){
        $this->setValueInt('shop_cashbox_terminal_id', $value);
    }
    public function getCashboxTerminalID(){
        return $this->getValueInt('shop_cashbox_terminal_id');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}