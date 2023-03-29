<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Table_Basic_Table extends Model_Shop_Table_Basic_Rubric{
    // количество параметров
    const PARAMS_COUNT = 10;

    // типы поля параметры
    const PARAM_TYPE_INT = 1; // целое число
    const PARAM_TYPE_FLOAT = 2; // вещественное число
    const PARAM_TYPE_STR = 3; // строка

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE){
        $overallLanguageFields[] = 'shop_table_select_id';
        $overallLanguageFields[] = 'shop_table_unit_id';
        $overallLanguageFields[] = 'shop_table_brand_id';
        $overallLanguageFields[] = 'shop_table_object_ids';

        for ($i = 1; $i <= self::PARAMS_COUNT; $i++){
            $overallLanguageFields[] = 'shop_table_param_'.$i.'_id';
            $overallLanguageFields[] = 'param_'.$i.'_int';
            $overallLanguageFields[] = 'param_'.$i.'_float';
        }

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
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
                case 'shop_table_select_id':
                    $this->_dbGetElement($this->getShopTableSelectID(), 'shop_table_select_id', new Model_Shop_Table_Select(), $shopID);
                    break;
                case 'shop_table_unit_id':
                    $this->_dbGetElement($this->getShopTableUnitID(), 'shop_table_unit_id', new Model_Shop_Table_Unit(), $shopID);
                    break;
                case 'shop_table_brand_id':
                    $this->_dbGetElement($this->getShopTableBrandID(), 'shop_table_brand_id', new Model_Shop_Table_Brand(), $shopID);
                    break;
                default:
                    $n = strpos($element, 'shop_table_param_');
                    if ($n !== FALSE){
                        $index = intval(str_replace('_id', '', substr($element, strlen('shop_table_param_'))));
                        if ($index > 0){
                            $this->_dbGetElement($this->getShopTableParamID($index), $element, new Model_Shop_Table_Param($index), $shopID);
                        }
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
    protected function _validationFields(Validation $validation, array &$errorFields)
    {
        $this->isValidationFieldInt('shop_table_select_id', $validation);
        $this->isValidationFieldInt('shop_table_unit_id', $validation);
        $this->isValidationFieldInt('shop_table_brand_id', $validation);

        for ($i = 1; $i <= self::PARAMS_COUNT; $i++){
            $this->isValidationFieldInt('shop_table_param_'.$i.'_id', $validation);
            $this->isValidationFieldInt('param_'.$i.'_int', $validation);
            $this->isValidationFieldFloat('param_'.$i.'_float', $validation);
        }

        return parent::_validationFields($validation, $errorFields);
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

    // ID параметры
    public function setShopTableParamID($value, $index = 1){
        $this->setValueInt('shop_table_param_'.$index.'_id', $value);
    }
    public function getShopTableParamID($index = 1){
        return $this->getValueInt('shop_table_param_'.$index.'_id');
    }

    // Параметр целое число
    public function setParamInt($value, $index = 1){
        $this->setValueInt('param_'.$index.'_int', $value);
    }
    public function getParamInt($index = 1){
        return $this->getValueInt('param_'.$index.'_int');
    }

    // Параметр вещественное число
    public function setParamFloat($value, $index = 1){
        $this->setValueFloat('param_'.$index.'_float', $value);
    }
    public function getParamFloat($index = 1){
        return $this->getValueFloat('param_'.$index.'_float');
    }

    // Параметр строка
    public function setParamStr($value, $index = 1){
        $this->setValue('param_'.$index.'_str', $value);
    }
    public function getParamStr($index = 1){
        return $this->getValue('param_'.$index.'_str');
    }

    // ID типа выделения
    public function setShopTableSelectID($value){
        $this->setValueInt('shop_table_select_id', $value);
    }
    public function getShopTableSelectID(){
        return $this->getValueInt('shop_table_select_id');
    }

    public function setShopTableUnitID($value){
        $this->setValueInt('shop_table_unit_id', $value);
    }
    public function getShopTableUnitID(){
        return $this->getValueInt('shop_table_unit_id');
    }

    public function setShopTableBrandID($value){
        $this->setValueInt('shop_table_brand_id', $value);
    }
    public function getShopTableBrandID(){
        return $this->getValueInt('shop_table_brand_id');
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
    public function addShopTableHashtagID($id){
        if ($id < 1){
            return FALSE;
        }
        $arr = $this->getShopTableHashtagIDsArray();
        if (!in_array($id, $arr)){
            $arr[] = $id;
        }
        $this->setShopTableHashtagIDsArray($arr);
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
