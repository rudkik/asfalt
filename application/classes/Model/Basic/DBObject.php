<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basic_DBObject extends Model_Basic_BasicObject
{
    /**
     * ссылка на драйвер к базе данных
     * @var Model_Driver_DBBasicDriver | Model_Driver_MemPgSQL_DBMemPgSQLDriver | Model_Driver_MemMySQL_DBMemMySQLDriver
     */
    private $_driverDB = NULL;

    //id записи базы данных
    public $id = 0;

    //название таблицы
    public $tableName = '';

    // ID таблицы
    public $tableID = 0;

    public $isOldInteger = FALSE;

    // конструктор
    public function __construct($tableName, $tableID)
    {
        $this->tableName = $tableName;
        $this->tableID = $tableID;

        parent::__construct();
    }

    public function isEdit()
    {
        return ($this->id < 1) || parent::isEdit();
    }

    /**
     * получение значение по именя
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getValue($name, $default = '')
    {
        if ($name == 'id') {
            return $this->id;
        }

        return parent::getValue($name, $default);
    }

    /**изменяет значение по именя
     * @param $name
     * @param $value
     */
    public function setValue($name, $value)
    {
        if ($name == 'id') {
            $this->id = intval($value);
        } else {
            parent::setValue($name, $value);
        }
    }

    /**
     * Задаем массив значений модели
     * @param array $fields
     */
    public function setValues(array $fields)
    {
        foreach ($fields as $name => $value){
            $this->setValue($name, $value);
        }
    }

    public function setOriginalValue($name, $value)
    {
        if ($name == 'id') {
            $this->id = intval($value);
        } else {
            parent::setOriginalValue($name, $value);
        }
    }

    public function setOldID($value){
        if($this->isOldInteger){
            $this->setValueInt('old_id', $value);
        }else {
            $this->setValue('old_id', $value);
        }
    }

    public function getOldID(){
        if($this->isOldInteger) {
            return $this->getValueInt('old_id');
        }else{
            return $this->getValue('old_id');
        }
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
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);
        $arr['id'] = $this->id;

        return $arr;
    }

    /**
     * проверка сушествует ли драйвер подключения к базе данных
     */
    protected function _isDBDriver()
    {
        if ((!(is_object($this->_driverDB)) || (is_null($this->_driverDB)))) {
            throw new Kohana_Kohana_Exception(__("Driver DB not found."));
        }
    }

    /**
     * задаем драйвер подключения к БД
     * @param Model_Driver_DBBasicDriver $driver
     */
    public function setDBDriver(Model_Driver_DBBasicDriver $driver)
    {
        $this->_driverDB = $driver;
    }

    /**
     * получаем драйвер подключения к БД
     */
    public function getDBDriver()
    {
        return $this->_driverDB;
    }

    /**
     * удаление записи из базы данных по id
     * @param $userID
     */
    public function dbDelete($userID)
    {
        $this->_isDBDriver();
        $this->_driverDB->deleteObject($this, $userID);
    }

    /**
     * Восстановление после удаление записи из базы данных по id
     * @param $userID
     */
    public function dbUnDelete($userID)
    {
        $this->_isDBDriver();
        $this->_driverDB->unDeleteObject($this, $userID);
    }

    /**
     * сохранение записи в базу данных
     */
    public function dbSave()
    {
        if ($this->isEdit()){
            $this->_isDBDriver();
            $this->id = $this->_driverDB->saveObject($this);
        }

        return $this->id;
    }

    /**
     * получение записи из бд по id
     * @param $id
     * @return bool|Model_Basic_DBObject
     */
    function dbGet($id)
    {
        $id = intval($id);
        if ($id < 1) {
            return FALSE;
        }

        $this->_isDBDriver();
        return $this->_driverDB->getObject($id, $this);
    }

    /**
     * Получение данных для вспомогательного элемента из базы данных
     * и добавление его в массив
     * @param $id
     * @param $name
     * @param Model_Basic_DBObject $model
     */
    protected function _dbGetElement($id, $name, Model_Basic_DBObject $model)
    {
        if ($id > 0) {
            $model->setDBDriver($this->getDBDriver());
            $model->dbGet($id);

            $this->setElement($name, $model);
        }
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null $elements
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
    }

    /**
     * Получение вспомогательного элемента по имени
     * @param string $name
     * @param bool $isLoad
     * @param int $shopID
     * @return Model_Basic_BasicObject | NULL
     */
    public function getElement($name, $isLoad = FALSE, $shopID = 0)
    {
        $result = NULL;
        if (array_key_exists($name, $this->_elements)) {
            $result = $this->_elements[$name];
        } else {
            if ($isLoad) {
                $this->dbGetElements($shopID, array($name));
                if (array_key_exists($name, $this->_elements)) {
                    $result = $this->_elements[$name];
                }
            }
        }

        return $result;
    }

    /**
     * Проверяем поля на целое число
     * @param $name
     * @param Validation $validation
     * @param int $length
     */
    public function isValidationFieldInt($name, Validation $validation, $length = 11)
    {
        $validation->rule($name, 'max_length', array(':value', $length));
        if ($this->isFindFieldAndIsEdit($name)) {
            $validation->rule($name, 'digit');
        }
    }

    /**
     * Проверяем поля на строку
     * @param $name
     * @param Validation $validation
     * @param int $length
     */
    public function isValidationFieldStr($name, Validation $validation, $length = 250)
    {
        $validation->rule($name, 'max_length', array(':value', $length));
    }

    /**
     * Проверяем поля на вещественное число
     * @param $name
     * @param Validation $validation
     * @param int $length
     */
    public function isValidationFieldFloat($name, Validation $validation, $length = 20)
    {
        $validation->rule($name, 'max_length', array(':value', $length));
    }

    /**
     * Проверяем поля на булевое значение
     * @param $name
     * @param Validation $validation
     * @param int $length
     */
    public function isValidationFieldBool($name, Validation $validation)
    {
        $validation->rule($name, 'range', array(':value', 0, 1))
            ->rule($name, 'max_length', array(':value', 1));

        if ($this->isFindFieldAndIsEdit($name)) {
            $validation->rule($name, 'digit');
        }
    }

    /**
     * Проверяем поля на ошибки
     * @param Validation $validation
     * @param array $errorFields - массив ошибок
     * @return bool
     */
    protected function _validationFields(Validation $validation, array &$errorFields)
    {
        $result = $validation->check();

        $errorFields['error'] = !$result;
        $errorFields['error_msg'] = '';

        if (!$result) {
            $errorFields['fields'] = $validation->errors('comments');
            $errorFields['error_msg'] = trim(implode("\r\n", $errorFields['fields']));
        }

        return $result;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return bool
     */
    public function validationFields(array &$errorFields)
    {
        return FALSE;
    }

    /**
     * Очищает все данные
     */
    public function clear()
    {
        $this->id = 0;

        parent::clear();
    }

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($model instanceof Model_Basic_DBObject){
            if(!$isNew){
                $this->id = $model->id;
            }

            $this->_driverDB = $model->_driverDB;
            $this->tableName = $model->tableName;
            $this->tableID = $model->tableID;
            $this->isOldInteger = $model->isOldInteger;
        }

        parent::copy($model, $isNew);
    }
}