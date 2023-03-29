<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Investor_Deposit extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_investor_deposits';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'date',
			'amount',
			'shop_investor_id',
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
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                   case 'shop_investor_id':
                            $this->_dbGetElement($this->getShopInvestorID(), 'shop_investor_id', new Model_AutoPart_Shop_Investor(), $shopID);
                            break;
                 }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $validation->rule('amount', 'max_length', array(':value',13));

        $this->isValidationFieldInt('shop_investor_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopInvestorID($value){
        $this->setValueInt('shop_investor_id', $value);
    }
    public function getShopInvestorID(){
        return $this->getValueInt('shop_investor_id');
    }


}
