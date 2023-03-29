<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_PgSQL_DBPgSQLSort extends  Model_Driver_DBBasicSort
{

    /**
     * получаем строку запрос Возвращает SQL-строку
     * @param string $tableNameDefault
     * @return string
     */
	public function getSQL($tableNameDefault = '')
	{
		$tmp = '';
		foreach ($this->_fields as $key => $value) {
		    if ($value['is_processing']) {
                if (!empty($value['table'])) {
                    $tmp .= Helpers_DB::htmlspecialchars($value['table']) . '.';
                } elseif (!empty($tableNameDefault)) {
                    $tmp .= Helpers_DB::htmlspecialchars($tableNameDefault) . '.';
                }
                $tmp .= '"'.Helpers_DB::htmlspecialchars($value['field']).'"';
            }else{
                $tmp .= $value['field'];
            }

			if ($value["asc"] === FALSE) {
				$tmp .= ' DESC';
			} else {
				$tmp .= ' ASC';
			}
			$tmp .= ', ';
		}

		$tmp = substr($tmp, 0, strlen($tmp) - 2);
		if (!empty($tmp)) {
			$tmp = 'ORDER BY ' . $tmp;
		}

		return $tmp;
	}
}

