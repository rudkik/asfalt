<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_MySQL_DBMySQLGroupBy extends  Model_Driver_DBBasicGroupBy
{

	/** получаем строку запрос
	 * Возвращает SQLстроку
	 */
	public function getSQL($tableNameDefault = '')
	{
		$result = '';
		foreach ($this->_fields as $key => $value) {
			$tmp = '';

			$functionName = '';
			if ((key_exists('function_name', $value) && (!empty($value['function_name'])))) {
				$functionName = $value['function_name'];
			}

            if (!empty($value['table'])) {
                $tmp .= "`" . Helpers_DB::htmlspecialchars($value['table']) . '`.';
            }elseif (!empty($tableNameDefault)) {
                $tmp .= "`" . Helpers_DB::htmlspecialchars($tableNameDefault) . '`.';
            }

			if ($value['field'] == '*') {
				$tmp .= '*';

				if ($functionName != '') {
					$tmp = $functionName . '(' . $tmp . ')';
				}
			} else {
				$tmp .= Helpers_DB::htmlspecialchars($value['field']);
				if ($functionName != '') {
					$tmp = $functionName . '(' . $tmp . ')';
				}
			}

			$result .= $tmp . ', ';
		}

		$result = substr($result, 0, strlen($result) - 2);

		if (!empty($result)) {
			$result = 'GROUP BY ' . $result;
		}

		return $result;
	}
}

