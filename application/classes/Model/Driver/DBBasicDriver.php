<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicDriver extends Model {

    /**
     * Где брать настройки для подключения
     * @var string
     */
    public $configName = 'default';

	public function do_some() {}

    /**
     * @return null | Model_Memcache_ShopMemcacheDriver
     */
	public function getMemcache(){
		return NULL;
	}

	/** получение записи
	 * ID записи
	 * Объект экземпляра BasicObject
	 * @var $basicObject
	 * Возвращает найден ли объект
	 */
	public function getObject($id, Model_Basic_DBObject $basicObject)
	{
	}

	/** сохранение записи
	 * Объект экземпляра BasicObject
	 * возвращает ID записи в базе данных
	 */
	/*public function saveObject(Model_Basic_LanguageObject $basicObject)
	{

	}*/

	/** удаление записи
	 * ID записи
	 */
	public function deleteObject(Model_Basic_DBValue $basicObject, $userID)
	{
	}

	/** удаление записи
	 * ID записи
	 */
	public function unDeleteObject(Model_Basic_DBValue $basicObject, $userID)
	{
	}

    /**
     * удаление множества записей
     * @param array $objects
     */
	public function deleteObjectAll(array $objects)
	{
	}

    /**
     * удаление множества записей
     * @param array $ids
     * @param $userID
     * @param $tableName
     * @param null $params
     */
	public function deleteObjectIDs(array $ids, $userID, $tableName, $params = NULL)
	{
	}

    /**
     * воостановление множества записей
     * @param array $ids
     * @param $userID
     * @param $tableName
     * @param null $params
     */
    public function unDeleteObjectIDs(array $ids, $userID, $tableName, $params = NULL)
    {
    }

    /**
     * получение списка записей по условию
     * Объект экземпляра $DBBasicSQL, условия выборки
     * Объект экземпляра BasicObjects, список объектов
     * @param Model_Driver_DBBasicSQL $DBBasicSQL
     * @param bool $isAllFields
     * @return array
     */
	public function getSelect(Model_Driver_DBBasicSQL $DBBasicSQL, $isAllFields = FALSE)
	{
		return array(
		    'count' => 0,
            'result' => [],
        );
	}
	
	/** найдены ли данные
	 * Объект экземпляра DBBasicSelect, условия выборки
	 * return TRUE/FALSE
	 */
	public function isFind(Model_Driver_DBBasicSQL $DBBasicSelect){
		return ($this->getSelect($DBBasicSelect)['count'] > 0);
	}

	/**
	 * Обновляем данные для массива id
	 * @param $tableName
	 * @param array $ids
	 * @param array $fields
	 */
	public function updateObjects($tableName, array $ids, array $fields){

	}

    /**
     * Сохранение данных в строку INSERT
     * @param MyArray $data
     * @param $tableName
     * @return string
     */
    public function saveSQLInsertOne(MyArray $data, $tableName){
        return '';
    }

    /**
     * Сохранение данных в строки INSERT
     * @param MyArray $data
     * @param $tableName
     * @return string
     */
    public function saveSQLInsertList(MyArray $data, $tableName){
        return '';
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
    }

    /**
     * Выполение SQL запроса на изменение база данных
     * @param $sql
     * @throws HTTP_Exception_500
     */
    public function sendSQL($sql)
    {
    }

    /**
     * Получение списка счетчиков
     * @return array
     */
    public function getSequences(){
        return array();
    }

    /**
     * Получение данных счетчика
     * @param $name
     * @return array
     */
    public function getSequence($name){
        return 0;
    }

    /**
     * Задаем текущее значение счетчика
     * @param $name
     * @param $value
     */
    public function setSequence($name, $value){
    }

    /**
     * Получение следующего значения счетчика
     * @param $sequence
     * @return int
     */
    public function nextSequence($sequence){
        return 0;
    }
}