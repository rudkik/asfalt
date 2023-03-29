<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basic_LanguageObject extends Model_Basic_DBGlobalObject{
    // язык записи
	public $languageID = 0;
    // какой язык является по умолчанию
	public $languageIDDefault = Model_Language::LANGUAGE_RUSSIAN;
	// оригинальный язык
    public $languageOriginal = 0;

	// общие поля по языкам
	public $overallLanguageFields = array();

	// переводится ли запись
	public $isTranslate = TRUE;

    /**
     * Model_Basic_LanguageObject constructor.
     * @param array $overallLanguageFields - Массив общий полей для всех
     * @param $tableName
     * @param $tableID
     * @param bool $isTranslate
     */
	public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE)
	{
        array_push($overallLanguageFields, 'is_translates');

		$this->overallLanguageFields = $overallLanguageFields;
		$this->isTranslate = $isTranslate;

		parent::__construct($tableName, $tableID);
	}

    /**
     * Изменен ли список значений
     * Возвращает true/false
     */
    public function isEdit()
    {
        if($this->languageID != $this->languageOriginal){
            return TRUE;
        }
        return parent::isEdit();
    }

    /**
     * изменено ли значение поля по именя
     * Название поля
     * Возвращает true/false
     * @param $name
     * @param $checkType
     * @return bool
     */
    public function isEditValue($name, $checkType = true)
    {
        if($this->languageID != $this->languageOriginal){
            return TRUE;
        }
        return parent::isEditValue($name, $checkType);
    }

	/**
	 * изменяет значение по именя
	 * Название поля
	 * Значение поля
	 */
	public function setValue($name, $value) {
		if ($name == 'language_id'){
			$this->languageID = intval($value);
		}else{
			parent::setValue($name, $value);
		}
	}

	public function setOriginalValue($name, $value) {
		if ($name == 'language_id'){
			$this->languageID = intval($value);
			$this->languageOriginal = $this->languageID;
		}else{
			parent::setOriginalValue($name, $value);
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
		$arr['language_id'] = $this->languageID;

        if($isParseArray === TRUE) {
            $arr['is_translates'] = $this->getIsTranslatesArray();
        }

        return $arr;
	}

	/**
	 * Получение данных для вспомогательного элемента из базы данных
	 * и добавление его в массив
	 * @param string $field
	 * @param Model_Basic_DBObject $model
	 */
	protected function _dbGetElement($id, $name, Model_Basic_DBObject $model)
	{
		if ($id > 0) {
			$model->setDBDriver($this->getDBDriver());
			$model->dbGet($id, $this->languageID);

			$this->setElement($name, $model);
		}
	}

    /**
     * Удаление записи из базы данных по id, если задан язык, то удаляем только один язык
     * @param $userID
     * @param int $languageID
     */
	public function dbDelete($userID, $languageID = 0)
	{
        $this->_isDBDriver();
        $this->getDBDriver()->deleteObject($this, $userID, $languageID);
	}

    /**
     * Восстановление записи из базы данных по id, если задан язык, то удаляем только один язык
     * @param $userID
     * @param int $languageID
     */
	public function dbUnDelete($userID, $languageID = 0)
	{
        $this->_isDBDriver();
        $this->getDBDriver()->unDeleteObject($this, $userID, $languageID);
	}

	protected function _preDBSave($languageID){
		if($languageID > 0){
			$this->languageID = $languageID;
		}
	}

    /**
     * сохранение записи в базу данных
     * @param int $languageID
     * @param int $userID
     * @return int
     */
	public function dbSave($languageID = 0, $userID = 0)
	{
        $this->_preDBSave($languageID);

        if ($this->isEdit()) {
            if($this->isTranslate === TRUE){
                $languageID = $this->languageID;
            }else{
                $languageID = 0;
            }

            parent::dbSave($languageID, $userID);

            $this->languageOriginal = $languageID;
        }

		return $this->id;
	}

    /**
     * получение записи из бд по id
     * @param $id
     * @param int $languageID
     * @param int $languageIDDefault
     * @return bool|void
     */
	function dbGet($id, $languageID = 0, $languageIDDefault = 0)
	{
		if(!$this->isTranslate){
			$languageID = 0;
			$languageIDDefault = 0;
		}elseif($languageID < 1){
			$languageID = $this->languageIDDefault;
		}

		$id = intval($id);
		if ($id < 1) {
			return FALSE;
		}

        return parent::dbGet($id, $languageID, $languageIDDefault);
	}

    public function setIsTranslates($value){
        $this->setValue('is_translates', $value);
    }
    public function getIsTranslates(){
        return $this->getValue('is_translates');
    }
    public function setIsTranslatesArray(array $value){
        $this->setValueArray('is_translates', $value);
    }
    public function getIsTranslatesArray(){
        return $this->getValueArray('is_translates');
    }

    /**
     * Задаем есть ли перевод текущему языку и дополняем языки из настроек магазина
     * @param $isTranslate
     * @param $languageID
     * @param array $shopLanguages
     */
    public function setIsTranslatesCurrentLanguage($isTranslate, $languageID, array $shopLanguages = array()){
        $isTranslates = $this->getIsTranslatesArray();

        foreach ($shopLanguages as $shopLanguage) {
            if (!key_exists($shopLanguage, $isTranslates)) {
                $isLanguages[$shopLanguage] = FALSE;
            }
        }

        $isTranslates[$languageID] = $isTranslate;
        $this->setIsTranslatesArray($isTranslates);
    }

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($model instanceof Model_Basic_LanguageObject){
            $this->languageID = $model->languageID;
            $this->languageIDDefault = $model->languageIDDefault;
            $this->languageOriginal = $model->languageOriginal;
            $this->overallLanguageFields  = $model->overallLanguageFields ;
            $this->isTranslate = $model->isTranslate;
        }

        parent::copy($model, $isNew);
    }
}

