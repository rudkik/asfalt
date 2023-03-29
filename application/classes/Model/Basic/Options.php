<?php defined('SYSPATH') or die('No direct script access.');


class Model_Basic_Options extends Model_Basic_Text{

    const OPTIONS_TYPE_INPUT = 1;
    const OPTIONS_TYPE_TEXTAREA = 2;
    const OPTIONS_TYPE_TEXTAREA_HTML = 3;
    const OPTIONS_TYPE_CHECKBOX = 4;
    const OPTIONS_TYPE_MAP_YANDEX = 5;
    const OPTIONS_TYPE_TABLE = 6;
    const OPTIONS_TYPE_FILE = 7;

    // список данных форм
    //protected $_prefixOptions = array();

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields){
        $validation = new Validation($this->getValues());

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['options'] = $this->getOptionsArray();
            $arr['fields_options'] = $this->getFieldsOptionsArray();
        }

        return $arr;
    }

    // JSON настройки списка полей
    public function setOptions($value){
        $this->setValue('options', $value);
    }

    public function getOptions(){
        return $this->getValue('options');
    }

    // JSON настройки списка полей
    public function setOptionsArray(array $value){
        $this->setValueArray('options', $value);
    }

    public function getOptionsArray(){
        return $this->getValueArray('options');
    }

    public function getOptionsValue($path, $default = NULL){
        return Arr::path($this->getOptionsArray(), $path, $default);
    }

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addOptionsArray(array $value, $isAddAll = TRUE, $key = null){
        $tmp = $this->getOptionsArray();

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $tmp) || empty($tmp[$k]))) {
                $tmp[$k] = $v;
            }
        }

        $this->setOptionsArray($tmp);
    }

    // JSON настройки списка полей
    public function setFieldsOptions($value){
        $this->setValue('fields_options', $value);
    }

    public function getFieldsOptions(){
        return $this->getValue('fields_options');
    }

    public function getFieldsOptionsArray(){
        $tmp = $this->getFieldsOptions();
        if (empty($tmp)){
            return array();
        }else{
            return json_decode($tmp, TRUE);
        }
    }

    // JSON настройки списка полей
    public function setFieldsOptionsArray(array $value, $isFirstLevel = TRUE){
        $options = array();
        if($isFirstLevel) {
            foreach ($value as $field) {
                if ((is_array($field)) && (key_exists('name', $field)) && (key_exists('title', $field))) {
                    $name = $field['name'];
                    $title = $field['title'];
                    if ((!empty($name)) && (!empty($title))) {
                        $options[] = array(
                            'field' => $name,
                            'title' => $title,
                            'type' => Arr::path($field, 'type', ''),
                            'options' => Arr::path($field, 'options', ''),
                        );
                    }
                }
            }
        }else{
            foreach ($value as $firstName => &$firstValue) {
                foreach ($firstValue as &$field) {
                    if ((is_array($field)) && (key_exists('name', $field)) && (key_exists('title', $field))) {
                        $name = $field['name'];
                        $title = $field['title'];
                        if ((!empty($name)) && (!empty($title))) {

                            if(! key_exists($firstName, $options)){
                                $options[$firstName] = array();
                            }

                            $options[$firstName][] = array(
                                'field' => $name,
                                'title' => $title,
                                'type' => Arr::path($field, 'type', ''),
                                'options' => Arr::path($field, 'options', ''),
                            );
                        }
                    }
                }
            }
        }
        $this->setValueArray('fields_options', $options);
    }
}

