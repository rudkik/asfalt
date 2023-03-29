<?php defined('SYSPATH') or die('No direct script access.');


class Model_Basic_Table extends Model_Basic_Table_Rubric{

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        $overallLanguageFields[] = 'shop_table_select_id';
        $overallLanguageFields[] = 'shop_table_unit_id';
        $overallLanguageFields[] = 'shop_table_brand_id';
        $overallLanguageFields[] = 'shop_table_object_ids';

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
                    case 'shop_table_select_id':
                        $this->_dbGetElement($this->getShopTableSelectID(), 'shop_table_select_id', new Model_Shop_Table_Select(), $shopID);
                        break;
                    case 'shop_table_unit_id':
                        $this->_dbGetElement($this->getShopTableUnitID(), 'shop_table_unit_id', new Model_Shop_Table_Unit(), $shopID);
                        break;
                    case 'shop_table_brand_id':
                        $this->_dbGetElement($this->getShopTableBrandID(), 'shop_table_brand_id', new Model_Shop_Table_Brand(), $shopID);
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
    { $errorFields['error'] = FALSE; return TRUE;
        $validation = new Validation($this->getValues());

        if ($this->id < 1) {
            $validation->rule('name', 'not_empty');
        }

        $validation->rule('shop_table_select_id', 'max_length', array(':value', 11))
            ->rule('shop_table_unit_id', 'max_length', array(':value', 11))
            ->rule('shop_table_brand_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('shop_table_select_id')) {
            $validation->rule('shop_table_select_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('shop_table_unit_id')) {
            $validation->rule('shop_table_unit_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('shop_table_brand_id')) {
            $validation->rule('shop_table_brand_id', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['shop_table_object_ids'] = $this->getShopTableObjectIDsArray();
        }

        return $arr;
    }

    // ID типа выделения
    public function setShopTableSelectID($value){
        $this->setValue('shop_table_select_id', intval($value));
    }

    public function getShopTableSelectID(){
        return intval($this->getValue('shop_table_select_id'));
    }

    public function setShopTableUnitID($value){
        $this->setValue('shop_table_unit_id', intval($value));
    }

    public function getShopTableUnitID(){
        return intval($this->getValue('shop_table_unit_id'));
    }

    public function setShopTableBrandID($value){
        $this->setValue('shop_table_brand_id', intval($value));
    }

    public function getShopTableBrandID(){
        return intval($this->getValue('shop_table_brand_id'));
    }

    // JSON настройки списка полей
    public function setCollations($value){
        $this->setValue('collations', $value);
    }

    public function getCollations(){
        return $this->getValue('collations');
    }

    // JSON список значений для сопоставления
    public function setCollationsArray(array $value){
        $this->setValueArray('collations', $value);
    }

    public function getCollationsArray(){
        return $this->getValueArray('collations');
    }

    public function addCollationsArray($value){
        $tmp = $this->getCollationsArray();

        if(is_array($value)) {
            foreach ($value as $v) {
                if (array_search($v, $tmp) === FALSE) {
                    $tmp[] = $v;
                }
            }
        }else{
            if (array_search($value, $tmp) === FALSE) {
                $tmp[] = $value;
            }
        }

        $this->setCollationsArray($tmp);
    }

    public function setShopTableObjectIDs($value){
        $this->setValue('shop_table_object_ids', $value);
    }

    public function getShopTableObjectIDs(){
        return $this->getValue('shop_table_object_ids');
    }

    // JSON список значений для сопоставления
    public function setShopTableObjectIDsArray(array $value){
        $this->setValueArray('shop_table_object_ids', $value);
    }

    public function getShopTableObjectIDsArray(){
        return $this->getValueArray('shop_table_object_ids');
    }

    public function addShopTableObjectIDsArray(array $value, $isReplace = TRUE){
        $tmp = $this->getShopTableObjectIDsArray();

        foreach ($value as $k => $v) {
            if ($isReplace || (! key_exists($k, $tmp))) {
                $tmp[$k] = $v;
            }
        }

        $this->setShopTableObjectIDsArray($tmp);
    }

    public function setShopTableHashtagIDsArray(array $value){
        $this->addShopTableObjectIDsArray(array('shop_table_hashtags' => $value));
    }

    public function getShopTableHashtagIDsArray(){
        $tmp = $this->getShopTableObjectIDsArray();
        return Arr::path($tmp, 'shop_table_hashtags', array());
    }

    public function setShopTableFilterIDsArray(array $value){
        $this->addShopTableObjectIDsArray(array('shop_table_filters' => $value));
    }

    public function getShopTableFilterIDsArray(){
        $tmp = $this->getShopTableObjectIDsArray();
        return Arr::path($tmp, 'shop_table_filters', array());
    }

    public function setShopTableChildIDsArray(array $value){
        $this->addShopTableObjectIDsArray(array('shop_table_childs' => $value));
    }

    public function getShopTableChildIDsArray(){
        $tmp = $this->getShopTableObjectIDsArray();
        return Arr::path($tmp, 'shop_table_childs', array());
    }

    public function setShopTableGroupIDsArray(array $value){
        $this->addShopTableObjectIDsArray(array('shop_table_groups' => $value));
    }

    public function getShopTableGroupIDsArray(){
        $tmp = $this->getShopTableObjectIDsArray();
        return Arr::path($tmp, 'shop_table_groups', array());
    }

    public function setShopTableSimilarIDsArray(array $value){
        $this->addShopTableObjectIDsArray(array('shop_table_similars' => $value));
    }

    public function getShopTableSimilarIDsArray(){
        $tmp = $this->getShopTableObjectIDsArray();
        return Arr::path($tmp, 'shop_table_similars', array());
    }
}
