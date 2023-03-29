<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Basic_Object extends Model_Basic_Name
{
    public $shopID;

    public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE)
    {
        $overallLanguageFields[] = 'shop_id';

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
    }

    /**
     * получение значение по именя
     * @param string $name
     * @param string $default
     * @return string
     */
    public function getValue($name, $default = '')
    {
        if ($name == 'shop_id'){
            return $this->shopID;
        } else {
            return parent::getValue($name, $default);
        }
    }

    /**
     * изменяет значение по именя
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value) {
        if ($name == 'shop_id'){
            $this->shopID = intval($value) * 1;
        }else{
            parent::setValue($name, $value);
        }
    }

    public function setOriginalValue($name, $value) {
        if ($name == 'shop_id'){
            $this->shopID = intval($value) * 1;
        }else{
            parent::setOriginalValue($name, $value);
        }
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);
        $arr['shop_id'] = $this->shopID;

        return $arr;
    }

    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'shop_id':
                        $this->_dbGetElement($this->shopID, 'shop_id', new Model_Shop());
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

    /**
     * Получение данных для вспомогательного элемента из базы данных
     * и добавление его в массив
     * @param string $field
     * @param Model_Basic_DBObject $model
     */
    protected function _dbGetElement($id, $name, Model_Basic_DBObject $model, $shopID = -1, $defaultLanguageID = 0)
    {
        if($shopID == -1){
            $shopID = $this->shopID;
        }


        if ($id > 0) {
            $model->setDBDriver($this->getDBDriver());
            $model->clear();
            if (($this->languageID > 0) && ($defaultLanguageID < 1)){
                $defaultLanguageID = Model_Language::LANGUAGE_RUSSIAN;
            }

            $model->dbGet($id, $this->languageID, $defaultLanguageID, -1, $shopID);

            $this->setElement($name, $model);
        }
    }

    public function dbGetElement($id, $name, Model_Basic_DBObject $model, $shopID = -1)
    {
        return $this->_dbGetElement($id, $name, $model, $shopID);
    }

    /**
     * удаление записи из базы данных по id
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     */
    public function dbDelete($userID, $languageID = 0, $shopID = 0)
    {
        if($shopID > 0){
            $this->shopID = $shopID;
        }

        $this->_isDBDriver();
        $this->getDBDriver()->deleteObject($this, $userID, $languageID, $this->shopID);
    }

    /**
     * восставновление записи из базы данных по id
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     */
    public function dbUnDelete($userID, $languageID = 0, $shopID = 0)
    {
        if($shopID > 0){
            $this->shopID = $shopID;
        }

        $this->_isDBDriver();
        $this->getDBDriver()->unDeleteObject($this, $userID, $languageID, $this->shopID);
    }

    protected function _preDBSave($languageID, $userID = 0, $shopID = 0){
        if($shopID > 0){
            $this->shopID = $shopID;
        }

        parent::_preDBSave($languageID, $userID);
    }

    /**
     * сохранение записи в базу данных
     * @param int $languageID
     * @param int $userID
     * @param int $shopID
     * @return int
     */
    public function dbSave($languageID = 0, $userID = 0, $shopID = 0)
    {
        $this->_preDBSave($languageID, $userID, $shopID);

        if ($this->isEdit()) {
            if ($this->isTranslate === TRUE) {
                $languageID = $this->languageID;
            } else {
                $languageID = 0;
            }

            $this->_isDBDriver();
            $this->id = $this->getDBDriver()->saveObject($this, $languageID, $this->shopID);

            $this->languageOriginal = $languageID;
        }

        return $this->id;
    }

    /**
     * получение записи из бд по id
     * @param $id
     * @param int $languageID
     * @param int $languageIDDefault
     * @param int $shopID
     * @return bool|void
     */
    function dbGet($id, $languageID = 0, $languageIDDefault = 0, $shopID = 0)
    {
        $id = intval($id);
        if ($id < 1) {
            return FALSE;
        }
        if($this->isTranslate !== TRUE){
            $languageID = 0;
            $languageIDDefault = 0;
        }

        $this->_isDBDriver();
        return $this->getDBDriver()->getObject($id, $this, $languageID, $languageIDDefault, $shopID);
    }

    /**
     * Очищает все данные
     */
    public function clear()
    {
        $this->shopID = 0;

        parent::clear();
    }

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($model instanceof Model_Shop_Basic_Object){
            $this->shopID = $model->shopID;
        }

        parent::copy($model, $isNew);
    }
}