<?php defined('SYSPATH') or die('No direct script access.');


class Model_Basic_SEO extends Model_Basic_Options{

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        $validation->rule('seo', 'max_length', array(':value', 65000));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['seo'] = $this->getSEOArray();
        }

        return $arr;
    }

    // JSON настройки списка полей
    public function setSEO($value){
        $this->setValue('seo', $value);
    }

    public function getSEO(){
        return $this->getValue('seo');
    }

    // JSON настройки списка полей
    public function setSEOArray(array $value, $languageID = Model_Language::LANGUAGE_RUSSIAN, $isTwoLevel = TRUE){
        $seo = $this->getSEOArray();
        foreach($value as $k1 => $v1) {
            if(is_array($v1) && $isTwoLevel) {
                foreach ($v1 as $k => $v) {
                    Arr::set_path($seo, $languageID . '.' . $k1 . $k, $v);
                }
            }else{
                Arr::set_path($seo, $languageID . '.' . $k1, $v1);
            }
        }
        $this->setValueArray('seo', $seo);
    }

    public function getSEOArray(){
        return $this->getValueArray('seo');
    }
}

