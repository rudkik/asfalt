<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_PgSQL_DBPgSQLWhere extends  Model_Driver_DBBasicWhere
{
    /**
     * добавляем условие
     * @param string $fieldName1
     * @param string $tableName1
     * @param string $fieldName2
     * @param string $tableName2
     * @param int $compareType
     * @param array $params
     * @return Model_Driver_DBBasicWhere
     */
	public function addField($fieldName1 = '', $tableName1 = '', $fieldName2 = '', $tableName2 = '',
                             $compareType = self::COMPARE_TYPE_EQUALLY, array $params = array())
	{
		$tmp = new Model_Driver_PgSQL_DBPgSQLWhere();
		$tmp->fieldName1 = $fieldName1;
		$tmp->tableName1 = $tableName1;
		$tmp->fieldName2 = $fieldName2;
		$tmp->tableName2 = $tableName2;
        $tmp->compareType = $compareType;
        $tmp->params = $params;

        $tmp->isFuncField1 = (strpos($tmp->fieldName1, '(') !== FALSE) || (strpos($tmp->fieldName1, ')') !== FALSE);

		$this->_fields[] = $tmp;
		return $tmp;
	}

	/** добавляем условие
	 * @param array $fields элементы 'field1' и 'value'
	 */
	public function addFields(array $fields)
	{
		foreach ($fields as $field) {
			$tmp = new Model_Driver_PgSQL_DBPgSQLWhere();

			$tmp->fieldName1 = $field['field'];
			$tmp->fieldName2 = $field['value'];
			$tmp->compareType = self::COMPARE_TYPE_EQUALLY;

            $tmp->isFuncField1 = (strpos($tmp->fieldName1, '(') !== FALSE) || (strpos($tmp->fieldName1, ')') !== FALSE);

			$this->_fields[] = $tmp;
		}
	}

    /**
     * Получаем строку запрос
     * @param bool $isWriteWhere
     * @param string $tableName1Default
     * @return string
     */
	public function getSQL($isWriteWhere = TRUE, $tableName1Default = '')
	{
		// если нет детворы для запроса
		if (count($this->_fields) == 0) {
			if (empty($this->fieldName1 || ($this->compareType == self::COMPARE_TYPE_IN && empty($this->fieldName2)))) {
				return '';
			}

			if (strpos($this->fieldName1, '(') < 0) {
				$this->fieldName1 = Helpers_DB::htmlspecialchars($this->fieldName1);
			}

			$field1 = '';
			if ($this->isFieldTable1) {
				if (!empty($this->tableName1)) {
                    $field1 = Helpers_DB::htmlspecialchars($this->tableName1) . '.';
				}elseif(!empty($tableName1Default)){
                    $field1 = Helpers_DB::htmlspecialchars($tableName1Default) . '.';
                }

                if ($this->isFuncField1){
                    $field1 = $this->fieldName1;
                }elseif ($this->fieldName1 == '*') {
                    $field1 .= '*';
				} else {
					if ($this->compareType == self::COMPARE_TYPE_LIKE || $this->compareType == self::COMPARE_TYPE_LIKE_BEGIN || ($this->compareType == self::COMPARE_TYPE_LIKE_SUBSTRING)
                        || ($this->compareType == self::COMPARE_TYPE_EQUALLY_LOWER)) {
                        $field1 = 'lower(' . $field1. Helpers_DB::htmlspecialchars($this->fieldName1) . ')';
					} else {
                        $field1 .= $this->fieldName1;
					}
				}
			} else {
				if ($this->compareType == self::COMPARE_TYPE_LIKE || $this->compareType == self::COMPARE_TYPE_LIKE_BEGIN || ($this->compareType == self::COMPARE_TYPE_EQUALLY_LOWER)) {
                    $field1 .= 'lower(' . $this->fieldName1 . ')';
				} else {
                    $field1 = $this->fieldName1;
				}
			}

			// сравнение полей
            $compare = '';
			switch ($this->compareType) {
				case self::COMPARE_TYPE_EQUALLY:
				case self::COMPARE_TYPE_EQUALLY_LOWER:
                    $compare .= ' = ';
					break;
				case self::COMPARE_TYPE_NOT_EQUALLY:
                    $compare .= ' <> ';
					break;
                case self::COMPARE_TYPE_LIKE:
                case self::COMPARE_TYPE_LIKE_BEGIN:
                case self::COMPARE_TYPE_LIKE_SUBSTRING:
                    $compare .= ' LIKE ';
					break;
				case self::COMPARE_TYPE_ISNULL:
                    $compare .= ' IS NULL ';
					break;
				case self::COMPARE_TYPE_MORE:
                    $compare .= ' > ';
					break;
				case self::COMPARE_TYPE_LESS:
                    $compare .= ' < ';
					break;
				case self::COMPARE_TYPE_MORE_EQUALLY:
                    $compare .= ' >= ';
					break;
				case self::COMPARE_TYPE_LESS_EQUALLY:
                    $compare .= ' <= ';
					break;
                case self::COMPARE_TYPE_IN:
                    $compare .= ' IN ';
                    break;
                case self::COMPARE_TYPE_LEXICON:
                    $compare .= ' @@ ';
                    break;
                case self::COMPARE_TYPE_REGULAR:
                    $compare .= ' ~ ';
                    break;
				default:
                    $compare .= ' = ';
			}

            $field2 = '';
			if (($this->compareType == self::COMPARE_TYPE_EQUALLY)
                || ($this->compareType == self::COMPARE_TYPE_MORE)
                || ($this->compareType == self::COMPARE_TYPE_LESS)
				|| ($this->compareType == self::COMPARE_TYPE_MORE_EQUALLY)
                || ($this->compareType == self::COMPARE_TYPE_LESS_EQUALLY)
                || ($this->compareType == self::COMPARE_TYPE_NOT_EQUALLY)
                || ($this->compareType == self::COMPARE_TYPE_LEXICON)
                || ($this->compareType == self::COMPARE_TYPE_REGULAR)
			) {
				if (($this->isFieldTable2) || (!empty($this->tableName2))) {
					if (!empty($this->tableName2)) {
                        $field2 .= Helpers_DB::htmlspecialchars($this->tableName2) . '.';
					}

					if ($this->fieldName2 == '*') {
                        $field2 .= '*';
					} else {
                        $field2 .= Helpers_DB::htmlspecialchars($this->fieldName2);
					}
				} else {
                    $field2 .= Helpers_DB::htmlspecialchars($this->fieldName2, "'");
				}
			}

			$result = '';

			// обрабатываем LIKE по частичному совпадению
            if ($this->compareType == self::COMPARE_TYPE_LIKE) {
                $result = $field1 . $compare . "'%" . Helpers_DB::htmlspecialchars(mb_strtolower($this->fieldName2)) . "%'";
            }elseif ($this->compareType == self::COMPARE_TYPE_LIKE_BEGIN) {
                $result = $field1 . $compare . "'" . Helpers_DB::htmlspecialchars(mb_strtolower($this->fieldName2)) . "%'";
            }elseif ($this->compareType == self::COMPARE_TYPE_LIKE_SUBSTRING) {
                // обрабатываем LIKE по частичному совпадению подстрок
                // разбиваем по подстрокам
                $arr = explode(' ', str_replace(' ', ' ',
                        str_replace("/r", ' ',
                            str_replace("/n", ' ',
                                str_replace("/t", ' ', trim($this->fieldName2))
                            )
                        )
                    )
                );

                $subs = '';
                foreach ($arr as $sub){
                    if (!empty($sub)){
                        $subs .= '(' . $field1 . $compare . "'%" . Helpers_DB::htmlspecialchars(mb_strtolower($sub)) . "%'" . ') AND';
                    }
                }
                $result = mb_substr($subs, 0, -4);
            }elseif ($this->compareType == self::COMPARE_TYPE_EQUALLY_LOWER) {
                // обрабатываем игнорирования регистра
                $result = $field1 . $compare . Helpers_DB::htmlspecialchars(mb_strtolower($this->fieldName2), "'");
			}elseif ($this->compareType == self::COMPARE_TYPE_IN) {
                // обрабатываем IN
                $s = '';
                if(is_array($this->fieldName2)) {
                    foreach ($this->fieldName2 as $value) {
                        $s = $s . Helpers_DB::htmlspecialcharsValuePg($value, "'") . ', ';
                    }
                    $s = substr($s, 0, -2);
                }else{
                    $s = Helpers_DB::htmlspecialcharsValuePg($this->fieldName2);
                }

                $result = $field1 . $compare . '(' . $s . ')';
			}elseif ($this->compareType == self::COMPARE_TYPE_LEXICON) {
			    // полнотекстовый поиск
                $result = 'to_tsvector(\'russian\', ' . $field1 . ')';

                $weight = Arr::path($this->params, 'weight', '');
                if (!empty($weight)) {
                    $result = 'setweight(' . $result . ', \'' . $weight . '\')';
                }

                $result .= ' '. $compare .' plainto_tsquery(\'russian\', ' . $field2 . ')';
            }else{
                $result = $field1 . $compare . $field2;
            }

			// не равно
			if ($this->isNot) {
                $result = 'NOT (' . $result . ')';
			}

            $result = '(' . $result . ')';

			return $result;
		}

		// условия сравнения (or, and)
		switch ($this->relationsType) {
			case self::RELATIONS_TYPE_OR:
				$relations = ' OR ';
				break;
			default:
				$relations = ' AND ';
		}

        $result = '';
		foreach ($this->_fields as $value) {
            $result .= $value->getSQL(FALSE, $tableName1Default) . $relations;
		}

		// отризает последний оператор
        $result = substr($result, 0, strlen($relations) * (-1));

		// не равно
		if ($this->isNot) {
            $result = 'NOT (' . $result . ')';
		}

		if (!empty($result)) {
            $result = '(' . $result . ')';

			if ($isWriteWhere === TRUE) {
                $result = 'WHERE ' . $result;
			}
		}

		return $result;
	}
}