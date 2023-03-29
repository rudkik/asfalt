<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_MySQL_DBMySQLFrom extends  Model_Driver_DBBasicFrom
{

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL()
	{
		$tmp = "";
		foreach ($this->_fields as $key => $value) {

			if ($tmp == "") {
				$tmp .= "`" . Helpers_DB::htmlspecialchars($value["table_name_1"]) . "`";
			}

			// сравнение полей
			switch ($value['join']) {
				case Model_Driver_MySQL_DBMySQLFrom::JOIN_LEFT:
					$tmp .= " LEFT JOIN ";
					break;
				case Model_Driver_MySQL_DBMySQLFrom::JOIN_RIGHT:
					$tmp .= " LEFT JOIN ";
					break;
				case Model_Driver_MySQL_DBMySQLFrom::JOIN_INNER:
					$tmp .= " INNER JOIN ";
					break;
				default:
					$tmp .= " LEFT JOIN ";
			}

			$tmp .= "`" . Helpers_DB::htmlspecialchars($value["table_name_2"]) . "`";

			$tmp .= " ON ";

			$tmp .= "`" . Helpers_DB::htmlspecialchars($value["table_name_1"]) . "`."
				. "`" . Helpers_DB::htmlspecialchars($value['field_name_1']) . "`";

			$tmp .= " = ";

			$tmp .= "`" . Helpers_DB::htmlspecialchars($value["table_name_2"]) . "`."
				. "`" . Helpers_DB::htmlspecialchars($value['field_name_2']) . "`";

			$tmp = "(" . $tmp . ")";
		}


		if ($tmp == "") {
			$tmp .= "`" . Helpers_DB::htmlspecialchars($this->tableName) . "`";
		}

		return $tmp;
	}
}
