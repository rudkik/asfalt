<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_PgSQL_DBPgSQLFrom extends  Model_Driver_DBBasicFrom
{

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL()
	{
		$result = '';
		foreach ($this->_fields as $key => $value) {

			if ($result == '') {
				$result .= Helpers_DB::htmlspecialchars($value['table_name_1']);
			}

			// сравнение полей
			switch ($value['join']) {
				case self::JOIN_LEFT:
					$result .= ' LEFT JOIN ';
					break;
				case self::JOIN_RIGHT:
					$result .= ' LEFT JOIN ';
					break;
				case self::JOIN_INNER:
					$result .= ' INNER JOIN ';
					break;
				default:
					$result .= ' LEFT JOIN ';
			}

            $table2 = Helpers_DB::htmlspecialchars(Arr::path($value, 'new_table_name', $value['table_name_2'].'__'.$value['field_name_1']));

			$result .= Helpers_DB::htmlspecialchars($value['table_name_2']). ' ' . $table2;

			$result .= ' ON ';

			$result .= Helpers_DB::htmlspecialchars($value['table_name_1'])
				. '.' . Helpers_DB::htmlspecialchars($value['field_name_1'], '"');

			$result .= ' = ';

			$result .= $table2
				. '.' . Helpers_DB::htmlspecialchars($value['field_name_2'], '"');

			if (!empty($value['sql'])){
                $result .= ' AND '.$value['sql'];
            }

			$result = '(' . $result . ')';
		}


		if ($result == '') {
			$result .= Helpers_DB::htmlspecialchars($this->tableName);
		}

		return $result;
	}
}