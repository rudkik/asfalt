<?php defined('SYSPATH') or die('No direct script access.');


class Model_Driver_MySQL_DBMySQLSQL extends  Model_Driver_DBBasicSQL
{
	public function __construct()
	{
		$this->rootSelect = new Model_Driver_MySQL_DBMySQLSelect();
		$this->rootWhere = new Model_Driver_MySQL_DBMySQLWhere();
		$this->rootFrom = new Model_Driver_MySQL_DBMySQLFrom();
		$this->rootSort = new Model_Driver_MySQL_DBMySQLSort();
		$this->rootGroupBy = new Model_Driver_MySQL_DBMySQLGroupBy();
	}

    /**
     * получаем строку запрос
     * @param string $tableNameDefault
     * @return mixed|string
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

        $tmp = 'SELECT ' . $this->rootSelect->getSQL()
			. ' FROM ' . $this->rootFrom->getSQL()
            . ' ' . $this->rootWhere->getSQL(TRUE, $tableNameDefault)
            . ' ' . $this->rootGroupBy->getSQL($tableNameDefault)
            . ' ' . $this->rootSort->getSQL($tableNameDefault);

		// добавляем лимит записей
		$this->limit = intval($this->limit);
		if ($this->limit > 0) {
			$tmp = $tmp . ' LIMIT ' . ($this->limit );

			$this->page = intval($this->page);
			if ($this->page > 0) {
				$tmp = $tmp . ', ' . ($this->page);
			}
		}

		$tmp = $tmp . ";";

        $tmp = str_replace('date_part(\'year\', ', 'YEAR(', $tmp);

		return $tmp;
	}
}