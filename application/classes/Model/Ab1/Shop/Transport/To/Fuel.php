<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_To_Fuel extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_to_fuels';
    const TABLE_ID = 394;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_indicator_formula_id',
                'shop_transport_id',
                'fuel_type_id',
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
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), 0);
                        break;
                    case 'shop_transport_indicator_formula_id':
                        $this->_dbGetElement($this->getShopTransportIndicatorFormulaID(), 'shop_transport_indicator_formula_id', new Model_Ab1_Shop_Transport_Indicator_Formula(), 0);
                        break;
                    case 'fuel_type_id':
                        $this->_dbGetElement($this->getFuelTypeID(), 'fuel_type_id', new Model_Ab1_Fuel_Type(), 0);
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
        $this->isValidationFieldInt('shop_transport_indicator_formula_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldInt('fuel_type_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTransportIndicatorFormulaID($value){
        $this->setValueInt('shop_transport_indicator_formula_id', $value);
    }
    public function getShopTransportIndicatorFormulaID(){
        return $this->getValueInt('shop_transport_indicator_formula_id');
    }
    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }
    public function setFuelTypeID($value){
        $this->setValueInt('fuel_type_id', $value);
    }
    public function getFuelTypeID(){
        return $this->getValueInt('fuel_type_id');
    }

}
