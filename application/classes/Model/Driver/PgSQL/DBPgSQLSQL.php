<?php defined('SYSPATH') or die('No direct script access.');


class Model_Driver_PgSQL_DBPgSQLSQL extends Model_Driver_DBBasicSQL
{

	public function __construct()
	{
		$this->rootSelect = new Model_Driver_PgSQL_DBPgSQLSelect();
		$this->rootWhere = new Model_Driver_PgSQL_DBPgSQLWhere();
		$this->rootFrom = new Model_Driver_PgSQL_DBPgSQLFrom();
		$this->rootSort = new Model_Driver_PgSQL_DBPgSQLSort();
		$this->rootGroupBy = new Model_Driver_PgSQL_DBPgSQLGroupBy();
	}

    /**
     * получаем строку запрос
     * @param string $tableNameDefault
     * @return string
     */
	public function getSQL($tableNameDefault = '')
	{
	    // если идет группировка то удаляем показ записей со *
	    if(count($this->rootGroupBy->getFields()) > 0){
	        foreach ($this->rootGroupBy->getFields() as $field) {
	            if(($field['name'] = '*') && (!key_exists('function_name', $field))) {
                    $this->rootSelect->deleteField($field['table'], $field['name']);
                }
            }
        }

		$tmp = 'SELECT ' . $this->rootSelect->getSQL($tableNameDefault)
			. ' FROM ' . $this->rootFrom->getSQL()
			. ' ' . $this->rootWhere->getSQL(TRUE, $tableNameDefault)
			. ' ' . $this->rootGroupBy->getSQL($tableNameDefault)
			. ' ' . $this->rootSort->getSQL($tableNameDefault);

		// добавляем лимит записей
        $limit = 0;
		$this->limit = intval($this->limit);
		if ($this->limit > 0) {
		    $limit = $this->limit;
		}else{
            /*$this->limitPage = intval($this->limitPage);
            if ($this->limitPage > 0) {
                $limit = $this->limitPage;
            }*/
		}
        if ($limit > 0) {
            $tmp = $tmp . ' LIMIT ' . $limit;
            /*$this->page = intval($this->page);
            if ($this->page > 0) {
                $tmp = $tmp . ' OFFSET ' . $this->page;
            }*/
        }

		$tmp = $tmp . ';';

		return $tmp;
	}
}