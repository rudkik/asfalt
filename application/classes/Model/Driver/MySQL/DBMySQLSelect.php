<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_MySQL_DBMySQLSelect extends  Model_Driver_DBBasicSelect
{

    /**
     * Возвращает SQLстроку
     * @param string $tableNameDefault
     * @return bool|string
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

            if ($value['table'] != '') {
                $tmp .= Helpers_DB::htmlspecialchars($value['table']) . '.';
            }elseif(($value['field'] == '*') && (!empty($tableNameDefault))){
                $tmp .= Helpers_DB::htmlspecialchars($tableNameDefault) . '.';
            }

			if ($value['field'] == '*') {
				$tmp .= '*';

				if ($functionName != '') {
					$tmp = $functionName . '(' . $tmp . ')';
				}
			} else {
				if (strpos($value['field'], '(') > -1) {
					$tmp .= $value['field'];
				} else {
					$tmp .= Helpers_DB::htmlspecialchars($value['field']);
				}

				if ($functionName != '') {
					$tmp = $functionName . '(' . $tmp . ')';
				}

				if ($value["new"] != '') {
					$tmp .= ' as ' . Helpers_DB::htmlspecialchars($value['new']);
				}
			}

			$result .= $tmp . ', ';
		}

		$result = substr($result, 0, strlen($result) - 2);

		if ($result == '') {
            if(!empty($tableNameDefault)){
                $result = Helpers_DB::htmlspecialchars($tableNameDefault) . '.';
            }
            $result .= '*';
		}

		return $result;
	}
}

