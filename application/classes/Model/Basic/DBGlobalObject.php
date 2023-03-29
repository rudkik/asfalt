<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basic_DBGlobalObject extends Model_Basic_DBObject{

	// глобальный id записи базы данных
	public $globalID = 0;

    public function isEdit()
    {
        return ($this->globalID < 1) || parent::isEdit();
    }

    /**
     * сохранение записи в базу данных
     */
    public function dbSave()
    {
        if ($this->isEdit()){
            $this->_isDBDriver();
            $this->id = $this->getDBDriver()->saveObject($this);
        }

        return $this->id;
    }

	/**
	 * изменяет значение по именя
	 * Название поля
	 * Значение поля
	 */
	public function setValue($name, $value) {
		if ($name == 'global_id'){
			$this->globalID = intval($value);
		}else{
			parent::setValue($name, $value);
		}
	}

	public function setOriginalValue($name, $value) {
		if ($name == 'global_id'){
			$this->globalID = intval($value);
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
		$arr['global_id'] = $this->globalID;

		return $arr;
	}

	/**
	 * Получение записи по глобальному ID
	 * @param $id
	 * @return bool
	 * @throws Kohana_Kohana_Exception
	 */
	public function dbGetByGlobalID($globalID){
		$globalID = intval($globalID);
		if ($globalID < 1){
			return FALSE;
		}
		
		$this->_isDBDriver();
		return $this->getDBDriver()->getObjectByGlobalID($globalID, $this);
	}

	public function clear()
	{
		$this->globalID = 0;

		parent::clear();
	}

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($model instanceof Model_Basic_DBGlobalObject){
            if(!$isNew){
                $this->globalID = $model->globalID;
            }
        }

        parent::copy($model, $isNew);
    }
}

