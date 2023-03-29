<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Indicator_Formula extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_indicator_formulas';
    const TABLE_ID = 390;

    public function __construct(){
        parent::__construct(
            array(
                'indicator_formula_type_id',
                'formula',
                'number',
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
                    case 'indicator_formula_type_id':
                        $this->_dbGetElement($this->getIndicatorFormulaTypeID(), 'indicator_formula_type_id', new Model_Ab1_Indicator_FormulaType(), 0);
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
        $this->isValidationFieldInt('indicator_formula_type_id', $validation);
        $this->isValidationFieldStr('formula', $validation);
        $this->isValidationFieldStr('number', $validation, 250);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setIndicatorFormulaTypeID($value){
        $this->setValueInt('indicator_formula_type_id', $value);
    }
    public function getIndicatorFormulaTypeID(){
        return $this->getValueInt('indicator_formula_type_id');
    }
    public function setIdentifier($value){
        $this->setValue('number', $value);
    }
    public function getIdentifier(){
        return $this->getValue('number');
    }
    public function setFormula($value){
        $this->setValue('formula', $value);
    }
    public function getFormula(){
        return $this->getValue('formula');
    }
}
