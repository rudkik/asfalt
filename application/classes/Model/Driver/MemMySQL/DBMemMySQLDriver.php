<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_MemMySQL_DBMemMySQLDriver extends Model_Driver_DBBasicDriver {

	// подключение к мемкещу
	private $_memcache = null;

	//ссылка на драйвер к базе данных типа DBBasicDriver
    /**
     * @var Model_Driver_MySQL_DBDriverMySQL|null
     */
	private $_driverDB = null;

	public function __construct(){
		$this->_memcache = new Model_Memcache_ShopMemcacheDriver();
		$this->_driverDB = new Model_Driver_MySQL_DBDriverMySQL();
	}

	public function getMemcache(){
		return $this->_memcache;
	}

    /**
     * получение записи
     * @param $id
     * @param Model_Basic_DBObject $basicObject
     * @param int $languageID
     * @param int $languageIDDefault
     * @param int $shopID
     * @return bool|void
     */
	public function getObject($id, Model_Basic_DBObject $basicObject, $languageID = 0, $languageIDDefault = 0, $shopID = 0){
		$link = rand(1000, 9999);
		$tmp = $this->_memcache->getShopObject($shopID, $basicObject->tableName, $id, $languageID, $link);

		if($tmp === NULL){
			$result = $this->_driverDB->getObject($id, $basicObject, $languageID, $languageIDDefault, $shopID);
			$this->_memcache->setShopObject($basicObject->__getArray(), $shopID, $basicObject->tableName, $id, $languageID, $link);
		}else{
			$basicObject->__setArray($tmp);
			$result = TRUE;
		}
		return $result;
	}

	/** сохранение записи
	 * Объект экземпляра BasicObject
	 * возвращает ID записи в базе данных
	 */
	public function saveObject(Model_Basic_DBObject $basicObject, $languageID = 0, $shopID = 0){
		$id = $this->_driverDB->saveObject($basicObject, $languageID, $shopID);
		if ($basicObject->id > 0){
			$this->_memcache->editObject($shopID, $basicObject->tableName, $basicObject->id);
		}

		return $id;
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
		if ($basicObject->id < 1) {
			return FALSE;
		}

		$result = $this->_driverDB->deleteObject($basicObject, $userID, $languageID, $shopID, $params);
		$this->_memcache->editObject($shopID, $basicObject->tableName, $basicObject->id);

		return $result;
	}

    /**
     * Восстановление записи
     * @param Model_Basic_DBValue $basicObject
     * @param $userID
     * @param int $languageID
     * @param int $shopID
     * @param null $params
     * @return bool
     */
	public function unDeleteObject(Model_Basic_DBValue $basicObject, $userID, $languageID = 0, $shopID = 0, $params = NULL)
	{
		if ($basicObject->id < 1) {
			return FALSE;
		}

		$result = $this->_driverDB->unDeleteObject($basicObject, $userID, $languageID, $shopID, $params );
		$this->_memcache->editObject($shopID, $basicObject->tableName, $basicObject->id);

		return $result;
	}

    /**
     * получение списка записей по условию
     * @param Model_Driver_DBBasicSQL $DBBasicSQL
     * @param bool $isAllFields
     * @param int $languageID
     * @param int $shopID
     * @return array
     */
	public function getSelect(Model_Driver_DBBasicSQL $DBBasicSQL, $isAllFields = FALSE, $languageID = 0, $shopID = 0){
        $tableNames = $DBBasicSQL->getRootFrom()->getTables();
        $tableName = $DBBasicSQL->getRootFrom()->tableName;
        if ($languageID > 0) {
            $DBBasicSQL->getRootWhere()->addField("language_id", $tableName, $languageID);
        }

        if ($shopID > 0) {
            $DBBasicSQL->getRootWhere()->addField("shop_id", $tableName, $shopID);
        }

        $select = $DBBasicSQL->getSQL($DBBasicSQL->basicTableName);

		$link = rand(1000, 9999);
		$result = $this->_memcache->getShopSelect($shopID, $tableNames, $select, $languageID, $isAllFields === FALSE, $link);
		if ($result === NULL){
			$result = $this->_driverDB->getSelect($DBBasicSQL, $isAllFields);

			$this->_memcache->setShopSelect($result, $shopID, $tableNames, $select, $languageID, $isAllFields === FALSE, $link);
		}

		return $result;
	}

    /**
     * удаление множества записей
     * @param array $ids
     * @param $userID
     * @param $tableName
     * @param int $shopID
     * @param null $params
     */
	public function deleteObjectIDs(array $ids, $userID, $tableName, $params = NULL, $shopID = 0)
	{
		$this->_driverDB->deleteObjectIDs($ids, $userID, $tableName, $params, $shopID);
		foreach($ids as $id) {
			$this->_memcache->editObject($shopID, $tableName, $id);
		}
	}

    /**
     * Восстановление множества записей
     * @param array $ids
     * @param $userID
     * @param $tableName
     * @param null $params
     * @param int $shopID
     */
	public function unDeleteObjectIDs(array $ids, $userID, $tableName, $params = NULL, $shopID = 0)
	{
		$this->_driverDB->unDeleteObjectIDs($ids, $userID, $tableName, $params, $shopID);
		foreach($ids as $id) {
			$this->_memcache->editObject($shopID, $tableName, $id);
		}
	}

    /**
     * Обновляем данные для массива id
     * @param $tableName
     * @param array $ids
     * @param array $fields
     * @param int $languageID
     * @param int $shopID
     */
	public function updateObjects($tableName, array $ids, array $fields, $languageID = 0, $shopID = 0){
	    if(empty($ids)){
	       return FALSE;
        }

		$this->_driverDB->updateObjects($tableName, $ids, $fields, $languageID, $shopID);

		foreach($ids as $id) {
			$this->_memcache->editObject($shopID, $tableName, $id);
		}
        return TRUE;
    }

    /**
     * Получить объект по глобаному ID
     * @param $globalID
     * @param Model_Basic_DBObject $basicObject
     * @return bool
     */
    public function getObjectByGlobalID($globalID, Model_Basic_DBObject $basicObject){
        return $this->_driverDB->getObjectByGlobalID($globalID, $basicObject);
    }

    /**
     * Массовое изменение пути в name_url
     * @param $tableName
     * @param $old
     * @param $new
     * @param $shopID
     * @param $languageID
     */
    public function replaceSubNameURL($tableName, $old, $new, $shopID, $languageID)
    {
        $this->_driverDB->replaceSubNameURL($tableName, $old, $new, $shopID, $languageID);
    }

    /**
     * Выполение SQL запроса на изменение база данных
     * @param $sql
     * @throws HTTP_Exception_500
     */
    public function sendSQL($sql)
    {
        $this->_driverDB->sendSQL($sql);
    }
}