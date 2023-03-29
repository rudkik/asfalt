<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicSQL extends Model {

    /**
     * базовый элемент WHERE
     * @var Model_Driver_DBBasicWhere|null
     */
    protected $rootWhere = NULL;

    /**
     * базовый элемент SELECT
     * @var Model_Driver_DBBasicSelect|null
     */
    protected $rootSelect = NULL;

    /**
     * базовый элемент FROM
     * @var Model_Driver_DBBasicFrom|null
     */
    protected $rootFrom = NULL;

    /**
     * Сортировка
     * @var Model_Driver_DBBasicSort|null
     */
    protected $rootSort = NULL;

    /**
     * Группировка
     * @var Model_Driver_DBBasicGroupBy|null
     */
    protected $rootGroupBy = NULL;

    // лимит записей
    public $limit = 0;

    // страница для отображения
    public $page = -1;

    // лимит страниц
    public $limitPage = 0;

    // базовая таблица
    public $basicTableName = '';

    /**
     * получаем Sort
     * @return Model_Driver_DBBasicSort|null
     */
    public function getrootSort()
    {
        return $this->rootSort;
    }

    /**
     * получаем SELECT
     * @return Model_Driver_DBBasicSelect|null
     */
    public function getRootSelect()
    {
        return $this->rootSelect;
    }

    /**
     * @return Model_Driver_DBBasicFrom|null| Model_Driver_PgSQL_DBPgSQLFrom
     */
    public function getRootFrom()
    {
        return $this->rootFrom;
    }

    /**
     * получаем Where
     * @return Model_Driver_DBBasicWhere|null
     */
    public function getRootWhere()
    {
        return $this->rootWhere;
    }

    /**
     * получаем GROUP BY
     * @return Model_Driver_DBBasicGroupBy|null
     */
    public function getRootGroupBy()
    {
        return $this->rootGroupBy;
    }

    /**
     * задаем название таблицы
     * @param $tableName
     */
    public function setTableName($tableName)
    {
        $this->rootFrom->tableName = $tableName;
    }
	

}