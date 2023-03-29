<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Production_Stock extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_production_stocks';
	const TABLE_ID = 283;

    public function __construct(){
        parent::__construct(
            array(
                'shop_production_id',
                'quantity_expense',
                'quantity_coming',
                'quantity_balance',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopProductionID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
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
        $this->isValidationFieldInt('shop_production_id', $validation);
        $this->isValidationFieldFloat('quantity_expense', $validation);
        $this->isValidationFieldFloat('quantity_balance', $validation);
        $this->isValidationFieldFloat('quantity_coming', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductionID($value){
        $this->setValueInt('shop_production_id', $value);
    }
    public function getShopProductionID(){
        return $this->getValueInt('shop_production_id');
    }

    public function setQuantityComing($value){
        $this->setValueFloat('quantity_coming', $value);
        $this->setQuantityBalance($this->getQuantityComing() - $this->getQuantityExpense());
    }
    public function getQuantityComing(){
        return $this->getValueFloat('quantity_coming');
    }

    public function setQuantityExpense($value){
        $this->setValueFloat('quantity_expense', $value);
        $this->setQuantityBalance($this->getQuantityComing() - $this->getQuantityExpense());
    }
    public function getQuantityExpense(){
        return $this->getValueFloat('quantity_expense');
    }

    public function setQuantityBalance($value){
        $this->setValueFloat('quantity_balance', $value);
    }
    public function getQuantityBalance(){
        return $this->getValueFloat('quantity_balance');
    }
}
