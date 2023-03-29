<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_MySQL_DBMySQLWhere extends  Model_Driver_DBBasicWhere
{

    /** добавляем условие
     * @param string $fieldName1 - название/значение поля
     * @param string $fieldName2 - название/значение поля
     * @param string $compareType - как сравнивать
     * @return MySQLWhere
     */
    public function addField($fieldName1 = "", $tableName1 = "", $fieldName2 = "", $tableName2 = "",
                             $compareType = self::COMPARE_TYPE_EQUALLY, array $params = array())
    {
        $tmp = new Model_Driver_MySQL_DBMySQLWhere();
        $tmp->fieldName1 = $fieldName1;
        $tmp->tableName1 = $tableName1;
        $tmp->fieldName2 = $fieldName2;
        $tmp->tableName2 = $tableName2;
        $tmp->compareType = $compareType;

        $this->_fields[] = $tmp;
        return $tmp;
    }

    /** добавляем условие
     * @param array $fields элементы 'field1' и 'value'
     */
    public function addFields(array $fields)
    {
        foreach ($fields as $field) {
            $tmp = new Model_Driver_MySQL_DBMySQLWhere();

            $tmp->fieldName1 = $field['field'];
            $tmp->fieldName2 = $field['value'];
            $tmp->compareType = Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_EQUALLY;

            $this->_fields[] = $tmp;
        }
    }

    /** получаем строку запрос
     * @return string
     */
    public function getSQL($isWriteWhere = TRUE, $tableName1Default = '')
    {
        // если нет детворы для запроса
        if (count($this->_fields) < 1) {
            if (empty($this->fieldName1)) {
                return '';
            }

            $tmp = "";
            if ($this->isFieldTable1) {
                if (!empty($this->tableName1)) {
                    $tmp = "`" . Helpers_DB::htmlspecialchars($this->tableName1) . '`.';
                }elseif(!empty($tableName1Default)){
                    $tmp = Helpers_DB::htmlspecialchars($tableName1Default) . '.';
                }

                if ($this->fieldName1 == "*") {
                    $tmp .= '*';
                } else {
                    $tmp .= "`" . Helpers_DB::htmlspecialchars($this->fieldName1) . "`";
                }
            } else {
                $tmp = "'" . Helpers_DB::htmlspecialchars($this->fieldName1) . "'";
            }

            // сравнение полей
            switch ($this->compareType) {
                case self::COMPARE_TYPE_EQUALLY:
                    $tmp .= " = ";
                    break;
                case self::COMPARE_TYPE_NOT_EQUALLY:
                    $tmp .= " <> ";
                    break;
                case self::COMPARE_TYPE_LIKE:
                    $tmp .= " LIKE ";
                    break;
                case self::COMPARE_TYPE_ISNULL:
                    $tmp .= " IS NULL ";
                    break;
                case self::COMPARE_TYPE_MORE:
                    $tmp .= " > ";
                    break;
                case self::COMPARE_TYPE_LESS:
                    $tmp .= " < ";
                    break;
                case self::COMPARE_TYPE_MORE_EQUALLY:
                    $tmp .= " >= ";
                    break;
                case self::COMPARE_TYPE_LESS_EQUALLY:
                    $tmp .= " <= ";
                    break;
                case self::COMPARE_TYPE_IN:
                    $tmp .= " IN ";
                    break;
                default:
                    $tmp .= " = ";
            }

            if (($this->compareType != Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_ISNULL)
                && ($this->compareType != Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_LIKE)
                && ($this->compareType != Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_LIKE_BEGIN)
                && ($this->compareType != Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_IN)
            ) {
                if ($this->isFieldTable2) {
                    if ($this->tableName2 != "") {
                        $tmp .= "`" . Helpers_DB::htmlspecialchars($this->tableName2) . '`.';
                    }

                    if ($this->fieldName2 == "*") {
                        $tmp .= '*';
                    } else {
                        $tmp .= "`" . Helpers_DB::htmlspecialchars($this->fieldName2) . "`";
                    }
                } else {
                    $tmp .= "'" . Helpers_DB::htmlspecialchars($this->fieldName2) . "'";
                }
            }

            // обрабатываем LIKE по частичному совпадению
            if ($this->compareType == Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_LIKE) {
                $tmp .= "'%" . Helpers_DB::htmlspecialchars($this->fieldName2) . "%'";
            }

            // обрабатываем LIKE по частичному совпадению с начала
            if ($this->compareType == Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_LIKE_BEGIN) {
                $tmp .= "'" . Helpers_DB::htmlspecialchars($this->fieldName2) . "%'";
            }

            // обрабатываем IN
            if ($this->compareType == Model_Driver_MySQL_DBMySQLWhere::COMPARE_TYPE_IN) {
                $s = '';
                if(is_array($this->fieldName2)) {
                    foreach ($this->fieldName2 as $value) {
                        $s = $s . Helpers_DB::htmlspecialchars($value) . ', ';
                    }
                    $s = substr($s, 0, -2);
                }else{
                    $s = Helpers_DB::htmlspecialchars($this->fieldName2);
                }

                $tmp .= "(" . $s . ")";
            }

            // не равно
            if ($this->isNot) {
                $tmp = "NOT (" . $tmp . ")";
            }

            $tmp = "(" . $tmp . ")";

            return $tmp;
        }

        // условия сравнения (or, and)
        switch ($this->relationsType) {
            case Model_Driver_MySQL_DBMySQLWhere::RELATIONS_TYPE_AND:
                $relations = " and ";
                break;
            case Model_Driver_MySQL_DBMySQLWhere::RELATIONS_TYPE_OR:
                $relations = " or ";
                break;
            default:
                $relations = " and ";
        }

        $tmp = "";
        foreach ($this->_fields as $value) {
            $tmp .= $value->getSQL(FALSE, $tableName1Default) . $relations;
        }

        // отризает последний оператор
        $tmp = substr($tmp, 0, strlen($relations) * (-1));

        // не равно
        if ($this->isNot) {
            $tmp = "NOT (" . $tmp . ")";
        }

        if (!empty($tmp)) {
            $tmp = "(" . $tmp . ")";

            if ($isWriteWhere === TRUE) {
                $tmp = 'WHERE ' . $tmp;
            }
        }

        return $tmp;
    }
}