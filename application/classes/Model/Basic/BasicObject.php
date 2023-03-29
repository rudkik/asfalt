<?php defined('SYSPATH') or die('No direct script access.');


class Model_Basic_BasicObject extends Model
{
    const FIELD_ELEMENTS = '$elements$';

    public function do_some()
    {
    }

    // список значений
    public $values = array();

    // список  индексов значений
    public $indexValues = array();

    // список вспомогательных элементов
    /**
     * @var Model_Basic_BasicObject[]
     */
    protected $_elements = array();

    // конструктор
    public function __construct()
    {

    }

    /**
     * Есть ли элемент в списке
     * @return boolean
     */
    public function isFindField($name)
    {
        return array_key_exists($name, $this->values);
    }

    /**
     * Есть ли элемент в списке
     * @return boolean
     */
    public function isFindFieldAndIsEdit($name)
    {
        return array_key_exists($name, $this->values) && ($this->values[$name]['new'] !== $this->values[$name]['old']);
    }

    /**
     * Получение вспомогательного элемента по имени
     * @param string $name
     * @return Model_BasicObject|NULL
     */
    public function getElement($name)
    {
        if (array_key_exists($name, $this->_elements)) {
            return $this->_elements[$name];
        } else {
            return NULL;
        }
    }

    /**
     * Изменяет вспомогательного элемента по именя
     * @param string $name
     * @param Model_Basic_BasicObject $value
     */
    public function setElement($name, Model_Basic_BasicObject $value)
    {
        $this->_elements[$name] = $value;
    }

    /**
     * Возвращает массив вспомогательных элементов
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }


    /**
     * получение значение по именя
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getValue($name, $default = '')
    {
        if (array_key_exists($name, $this->values)) {
            return $this->values[$name]['new'];
        } else {
            return $default;
        }
    }

    public function getValueDateTime($name)
    {
        $s = $this->getValue($name);
        if(empty($s)){
            $s = NULL;
        }
        return $s;
    }

    public function getValueDate($name)
    {
        $s = $this->getValue($name);
        if(empty($s)){
            return NULL;
        }
        return date('Y-m-d', strtotime($s));
    }

    /**
     * @param $name
     * @return bool
     */
    public function getValueBool($name)
    {
        return intval($this->getValue($name)) === 1;
    }

    /**
     * @param $name
     * @return int
     */
    public function getValueInt($name)
    {
        return intval($this->getValue($name));
    }

    /**
     * @param $name
     * @return float
     */
    public function getValueFloat($name)
    {
        return floatval($this->getValue($name));
    }

    public function getValueArray($name, $key = NULL, $default = array(), $isJSON = TRUE, $isBeginEndComma = false)
    {
        $tmp = $this->getValue($name);

        if (empty($tmp)){
            return $default;
        }else{
            if ($isJSON) {
                $tmp = json_decode($tmp, TRUE);
            }else{
                if($isBeginEndComma){
                    $tmp = mb_substr($tmp, 1, mb_strlen($tmp) - 2);
                }
                $tmp = explode(',', $tmp);
            }
            if ($key === NULL) {
                return $tmp;
            } else {
                return Arr::path($tmp, $key, $default);
            }
        }
    }

    public function getValueArrayIDs($name)
    {
        $tmp = $this->getValue($name);
        if (empty($tmp)){
            return array ();
        }else{
            return explode(',', $tmp);
        }
    }

    /**
     * @param $name
     * @param array $value
     * @param bool $isAddAll - добавлять все записи или только новые
     */
    public function addValueArray($name, array $value, $isAddAll = TRUE){
        $arr = $this->getValueArray($name);

        foreach($value as $k => $v){
            if($isAddAll || (! key_exists($k, $arr) || empty($tmp[$k]))) {
                $arr[$k] = $v;
            }
        }

        $this->setValueArray($name, $arr);
    }

    /** получение значение по именя
     * Название поля
     * Возвращает значение поля
     */
    public function getValueAndIsEdit($name, &$isEdit)
    {
        if (array_key_exists($name, $this->values)) {
            $isEdit = $this->values[$name]['new'] !== $this->values[$name]['old'];
            return $this->values[$name]['new'];
        } else {
            $isEdit = FALSE;
            return '';
        }
    }

    /**
     * изменяет значение по имени
     * @param $name
     * @param $value
     */
    public function setOriginalValue($name, $value)
    {
        if (!(array_key_exists($name, $this->values))) {
            $this->values[$name] = array(
                'new' => $value,
                'old' => $value,
            );

            // запоминаем ключ в порядковом масиве
            $this->indexValues[] = $name;
        }else {
            $this->values[$name]['old'] = $value;
            $this->values[$name]['new'] = $value;
        }
    }

    /**
     * Получяем оригинальное значение по имени
     * @param $name
     * @param string $default
     * @return string
     */
    public function getOriginalValue($name, $default = '')
    {
        if (array_key_exists($name, $this->values)) {
            return $this->values[$name]['old'];
        }else {
            return $default;
        }
    }

    /**
     * изменяет значение по именя
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value)
    {
        if($value !== NULL) {
            if (is_array($value)){
                $value = json_encode($value);
            }
            $value = trim($value);
        }elseif (is_array($value)){
            if (empty($value)){
                $value = '';
            }else{
                $value = Json::json_encode($value);
            }
        }

        if(! array_key_exists($name, $this->values)){
            $this->values[$name] = array(
                'new' => $value,
                'old' => NULL,
            );

            // запоминаем ключ в порядковом масиве
            $this->indexValues[] = $name;
        }else{
            $this->values[$name]['new'] = $value;
        }
    }

    public function setValueDateTime($name, $value) {
        if(empty($value)){
            $value = null;
        }elseif($value != NULL) {
            $value = date('Y-m-d H:i:s', strtotime($value));
        }
        $this->setValue($name, $value);
    }

    public function setValueTime($name, $value) {
        if($value !== NULL) {
            if(empty($value)){
                $value = NULL;
            }else {
                $value = date('H:i:s', strtotime($value));
            }
        }
        $this->setValue($name, $value);
    }

    public function setValueDate($name, $value) {
        if(empty($value)){
            $value = null;
        }elseif($value != NULL) {
            $value = date('Y-m-d', strtotime($value));
        }
        $this->setValue($name, $value);
    }

    /**
     * @param $name
     * @param $value
     */
    public function setValueInt($name, $value) {
        $value = intval($value);
        $this->setValue($name, $value);
    }

    public function setValueFloat($name, $value) {
        $value = str_replace(',', '.', $value);
        $value = floatval($value);
        $this->setValue($name, $value);
    }

    public function setValueArray($name, array $value, $isJSON = TRUE, $isBeginEndComma = false) {
        if($isJSON) {
            $value = Json::json_encode($value);
        }else{
            $value = implode(',', $value);
            if($isBeginEndComma){
                $value = ',' . $value . ',';
            }
        }
        $this->setValue($name, $value);
    }

    public function setValueArrayIDs($name, array $value) {
        // находим только одинаковые и убираем все меньше 1
        for ($i = count($value); $i < -1; $i--) {
            if (intval($value[$i]) < 1){
                unset($value[$i]);
            }
        }
        $tmp = array_unique($value);
        $value = implode(',', $tmp);

        $this->setValue($name, $value);
    }

    public function setValueBool($name, $value) {
        if (($value === TRUE) || ($value == 1) || ($value === '1') || ($value === 1)) {
            $this->setValue($name, 1);
        } else {
            $this->setValue($name, 0);
        }
    }

    /**
     * изменено ли значение поля по имени
     * Название поля
     * Возвращает true/false
     * @param $name
     * @param bool $checkType
     * @return bool
     */
    public function isEditValue($name, $checkType = true)
    {
        if (array_key_exists($name, $this->values)) {
            if($checkType){
                return $this->values[$name]['new'] !== $this->values[$name]['old'];
            }else{
                return $this->values[$name]['new'] != $this->values[$name]['old'];
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Возвращает количество полей
     * Возвращает
     * количество полей
     */
    public function getCountValues()
    {
        return count($this->indexValues);
    }


    /**
     * получение значение по порядковому номеру
     * Порядковый номер поля
     * Возвращает значение поля
     */
    public function getValueByIndex($index)
    {
        if (array_key_exists($index, $this->indexValues)) {
            return $this->values[$this->indexValues[$index]]['new'];
        } else {
            return '';
        }
    }

    /** получение названия поля по порядковому номеру
     * Порядковый номер поля
     * Возвращает название поля
     */
    public function getNameByIndex($index)
    {
        if (array_key_exists($index, $this->indexValues)) {
            return $this->indexValues[$index];
        } else {
            return '';
        }
    }


    /** получение значение по порядковому номеру
     * Порядковый номер поля
     * Возвращает название поля
     * Возвращает значение поля
     * Возвращает изменено ли поле
     */
    public function getNameAndValue($index, &$name, &$value, &$isEdit)
    {
        if (array_key_exists($index, $this->indexValues)) {
            $tmp = $this->indexValues[$index];

            $name = $tmp;
            $value = $this->values[$tmp]['new'];
            $isEdit = $value !== $this->values[$tmp]['old'];
            return TRUE;
        }

        $name = '';
        $value = '';
        $isEdit = FALSE;

        return FALSE;
    }

    /**
     * Изменен ли список значений
     * Возвращает true/false
     */
    public function isEdit()
    {
        foreach ($this->values as $key => $value) {
            if ((($value['new'] !== $value['old'])) && ((!is_numeric($value['new'])) || (!is_numeric($value['old'])) || ($value['new'] * 1 != $value['old'] * 1))) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Очищает все данные
     */
    public function clear()
    {
        unset($this->indexValues);
        $this->indexValues = array();

        unset($this->values);
        $this->values = array();

        unset($this->_elements);
        $this->_elements = array();
    }

    /**
     * Возвращаем cписок всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = array();
        foreach ($this->values as $key => $value) {
            $arr[$key] = $this->getValue($key);
        }

        // вспомогательные элементы
        if ($isGetElement === TRUE) {
            foreach ($this->_elements as $key => $value) {
                $arr[self::FIELD_ELEMENTS][$key] = $value->getValues(TRUE, $isParseArray);
            }
        }

        return $arr;
    }

    /**
     * Преобразовать объект в массив
     * @param bool $isAddTagValues
     * @return array
     */
    public function __getArray($isAddTagValues = TRUE)
    {
        if($isAddTagValues) {
            $result = array(
                'values' => $this->getValues()
            );
        }else{
            $result = $this->getValues();
        }

        return $result;
    }

    /**
     * Переобразуем из массива в объект
     * @param array $data
     */
    public function __setArray(array $data)
    {
        if(array_key_exists('values', $data)) {
            $data = $data['values'];
        }

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if(self::FIELD_ELEMENTS != $key) {
                    if (is_array($value)) {
                        $value = Json::json_encode($value);
                    }
                }
                $this->setOriginalValue($key, $value);
            }
        }
    }

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($isNew){
            foreach ($model->values as $key => $value) {
                $this->setValue($key, $value['new']);
            }
        }else{
            $this->indexValues = $model->indexValues;
            $this->values = $model->values;
        }

        $this->_elements = $model->_elements;
    }
}
