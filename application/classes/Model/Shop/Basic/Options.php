<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Basic_Options extends Model_Shop_Basic_Text{

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

        $validation->rule('options', 'max_length', array(':value', 65000))
            ->rule('image_types', 'max_length', array(':value', 650000))
            ->rule('fields_options', 'max_length', array(':value', 650000));

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['options'] = $this->getOptionsArray();
            $arr['fields_options'] = $this->getFieldsOptionsArray();
            $arr['image_types'] = $this->getImageTypesArray();
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
    public function setOptionsArray(array $value){
        $this->setValueArray('options', $value);
    }
    public function getOptionsArray(){
        return $this->getValueArray('options');
    }

    public function getOptionsValue($field, $default = ''){
        return Arr::path($this->getOptionsArray(), $field, $default);
    }
    public function setOptionsValue($field, $value){
        $options = $this->getOptionsArray();
        $options[$field] = $value;

        return $this->setOptionsArray($options);
    }

    /**
     * Добавление параметра дополнительные поля
     * @param $name
     * @param $value
     * @param bool $isReplace
     */
    public function addParamInOptions($name, $value, $isReplace = TRUE){
        $tmp = $this->getOptionsArray();
        if($isReplace || (!key_exists($name, $tmp))) {
            $tmp[$name] = $value;
        }

        $this->setOptionsArray($tmp);
    }

    /**
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     * @param array $value
     * @param bool $isAddAll
     * @param null $key
     */
    public function addOptionsArray(array $value, $isAddAll = TRUE, $key = null){
        $tmp = $this->getOptionsArray();

        if(empty($key)){
            $list = $tmp;
        }else{
            $list = Arr::path($tmp, $key, []);
            if(!is_array($list)){
                $list = [];
            }
        }

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $list) || empty($list[$k]))) {
                $list[$k] = $v;
            }
        }

        if(!empty($key)) {
            $tmp[$key] = $list;
        }else{
            $tmp = $list;
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
        return $this->getValueArray('fields_options');
    }
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

    // JSON вида картинок
    public function setImageTypes($value){
        $this->setValue('image_types', $value);
    }
    public function getImageTypes(){
        return $this->getValue('image_types');
    }
    public function getImageTypesArray(){
        $tmp = $this->getImageTypes();
        if (empty($tmp)){
            return array();
        }else{
            return json_decode($tmp, TRUE);
        }
    }
    public function setImageTypesArray(array $value, $isFirstLevel = TRUE){
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
                            );
                        }
                    }
                }
            }
        }
        $this->setValueArray('image_types', $options);
    }
}

