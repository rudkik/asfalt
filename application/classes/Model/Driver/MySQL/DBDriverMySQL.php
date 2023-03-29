<?php defined('SYSPATH') or die('No direct script access.');

class  Model_Driver_MySQL_DBDriverMySQL extends Model_Driver_DBBasicDriver{

	const WRITE_LOGS = TRUE;

	private function _writeLogs($select){
		if (!self::WRITE_LOGS){
			return FALSE;
		}

		$select = Date::formatted_time('now').': '.$select;

		try {
			file_put_contents(APPPATH.'logs'.DIRECTORY_SEPARATOR.'mysql-select.txt', $select."\r\n" , FILE_APPEND);
		} catch (Exception $e) {
		}

		return TRUE;
	}

    /**
     * получение записи
     * @param $id
     * @param Model_Basic_DBObject $basicObject
     * @param int $languageID
     * @param int $languageIDDefault
     * @param int $shopID
     * @return bool
     */
	public function getObject($id, Model_Basic_DBObject $basicObject, $languageID = 0, $languageIDDefault = 0, $shopID = 0)
	{
		$id = intval($id);
		if ($id < 1) {
			return FALSE;
		}

		$sql = 'id = :id';
		if ($languageID > 0) {
			$sql = $sql . ' AND (language_id = :language_id)';
		}
        if ($shopID > 0) {
            $sql = $sql . ' AND (shop_id = :shop_id)';
        }

		$query = DB::query(Database::SELECT, 'SELECT * FROM ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' WHERE ' . $sql);
		$query->param(':id', intval($id));
		$query->param(':language_id', intval($languageID));
        $query->param(':shop_id', intval($shopID));

		// запись в лог
		$this->_writeLogs($query->__toString());
		$data = $query->execute();

		$basicObject->clear();
		if (! is_array($data->current())) {
			if(($languageID != $languageIDDefault) && ($languageIDDefault > 0)){
				$query->param(':language_id', intval($languageIDDefault));

				// запись в лог
				$this->_writeLogs($query->__toString());
				$data = $query->execute();
			}
		}

		if (is_array($data->current())) {
			foreach ($data->current() as $key => $value) {
				if($value !== NULL){
					$value = Helpers_DB::htmlspecialchars_decode($value);
				}
				$basicObject->setOriginalValue($key, $value);
			}
		} else {
			return FALSE;
		}
		return TRUE;
	}

    /**
     * добавление записи
     * @param Model_Basic_DBObject $basicObject
     * @param $languageID
     * @param $shopID
     * @return int
     */
	private function _insertObject(Model_Basic_DBObject $basicObject, $languageID, $shopID)
	{
		if($basicObject->getCountValues() < 1){
			return 0;
		}

		$names = '';
		$values = '';
		for ($i = 0; $i < $basicObject->getCountValues(); $i++){
			$basicObject->getNameAndValue($i, $name, $value, $isEdit);

			$names .=  Helpers_DB::htmlspecialchars($name, '`') . ', ';
			$values .=  Helpers_DB::htmlspecialchars($value, "'") . ", ";
		}

		if($languageID > 0){
			$names .= '`language_id`, ';
			$values .= Helpers_DB::htmlspecialchars(intval($languageID), "'") . ", ";
		}
        if($shopID > 0){
            $names .= '`shop_id`, ';
            $values .=  Helpers_DB::htmlspecialchars(intval($shopID), "'" ) . ", ";
        }

		$names = mb_substr($names, 0, -2);
		$values = mb_substr($values, 0, -2);

		//добавляем записи в БД
		$query = DB::query(Database::INSERT, 'INSERT INTO '.Helpers_DB::htmlspecialchars($basicObject->tableName)
			.' ('.$names.') VALUES ('.$values.') ');

        // запись в лог
        $this->_writeLogs($query->__toString());
        $query->execute();

        $query = DB::query(Database::SELECT, 'SELECT LAST_INSERT_ID() as global_id;');
        $data = $query->execute();
        $basicObject->globalID = $data[0]['global_id'];
        $basicObject->id = $basicObject->globalID;

        $query = DB::query(Database::UPDATE, 'UPDATE '.Helpers_DB::htmlspecialchars($basicObject->tableName).' SET id=:id WHERE global_id=:id;');
        $query->param(':id', intval($basicObject->globalID));
        $query->execute();

		return $basicObject->id;
	}

    /**
     * изменение записи всех языков получаем изменяемые части
     * @param Model_Basic_LanguageObject $basicObject
     * @param $shopID
     * @return bool
     */
	private function _updateObjectLanguages(Model_Basic_LanguageObject $basicObject, $shopID)
	{
		$names = '';
		$fields = $basicObject->overallLanguageFields;
		foreach ($fields as $name) {
			$value = $basicObject->getValueAndIsEdit($name, $isEdit);
			if ($isEdit){
				$names .= Helpers_DB::htmlspecialchars($name, '`')." = ".Helpers_DB::htmlspecialchars($value, "'").", ";
			}

		}
		if(empty($names)){
			return FALSE;
		}

		$names = mb_substr($names, 0, -2);

		$sql = 'id = :id';
        if($shopID > 0){
            $sql =  $sql.' AND (shop_id = :shop_id)';
        }
		$query = DB::query(Database::UPDATE, 'UPDATE '.Helpers_DB::htmlspecialchars($basicObject->tableName).' SET '.$names.' WHERE '.$sql.';');
		$query->param(':id', intval($basicObject->id));
        $query->param(':shop_id', intval($shopID));

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();
	}

    /**
     * изменение записи
     * @param Model_Basic_LanguageObject $basicObject
     * @param $languageID
     * @param $shopID
     * @return bool
     */
	private function _updateObject(Model_Basic_LanguageObject $basicObject, $languageID, $shopID)
	{
		$names = '';
		for ($i = 0; $i < $basicObject->getCountValues(); $i++){
			$basicObject->getNameAndValue($i, $name, $value, $isEdit);
			if ($isEdit){
				$names .= Helpers_DB::htmlspecialchars($name, '`')." = ".Helpers_DB::htmlspecialchars($value,"'").", ";
			}

		}
		if(empty($names)){
			return FALSE;
		}

		$names = mb_substr($names, 0, -2);

		$sql = '(id = :id)';
		if($basicObject->globalID > 0){
			$sql =  $sql.' AND (global_id = :global_id)';
		}
		if($languageID > 0){
			$sql =  $sql.' AND (language_id = :language_id)';
		}
        if($shopID > 0){
            $sql =  $sql.' AND (shop_id = :shop_id)';
        }

		$query = DB::query(Database::UPDATE, 'UPDATE '.Helpers_DB::htmlspecialchars($basicObject->tableName).' SET '.$names.' WHERE '.$sql.';');
		$query->param(':global_id', intval($basicObject->globalID));
		$query->param(':id', intval($basicObject->id));
		$query->param(':language_id', intval($languageID));
        $query->param(':shop_id', intval($shopID));

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();

		// изменяем остальные языки
		$this->_updateObjectLanguages($basicObject, $shopID);
	}

    /**
     * добавляем запись языка
     * @param Model_Basic_LanguageObject $basicObject
     * @param $languageID
     * @param $shopID
     * @return int
     */
	private function _insertObjectLanguage(Model_Basic_LanguageObject $basicObject, $languageID, $shopID)
	{
		if($basicObject->getCountValues() == 0){
			return 0;
		}

		$names = '';
		$values = '';
		for ($i = 0; $i < $basicObject->getCountValues(); $i++){
			$basicObject->getNameAndValue($i, $name, $value, $isEdit);

			$names .=  Helpers_DB::htmlspecialchars($name, '`') . ', ';
			$values .= Helpers_DB::htmlspecialchars($value, "'") . ", ";
		}
		$names .= '`id`, ';
		$values .= (intval($basicObject->id)).', ';

		$names .= '`language_id`, ';
		$values .=  Helpers_DB::htmlspecialchars(intval($languageID), "'") . ", ";

        if($shopID > 0){
            $names .= '`shop_id`, ';
            $values .=  Helpers_DB::htmlspecialchars(intval($shopID), "'") . ", ";
        }

		$names = mb_substr($names, 0, -2);
		$values = mb_substr($values, 0, -2);

		//добавляем записи в БД
		$query = DB::query(Database::INSERT, 'INSERT INTO '.Helpers_DB::htmlspecialchars($basicObject->tableName)
			.' ('.$names.') VALUES ('.$values.') ');

		// запись в лог
		$this->_writeLogs($query->__toString());

		 $query->execute();

        $query = DB::query(Database::SELECT, 'SELECT LAST_INSERT_ID() as global_id;');
        $data = $query->execute();
        $basicObject->globalID = $data[0]['global_id'];

		// изменяем остальные языки
		$this->_updateObjectLanguages($basicObject, $shopID);

		return $basicObject->id;
	}

    /**
     * сохранение записи
     * @param Model_Basic_LanguageObject $basicObject
     * @param int $languageID
     * @param int $shopID
     * @return int
     */
	public function saveObject(Model_Basic_LanguageObject $basicObject, $languageID = 0, $shopID = 0)
	{
		if($basicObject->id > 0){
			if(($languageID > 0) && ($basicObject->globalID < 1)) {
				$this->_insertObjectLanguage($basicObject, $languageID, $shopID);
			}else{
				$this->_updateObject($basicObject, $languageID, $shopID);
			}

			return $basicObject->id;
		}else{
			return $this->_insertObject($basicObject, $languageID, $shopID);
		}
	}

    /**
     * удаление записи
     * @param Model_Basic_DBValue $basicObject
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     * @param null $params
     * @return bool
     */
	public function deleteObject(Model_Basic_DBValue $basicObject, $userID, $languageID = 0, $shopID = 0, $params = NULL)
	{
		if ($basicObject->id < 0) {
			return FALSE;
		}

		$names = '';
		$names .= Helpers_DB::htmlspecialchars('deleted_at', '`') . " = " . Helpers_DB::htmlspecialchars(date("Y-m-d H:i:s"), "'") . ", ";
		$names .= Helpers_DB::htmlspecialchars('is_delete', '`') . " = " . Helpers_DB::htmlspecialchars(1, "'") . ", ";
		$names .= Helpers_DB::htmlspecialchars('delete_user_id', '`') . " = " . Helpers_DB::htmlspecialchars(intval($userID), "'") . ", ";
		$names = mb_substr($names, 0, -2);

		$sql = '(id = :id)';
		if ($languageID > 0) {
			$sql = $sql . ' AND (language_id = :language_id)';
            if ($basicObject->globalID > 0) {
                $sql = $sql . ' AND (global_id = :global_id)';
            }
		}
        if ($shopID > 0) {
            $sql = $sql . ' AND (shop_id = :shop_id)';
        }

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $sql = $sql . ' AND (' . $key . ' = :' . $key . ')';
            }
        }

		$query = DB::query(Database::UPDATE, 'UPDATE ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' SET ' . $names . ' WHERE ' . $sql . ';');

		$query->param(':global_id', intval($basicObject->globalID));
		$query->param(':id', intval($basicObject->id));
		$query->param(':language_id', intval($languageID));
        $query->param(':shop_id', intval($shopID));

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $query->param(':' . $key, $value);
            }
        }

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();
	}

    /**
     * Восстановить запись
     * @param Model_Basic_DBValue $basicObject
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     * @param null $params
     * @return bool
     */
	public function unDeleteObject(Model_Basic_DBValue $basicObject, $userID, $languageID = 0, $shopID = 0, $params = NULL)
	{
		if ($basicObject->id < 0) {
			return FALSE;
		}

		$names = '';
		$names .= Helpers_DB::htmlspecialchars('deleted_at', '`') . " = NULL, ";
		$names .= Helpers_DB::htmlspecialchars('is_delete', '`') . " = " . Helpers_DB::htmlspecialchars(0, "'") . ", ";
		$names .= Helpers_DB::htmlspecialchars('delete_user_id', '`') . " = " . Helpers_DB::htmlspecialchars(0, "'") . ", ";
		$names = mb_substr($names, 0, -2);

		$sql = '(id = :id)';
		if ($languageID > 0) {
			$sql = $sql . ' AND (language_id = :language_id)';
            if ($basicObject->globalID > 0) {
                $sql = $sql . ' AND (global_id = :global_id)';
            }
		}
        if ($shopID > 0) {
            $sql = $sql . ' AND (shop_id = :shop_id)';
        }

		// сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $sql = $sql . ' AND (' . $key . ' = :' . $key . ')';
            }
        }

		$query = DB::query(Database::UPDATE, 'UPDATE ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' SET ' . $names . ' WHERE ' . $sql . ';');

		$query->param(':global_id', intval($basicObject->globalID));
		$query->param(':id', intval($basicObject->id));
		$query->param(':language_id', intval($languageID));
        $query->param(':shop_id', intval($shopID));

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $query->param(':' . $key, $value);
            }
        }

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();
	}

    /**
     * удаление множества записей
     * @param array $objects
     */
	public function deleteObjectAll(array $objects)
	{
	}

    /**
     * получение списка записей по условию
     * @param Model_Driver_DBBasicSQL $DBBasicSelect
     * @param bool $isAllFields
     * @return array
     */
	public function getSelect(Model_Driver_DBBasicSQL $DBBasicSelect, $isAllFields = FALSE)
	{
        if ($isAllFields){
            $sql = $DBBasicSelect->getSQL($DBBasicSelect->getRootFrom()->tableName);
        }else {
            $sql = $DBBasicSelect->getSQL();
        }

		// запись в лог
		$this->_writeLogs($sql);

		$query = DB::query(Database::SELECT, $sql);
		$data = $query->execute();

		$arr = array();
		if ($isAllFields) {
			while ($data->current()) {

				$tmp = $data->current();

				$values = array();
				foreach ($tmp as $key => $value) {
					$values[$key] = Helpers_DB::htmlspecialchars_decode($value);
				}
				$arr[] = $values;

				$data->next();
			}
		} else {
			$arr = array();
			while ($data->current()) {
				$tmp = $data->current();
				$arr[] = $tmp['id'];

				$data->next();
			}
		}

        return [
            'count' => count($arr),
            'result' => $arr,
        ];
	}

    /**
     * Обновляем данные для массива id
     * @param $tableName
     * @param array $ids
     * @param array $fields
     * @param int $languageID
     * @param int $shopID
     * @return bool
     */
	public function updateObjects($tableName, array $ids, array $fields, $languageID = 0, $shopID = 0){
        if(empty($ids)){
            return FALSE;
        }

		$names = '';
		foreach ($fields as $name => $value) {
			$names .= Helpers_DB::htmlspecialchars($name, '`')." = ".Helpers_DB::htmlspecialchars($value, "'").", ";
		}
		$names = mb_substr($names, 0, -2);
		if(empty($names)){
			return FALSE;
		}

		$strIDs = '';
		foreach($ids as $id){
			$id = intval($id);
			if($id > 0){
				$strIDs = $strIDs .  $id.', ' ;
			}
		}
		$strIDs = mb_substr($strIDs, 0, -2);
		if(empty($strIDs)){
			return FALSE;
		}


		$sql = 'id in ('.$strIDs.')';
		if($languageID > 0){
			$sql =  $sql.' AND (language_id = :language_id)';
		}
        if($shopID > 0){
            $sql =  $sql.' AND (shop_id = :shop_id)';
        }

		$query = DB::query(Database::UPDATE, 'UPDATE '.Helpers_DB::htmlspecialchars($tableName).' SET '.$names.' WHERE '.$sql.';');
		$query->param(':language_id', intval($languageID));
        $query->param(':shop_id', intval($shopID));

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();

		return TRUE;
	}

    /**
     * удаление множества записей
     * @param array $ids
     * @param $userID
     * @param $tableName
     * @param null $params
     * @param int $shopID
     * @return bool
     */
	public function deleteObjectIDs(array $ids, $userID, $tableName, $params = NULL, $shopID = 0)
	{
		if(count($ids) == 0){
			return TRUE;
		}

		$names = '';
		$names .= Helpers_DB::htmlspecialchars('deleted_at', '`') . " = " . Helpers_DB::htmlspecialchars(date("Y-m-d H:i:s"), "'") . ", ";
		$names .= Helpers_DB::htmlspecialchars('is_delete', '`') . " = " . Helpers_DB::htmlspecialchars(1, "'") . ", ";
		$names .= Helpers_DB::htmlspecialchars('delete_user_id', '`') . " = " . Helpers_DB::htmlspecialchars(intval($userID), "'") . ", ";

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $names .= Helpers_DB::htmlspecialchars($key, '`') . ' = ' . Helpers_DB::htmlspecialchars($value, "'") . ', ';
            }
        }
		$names = mb_substr($names, 0, -2);

		$sql = 'id in ('.implode(', ', $ids).')';
		if($shopID > 0){
			$sql =  $sql.' AND (shop_id = :shop_id)';
		}

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $sql = $sql . ' AND (' . $key . ' = :' . $key . ')';
            }
        }

		$query = DB::query(Database::UPDATE, 'UPDATE '.Helpers_DB::htmlspecialchars($tableName).' SET '.$names.' WHERE '.$sql.';');
		$query->param(':shop_id', intval($shopID));

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $query->param(':' . $key, $value);
            }
        }

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();


		return TRUE;
	}

    /**
     * Восстановление множества записей
     * @param array $ids
     * @param $userID
     * @param $tableName
     * @param null $params
     * @param int $shopID
     * @return bool
     */
	public function unDeleteObjectIDs(array $ids, $userID, $tableName, $params = NULL, $shopID = 0)
	{
		if(count($ids) == 0){
			return TRUE;
		}

		$names = '';
		$names .= Helpers_DB::htmlspecialchars('deleted_at', '`') . " = NULL, ";
		$names .= Helpers_DB::htmlspecialchars('is_delete', '`') . " = " . Helpers_DB::htmlspecialchars(0, "'") . ", ";
		$names .= Helpers_DB::htmlspecialchars('delete_user_id', '`') . " = " . Helpers_DB::htmlspecialchars(0, "'") . ", ";

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $names .= Helpers_DB::htmlspecialchars($key, '`') . ' = ' . Helpers_DB::htmlspecialchars($value, "'") . ', ';
            }
        }
		$names = mb_substr($names, 0, -2);

		$sql = 'id in ('.implode(', ', $ids).')';
		if($shopID > 0){
			$sql =  $sql.' AND (shop_id = :shop_id)';
		}

		$query = DB::query(Database::UPDATE, 'UPDATE '.Helpers_DB::htmlspecialchars($tableName).' SET '.$names.' WHERE '.$sql.';');
		$query->param(':shop_id', intval($shopID));

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $query->param(':' . $key, $value);
            }
        }

		// запись в лог
		$this->_writeLogs($query->__toString());

		$query->execute();


		return TRUE;
	}

    /**
     * Получить объект по глобаному ID
     * @param $globalID
     * @param Model_Basic_DBObject $basicObject
     * @return bool
     * @throws HTTP_Exception_500
     */
    public function getObjectByGlobalID($globalID, Model_Basic_DBObject $basicObject)
    {
        $id = intval($globalID);
        if ($id < 1) {
            return FALSE;
        }

        $sql = 'global_id = :id';

        $query = DB::query(Database::SELECT, 'SELECT * FROM ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' WHERE ' . $sql);
        $query->param(':id', intval($id));

        // запись в лог
        $this->_writeLogs($query->__toString());
        try
        {
            $data = $query->execute();
        }
        catch (Exception $e)
        {
            throw new HTTP_Exception_500('Error database:'."\r\n".$e->getMessage());
        }

        $basicObject->clear();
        if (is_array($data->current())) {
            foreach ($data->current() as $key => $value) {
                if($value !== NULL){
                    $value = Helpers_DB::htmlspecialchars_decode($value);
                }
                $basicObject->setOriginalValue($key, $value);
            }
        } else {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Массовое изменение пути в name_url
     * @param $tableName
     * @param $old
     * @param $new
     * @param $shopID
     * @param $languageID
     * @throws HTTP_Exception_500
     */
    public function replaceSubNameURL($tableName, $old, $new, $shopID, $languageID)
    {
        $sql = 'UPDATE '.$tableName. ' SET name_url = REPLACE(name_url,:old ,:new) where name_url LIKE \''.Helpers_DB::htmlspecialcharsValuePg($old).'%\' AND  language_id=:language_id AND shop_id=:shop_id;';
        $query = DB::query(Database::UPDATE, $sql);
        $query->param(':old', $old);
        $query->param(':new', $new);
        $query->param(':language_id', intval($languageID));
        $query->param(':shop_id', intval($shopID));

        // запись в лог
        $this->_writeLogs($query->__toString());

        try
        {
            $query->execute();
        }
        catch (Exception $e)
        {
            throw new HTTP_Exception_500('Error database:'."\r\n".$e->getMessage());
        }
    }
}
