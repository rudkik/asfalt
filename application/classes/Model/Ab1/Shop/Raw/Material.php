<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Raw_Material extends Model_Shop_Basic_Options
{
    const TABLE_NAME = 'ab_shop_raw_materials';
    const TABLE_ID = 335;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_raw_id',
                'date',
                'shop_formula_raw_id',
                'quantity',
                'shop_ballast_crusher_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL)
    {
        if (($elements === NULL) || (!is_array($elements))) {
        } else {
            foreach ($elements as $element) {
                switch ($element) {
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
                        break;
                    case 'shop_formula_raw_id':
                        $this->_dbGetElement($this->getShopFormulaRawID(), 'shop_formula_raw_id', new Model_Ab1_Shop_Formula_Raw(), $shopID);
                        break;
                    case 'shop_ballast_crusher_id':
                        $this->_dbGetElement($this->getShopBallastCrusherID(), 'shop_ballast_crusher_id', new Model_Ab1_Shop_Ballast_Crusher(), $shopID);
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
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('shop_formula_raw_id', $validation);
        $this->isValidationFieldInt('shop_ballast_crusher_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopRawID($value)
    {
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID()
    {
        return $this->getValueInt('shop_raw_id');
    }

    public function setShopFormulaRawID($value)
    {
        $this->setValueInt('shop_formula_raw_id', $value);
    }
    public function getShopFormulaRawID()
    {
        return $this->getValueInt('shop_formula_raw_id');
    }

    public function setShopBallastCrusherID($value)
    {
        $this->setValueInt('shop_ballast_crusher_id', $value);
    }
    public function getShopBallastCrusherID()
    {
        return $this->getValueInt('shop_ballast_crusher_id');
    }

    public function setDate($value)
    {
        $this->setValueDate('date', $value);
    }
    public function getDate()
    {
        return $this->getValueDate('date');
    }

    public function setQuantity($value)
    {
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity()
    {
        return $this->getValueFloat('quantity');
    }
    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setShopHeapID($value){
        $this->setValueInt('shop_heap_id', $value);
    }
    public function getShopHeapID(){
        return $this->getValueInt('shop_heap_id');
    }
}
