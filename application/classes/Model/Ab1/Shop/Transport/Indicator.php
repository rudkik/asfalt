<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Indicator extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_indicators';
    const TABLE_ID = 396;

    public function __construct(){
        parent::__construct(
            array(
                'is_show_document_indicator',
                'is_expense_fuel',
                'is_calc_wage',
                'is_calc_work_time',
                'autocomplete_type_id',
                'shop_transport_work_id',
                'identifier',
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
                    case 'shop_transport_work_id':
                        $this->_dbGetElement($this->getShopTransportWorkID(), 'shop_transport_work_id', new Model_Ab1_Shop_Transport_Work(), 0);
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
        $this->isValidationFieldBool('is_show_document_indicator', $validation);
        $this->isValidationFieldBool('is_expense_fuel', $validation);
        $this->isValidationFieldBool('is_calc_wage', $validation);
        $this->isValidationFieldBool('is_calc_work_time', $validation);
        $this->isValidationFieldInt('autocomplete_type_id', $validation);
        $this->isValidationFieldInt('shop_transport_work_id', $validation);
        $this->isValidationFieldStr('identifier', $validation, 250);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsShowDocumentIndicator($value){
        $this->setValueBool('is_show_document_indicator', $value);
    }
    public function getIsShowDocumentIndicator(){
        return $this->getValueBool('is_show_document_indicator');
    }

    public function setIsExpenseFuel($value){
        $this->setValueBool('is_expense_fuel', $value);
    }
    public function getIsExpenseFuel(){
        return $this->getValueBool('is_expense_fuel');
    }

    public function setIsCalcWage($value){
        $this->setValueBool('is_calc_wage', $value);
    }
    public function getIsCalcWage(){
        return $this->getValueBool('is_calc_wage');
    }

    public function setIsCalcWorkTime($value){
        $this->setValueBool('is_calc_work_time', $value);
    }
    public function getIsCalcWorkTime(){
        return $this->getValueBool('is_calc_work_time');
    }

    public function setAutocompleteTypeID($value){
        $this->setValueInt('autocomplete_type_id', $value);
    }
    public function getAutocompleteTypeID(){
        return $this->getValueInt('autocomplete_type_id');
    }

    public function setShopTransportWorkID($value){
        $this->setValueInt('shop_transport_work_id', $value);
    }
    public function getShopTransportWorkID(){
        return $this->getValueInt('shop_transport_work_id');
    }

    public function setIndicatorTypeID($value){
        $this->setValueInt('indicator_type_id', $value);
    }
    public function getIndicatorTypeID(){
        return $this->getValueInt('indicator_type_id');
    }

    public function setIdentifier($value){
        $this->setValue('identifier', $value);
    }
    public function getIdentifier(){
        return $this->getValue('identifier');
    }
}
