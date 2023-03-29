<?php defined('SYSPATH') or die('No direct script access.');

class  Model_Driver_PgSQL_DBDriverPgSQL extends Model_Driver_DBBasicDriver{
	
	const WRITE_LOGS = TRUE;
    const IS_LANGUAGE = FALSE;
    const IS_DISTRIBUTED_DATABASE = false; // каждый филиал формирует базе данных отдельно
	
	private function _writeLogs($select){
		if (!self::WRITE_LOGS){
			return FALSE;
		}

        $result = Helpers_File::saveInLogs('pgsql-select.txt', $select);
		
		return $result;
	}

    /**
     * Обновление базы данных
     * @param $type
     * @param $sql
     * @param array $params
     * @return object
     * @throws HTTP_Exception_500
     */
    private function _updateQuery($type, $sql, array $params = array())
    {

        $query = DB::query($type, $sql);

        foreach ($params as $param => $value){
            if(empty($param)){
                continue;
            }

            if($param[0] != ':'){
                $param = ':' . $param;
            }

            $query->param($param, $value);
        }

        // запись в лог
        $sql = $query->__toString();
        $this->_writeLogs($sql);

        try
        {
            $data = $query->execute();

            if (self::IS_DISTRIBUTED_DATABASE) {
                $query = DB::query($type, 'INSERT INTO "ab_table_updates"("id", "update_user_id", "updated_at", "create_user_id", "created_at", "sql") VALUES ((SELECT nextval(\'_table_update_s20678\')), :user, now(), :user, now(), :sql)');
                $query->param(':sql', $sql);
                $query->param(':user', GlobalData::$siteData->userID);
                $query->execute();
            }
        }
        catch (Exception $e)
        {
            throw new HTTP_Exception_500('Error database:'."\r\n".$e->getMessage());
        }

        return $data;
    }

    /**
     * получение записи
     * @param $id
     * @param Model_Basic_DBObject $basicObject
     * @param int $languageID
     * @param int $languageIDDefault
     * @param int $shopID
     * @return bool
     * @throws HTTP_Exception_500
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

        try
        {
            $data = $query->execute();
        }
        catch (Exception $e)
        {
            throw new HTTP_Exception_500('Error database:'."\r\n".$e->getMessage());
        }


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
                $basicObject->setOriginalValue($key, Helpers_DB::htmlspecialchars_decode($value));
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
     * @throws HTTP_Exception_500
     */
	private function _insertObject(Model_Basic_DBObject $basicObject, $languageID, $shopID)
	{
		if($basicObject->getCountValues() < 1){
			return 0;
		}

		$params = [
            'id' => $this->nextSequence('auto_id'),
            'global_id' => $this->nextSequence('global_id'),
        ];

		$names = '';
		$values = '';
		for ($i = 0; $i < $basicObject->getCountValues(); $i++){
			$basicObject->getNameAndValue($i, $name, $value, $isEdit);
			if(empty($name)){
			    continue;
            }

            $names .=  Helpers_DB::htmlspecialchars($name, '"') . ', ';
            $values .= ':' . $name . ', ';

            $params[$name] = $value;
		}

        if($languageID > 0){
            $names .= '"language_id", ';
            $values .= ':language_id, ';
            $params['language_id'] = intval($languageID);
        }
        if($shopID > 0){
            $names .= '"shop_id", ';
            $values .= ':shop_id, ';
            $params['shop_id'] = intval($shopID);
        }

        $names .= '"id", ';
        $values .= ':id, ';

        $names .= '"global_id", ';
        $values .= ':global_id, ';

		$names = mb_substr($names, 0, -2);
		$values = mb_substr($values, 0, -2);

		//добавляем записи в БД
        $data = $this->_updateQuery(
            Database::INSERT,
            'INSERT INTO '.Helpers_DB::htmlspecialchars($basicObject->tableName) . ' ('.$names.') VALUES ('.$values.') ',
            $params
        );

		$basicObject->id = $data[0]['id'];
        $basicObject->globalID = $data[0]['global_id'];

		return $basicObject->id;
	}

    /**
     * изменение записи всех языков получаем изменяемые части
     * @param Model_Basic_LanguageObject $basicObject
     * @param $shopID
     * @return bool
     * @throws HTTP_Exception_500
     */
    private function _updateObjectLanguages(Model_Basic_LanguageObject $basicObject, $shopID)
    {
        $params = [
            'id' => intval($basicObject->id),
            'shop_id' => intval($shopID),
        ];

        $names = '';
        $fields = $basicObject->overallLanguageFields;
        foreach ($fields as $name) {
            $value = $basicObject->getValueAndIsEdit($name, $isEdit);
            if(empty($name)){
                continue;
            }
            if ($isEdit && !key_exists($name, $params)) {
                $names .= Helpers_DB::htmlspecialchars($name, '"').' = :' . $name . ', ';

                $params[$name] = $value;
            }

        }
        $names = mb_substr($names, 0, -2);

        if(empty($names)){
            return FALSE;
        }

        $sql = 'id = :id';
        if($shopID > 0){
            $sql =  $sql.' AND (shop_id = :shop_id)';
        }

        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE '.Helpers_DB::htmlspecialchars($basicObject->tableName).' SET '.$names.' WHERE '.$sql.';',
            $params
        );
    }

    /**
     * изменение записи
     * @param Model_Basic_LanguageObject $basicObject
     * @param $languageID
     * @param $shopID
     * @return bool
     * @throws HTTP_Exception_500
     */
	private function _updateObject(Model_Basic_LanguageObject $basicObject, $languageID, $shopID)
	{
	    $params = [
            'global_id' => intval($basicObject->globalID),
            'id' => intval($basicObject->id),
            'shop_id' => intval($shopID),
            'language_id' => intval($languageID),
        ];

		$names = '';
		for ($i = 0; $i < $basicObject->getCountValues(); $i++){
			$basicObject->getNameAndValue($i, $name, $value, $isEdit);
			if ($isEdit && !key_exists($name, $params) && $name != 'updated_at'){
				$names .= Helpers_DB::htmlspecialchars($name, '"') . ' = :' . $name . ', ';

				$params[$name] = $value;
			}
		}
        $names = mb_substr($names, 0, -2);

		if(empty($names)){
			return FALSE;
		}

		if($basicObject->isFindField('updated_at')) {
            $names .= ', "updated_at" = :updated_at';
            $params['updated_at'] = $basicObject->getValue('updated_at');
        }

        $sql = '(id = :id)';
        if($basicObject->globalID > 0){
            $sql =  $sql.' AND (global_id = :global_id)';
        }
        if($languageID > 0){
            $sql =  $sql.' AND (language_id = :language_id)';
        }

        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE '.Helpers_DB::htmlspecialchars($basicObject->tableName).' SET '.$names.' WHERE '.$sql.';',
            $params
        );

        // изменяем остальные языки
        if(self::IS_LANGUAGE) {
            $this->_updateObjectLanguages($basicObject, $shopID);
        }
	}

    /**
     * добавляем запись языка
     * @param Model_Basic_LanguageObject $basicObject
     * @param $languageID
     * @param $shopID
     * @return int
     * @throws HTTP_Exception_500
     */
    private function _insertObjectLanguage(Model_Basic_LanguageObject $basicObject, $languageID, $shopID)
    {
        if($basicObject->getCountValues() == 0){
            return 0;
        }

        $params = [
            'id' => intval($basicObject->id),
            'global_id' => $this->nextSequence('global_id'),
        ];

        $names = '';
        $values = '';
        for ($i = 0; $i < $basicObject->getCountValues(); $i++){
            $basicObject->getNameAndValue($i, $name, $value, $isEdit);

            $names .=  Helpers_DB::htmlspecialchars($name, '"') . ', ';
            $values .= ':' . $name . ', ';
            $params[$name] = $value;
        }

        if($languageID > 0) {
            $names .= '"language_id", ';
            $values .= ':language_id, ';

            $params['language_id'] = $languageID;
        }
        if($shopID > 0){
            $names .= '"shop_id", ';
            $values .= ':shop_id, ';

            $params['shop_id'] = $shopID;
        }

        $names .= '"id", ';
        $values .= ':id, ';

        $names .= '"global_id", ';
        $values .= ':global_id, ';

        $names = mb_substr($names, 0, -2);
        $values = mb_substr($values, 0, -2);

        //добавляем записи в БД
        $data = $this->_updateQuery(
            Database::INSERT,
            'INSERT INTO '.Helpers_DB::htmlspecialchars($basicObject->tableName) .' ('.$names.') VALUES ('.$values.') ',
            $params
        );

        $basicObject->globalID = $data[0]['global_id'];

        // изменяем остальные языки
        $this->_updateObjectLanguages($basicObject, $shopID);

        return $basicObject->id;
    }

    /**
     *  сохранение записи
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
		}else{
            $this->_insertObject($basicObject, $languageID, $shopID);
		}

        return $basicObject->id;
	}

    /**
     * удаление записи
     * @param Model_Basic_DBValue $basicObject
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     * @param null $params
     * @return bool
     * @throws HTTP_Exception_500
     */
    public function deleteObject(Model_Basic_DBValue $basicObject, $userID, $languageID = 0, $shopID = 0, $params = NULL)
    {
        if ($basicObject->id < 0) {
            return FALSE;
        }

        // сохраняем дополнительный параметры
        if(!is_array($params)) {
            $params = [];
        }

        $params = array_merge(
            $params,
            [
                'global_id' => intval($basicObject->globalID),
                'id' => intval($basicObject->id),
                'shop_id' => intval($shopID),
                'language_id' => intval($languageID),
                'deleted_at' => date("Y-m-d H:i:s"),
                'is_delete' => 1,
                'delete_user_id' => intval($userID),
            ]
        );

        $names = '';
        $names .= Helpers_DB::htmlspecialchars('deleted_at', '"') . ' = :deleted_at, ';
        $names .= Helpers_DB::htmlspecialchars('is_delete', '"') . ' = :is_delete, ';
        $names .= Helpers_DB::htmlspecialchars('delete_user_id', '"') . ' = :delete_user_id, ';
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


        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' SET ' . $names . ' WHERE ' . $sql . ';',
            $params
        );
    }

    /**
     * Восстановить запись
     * @param Model_Basic_DBValue $basicObject
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     * @param null $params
     * @return bool
     * @throws HTTP_Exception_500
     */
    public function unDeleteObject(Model_Basic_DBValue $basicObject, $userID, $languageID = 0, $shopID = 0, $params = NULL)
    {
        if ($basicObject->id < 0) {
            return FALSE;
        }

        // сохраняем дополнительный параметры
        if(!is_array($params)) {
            $params = [];
        }

        $params = array_merge(
            $params,
            [
                'global_id' => intval($basicObject->globalID),
                'id' => intval($basicObject->id),
                'shop_id' => intval($shopID),
                'language_id' => intval($languageID),
                'deleted_at' => NULL,
                'is_delete' => 0,
                'delete_user_id' => 0,
            ]
        );

        $names = '';
        $names .= Helpers_DB::htmlspecialchars('deleted_at', '"') . ' = :deleted_at, ';
        $names .= Helpers_DB::htmlspecialchars('is_delete', '"') . ' = :is_delete, ';
        $names .= Helpers_DB::htmlspecialchars('delete_user_id', '"') . ' = :delete_user_id, ';
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

        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' SET ' . $names . ' WHERE ' . $sql . ';',
            $params
        );
    }

	/** удаление множества записей
	 * DBObjects
	 */
	public function deleteObjectAll(array $objects)
	{
	}

    /**
     * получение списка записей по условию
     * @param Model_Driver_DBBasicSQL $DBBasicSelect
     * @param bool $isAllFields
     * @return mixed
     * @throws HTTP_Exception_500
     */
	public function getSelect(Model_Driver_DBBasicSQL $DBBasicSelect, $isAllFields = FALSE)
    {
        if ($isAllFields){
            $sql = $DBBasicSelect->getSQL($DBBasicSelect->getRootFrom()->tableName);
        }else {
            $sql = $DBBasicSelect->getSQL();
        }

        if($DBBasicSelect->limitPage > 0){
            return $this->getFetchSQL($sql, $DBBasicSelect->limit, $DBBasicSelect->limitPage, $DBBasicSelect->page, $isAllFields);
        }

        return $this->getSelectSQL($sql, $isAllFields);
    }

    /**
     * Получение списка записей по условию
     * @param $sql
     * @param bool $isAllFields
     * @return array
     * @throws HTTP_Exception_500
     */
    public function getSelectSQL($sql, $isAllFields = FALSE){
        // запись в лог
        $this->_writeLogs($sql);
        $query = DB::query(Database::SELECT, $sql);
        try
        {
            $data = $query->execute();
        }
        catch (Exception $e)
        {
            throw new HTTP_Exception_500('Error database:'."\r\n".$e->getMessage());
        }

        if ($isAllFields) {
            $arr = $data->as_array();
            foreach($arr as &$value){
                foreach($value as $k => $v){
                    $value[$k] = Helpers_DB::htmlspecialchars_decode($v);
                }
            }
        } else {
            $arr = $data->as_array(NULL, 'id');
        }

        return [
            'count' => count($arr),
            'result' => $arr,
        ];
    }

    /**
     * Получаем список записей через FETCH
     * @param $sql
     * @param $limit
     * @param $limitPage
     * @param $page
     * @param bool $isAllFields
     * @return mixed
     * @throws HTTP_Exception_500
     */
    public function getFetchSQL($sql, $limit, $limitPage, $page, $isAllFields = FALSE){
        // запись в лог
        $this->_writeLogs($sql);
        $start = intval($limitPage) * (intval($page) - 1);
        if($start < 0){
            $start = 0;
        }

        $rand = str_replace('.', '', microtime(true)) . '_' . random_int(1, 999999);

        $sql = 'BEGIN; DECLARE curs_'.$rand.' CURSOR FOR ' . $sql . ' MOVE FORWARD ' . $start . ' IN curs_'.$rand.'; FETCH ' . $limitPage . ' FROM curs_'.$rand.';';

        $query = DB::query(Database::SELECT, $sql);
        try {
            $data = $query->execute();
        } catch (Exception $e) {
            DB::query(Database::SELECT, 'ROLLBACK;')->execute();
            throw new HTTP_Exception_500('Error database:' . "\r\n" . $e->getMessage());
        }
        try {
            if ($isAllFields) {
                $arr = $data->as_array();
                foreach ($arr as &$value) {
                    foreach ($value as $k => $v) {
                        $value[$k] = Helpers_DB::htmlspecialchars_decode($v);
                    }
                }
            } else {
                $arr = $data->as_array(NULL, 'id');
            }

            if($limit > 0){
                $query = DB::query(Database::SELECT, 'MOVE FORWARD '.$limit.' IN curs_' . $rand . ';');
            }else {
                $query = DB::query(Database::SELECT, 'MOVE FORWARD ALL IN curs_' . $rand . ';');
            }
            $data = $query->execute();

            $count = $start + $data->count() + count($arr);
        }finally{
            DB::query(Database::SELECT, 'ROLLBACK;')->execute();
        }

        return [
            'count' => $count,
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
     * @throws HTTP_Exception_500
     */
	public function updateObjects($tableName, array $ids, array $fields, $languageID = 0, $shopID = 0){
        if(empty($ids)){
            return FALSE;
        }

        $params = [
            'shop_id' => intval($shopID),
            'language_id' => intval($languageID),
        ];

		$names = '';
		foreach ($fields as $name => $value) {
			$names .= Helpers_DB::htmlspecialchars($name, '"') . ' = :' . $name . ', ';
            $params[$name] = $value;
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

        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE '.Helpers_DB::htmlspecialchars($tableName).' SET '.$names.' WHERE '.$sql.';',
            $params
        );


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
     * @throws HTTP_Exception_500
     */
    public function deleteObjectIDs(array $ids, $userID, $tableName, $params = NULL, $shopID = 0)
    {
        if(count($ids) == 0){
            return TRUE;
        }

        $names = '';
        $names .= Helpers_DB::htmlspecialchars('deleted_at', '"') . ' = :deleted_at, ';
        $names .= Helpers_DB::htmlspecialchars('is_delete', '"') . ' = :is_delete, ';
        $names .= Helpers_DB::htmlspecialchars('delete_user_id', '"') . ' = :delete_user_id, ';

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $names .= Helpers_DB::htmlspecialchars($key, '"') . ' = :' . $key . ', ';
            }
        }
        $names = mb_substr($names, 0, -2);

        $sql = 'id in ('.implode(', ', $ids).')';
        if($shopID > 0){
            $sql =  $sql.' AND (shop_id = :shop_id)';
        }

        // сохраняем дополнительный параметры
        if(!is_array($params)) {
            $params = [];
        }

        $params = array_merge(
            $params,
            [
                'shop_id' => intval($shopID),
                'deleted_at' => date("Y-m-d H:i:s"),
                'is_delete' => 1,
                'delete_user_id' => intval($userID),
            ]
        );

        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE '.Helpers_DB::htmlspecialchars($tableName).' SET '.$names.' WHERE '.$sql.';',
            $params
        );

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
     * @throws HTTP_Exception_500
     */
    public function unDeleteObjectIDs(array $ids, $userID, $tableName, $params = NULL, $shopID = 0)
    {
        if(count($ids) == 0){
            return TRUE;
        }

        $names = '';
        $names .= Helpers_DB::htmlspecialchars('deleted_at', '"') . ' = :deleted_at, ';
        $names .= Helpers_DB::htmlspecialchars('is_delete', '"') . ' = :is_delete, ';
        $names .= Helpers_DB::htmlspecialchars('delete_user_id', '"') . ' = :delete_user_id, ';

        // сохраняем дополнительный параметры
        if(is_array($params)) {
            foreach ($params as $key => $value) {
                $names .= Helpers_DB::htmlspecialchars($key, '"') . ' = :' . $key . ', ';
            }
        }
        $names = mb_substr($names, 0, -2);

        $sql = 'id in ('.implode(', ', $ids).')';
        if($shopID > 0){
            $sql =  $sql.' AND (shop_id = :shop_id)';
        }

        // сохраняем дополнительный параметры
        if(!is_array($params)) {
            $params = [];
        }

        $params = array_merge(
            $params,
            [
                'shop_id' => intval($shopID),
                'deleted_at' => NULL,
                'is_delete' => 0,
                'delete_user_id' => 0,
            ]
        );

        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE '.Helpers_DB::htmlspecialchars($tableName).' SET '.$names.' WHERE '.$sql.';',
            $params
        );

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
        $globalID = intval($globalID);
        if ($globalID < 1) {
            return FALSE;
        }

        $sql = 'global_id = :global_id';

        $query = DB::query(Database::SELECT, 'SELECT * FROM ' . Helpers_DB::htmlspecialchars($basicObject->tableName) . ' WHERE ' . $sql);
        $query->param(':global_id', intval($globalID));

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
     * Сохранение данных в строку INSERT
     * @param MyArray $data
     * @param $tableName
     * @return string
     */
    public function saveSQLInsertOne(MyArray $data, $tableName){
        $keys = '';
        $values = '';
        foreach ($data->values as $key => $value){
            $keys = $keys . Helpers_DB::htmlspecialchars($key, '"').', ';
            $values = $values . Helpers_DB::htmlspecialcharsValuePg($value, "'").', ';
        }

        return 'INSERT INTO "'.$tableName.'"('.mb_substr($keys, 0, -2).') VALUES ('.mb_substr($values, 0, -2).')';
    }

    /**
     * Сохранение данных в строки INSERT
     * @param MyArray $data
     * @param $tableName
     * @return string
     */
    public function saveSQLInsertList(MyArray $data, $tableName){
        $result = '';
        foreach ($data->childs as $child){
            $result = $result . $this->saveSQLInsertOne($child, $tableName)."\r\n";
        }
        return $result;
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
        $this->_updateQuery(
            Database::UPDATE,
            'UPDATE '.$tableName. ' SET name_url = REPLACE(name_url, :old, :new) where name_url LIKE \''.Helpers_DB::htmlspecialcharsValuePg($old).'%\' AND  language_id=:language_id AND shop_id=:shop_id;',
            [
                'shop_id' => intval($shopID),
                'language_id' => intval($languageID),
                'old' => $old,
                'new' => $new,
            ]
        );
    }

    /**
     * Выполение SQL запроса на изменение база данных
     * @param $sql
     * @throws HTTP_Exception_500
     */
    public function sendSQL($sql, array $params = array())
    {
        $this->_updateQuery(Database::UPDATE, $sql, $params);
    }

    /**
     * Получение списка счетчиков
     * @return array
     */
    public function getSequences(){
        return $this->getSelectSQL(
            'SELECT cl.oid AS oid, ns.nspname AS schema_name, cl.relname AS sequence_name, dep.deptype AS deptype, pg_get_userbyid(cl.relowner) AS seqowner, cl.relacl AS acl, des.description AS comment, cl2.relname AS own_table, att.attname AS own_column FROM pg_class cl LEFT JOIN pg_namespace ns ON ns.oid = relnamespace LEFT JOIN pg_description des ON des.objoid = cl.oid LEFT JOIN pg_depend dep ON dep.objid = cl.oid LEFT JOIN pg_class cl2 ON cl2.oid = dep.refobjid LEFT JOIN pg_attribute att ON att.attrelid = dep.refobjid AND att.attnum = dep.refobjsubid WHERE cl.relkind = \'S\' AND ns.nspname = \'public\' ORDER BY cl.relname, dep.deptype DESC;',
            true
        );
    }

    /**
     * Получение данных счетчика
     * @param $name
     * @return array
     */
    public function getSequence($name){
        return $this->getSelectSQL(
            'SELECT last_value, start_value, increment_by, min_value, max_value, cache_value, is_cycled, is_called FROM ' . $name . ';',
            true
        )[0];
    }

    /**
     * Задаем текущее значение счетчика
     * @param $name
     * @param $value
     */
    public function setSequence($name, $value){
        $this->sendSQL('SELECT setval(\'"'.$name.'"\', ' . intval($value) . ', false)');
    }

    /**
     * Получение следующего значения счетчика
     * @param $sequence
     * @return int
     */
    public function nextSequence($sequence){
        return Database::instance()->query(Database::SELECT, 'SELECT nextval(\''. $sequence . '\') as id;')->as_array(NULL, 'id')[0];
    }
}
