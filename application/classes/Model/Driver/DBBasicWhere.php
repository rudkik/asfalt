<?php defined('SYSPATH') or die('No direct script access.');

class Model_Driver_DBBasicWhere extends Model {
	
	//список условий
	protected $_fields = array();
	
	// условия сравнения (or, and)
	const RELATIONS_TYPE_AND = 1;
	const RELATIONS_TYPE_OR = 2;
	
	public $relationsType = 1;
	
	// поле для сравнение
	public $fieldName1 = '';
	
	// название таблицы
	public $tableName1 = '';
	
	// является ли значение полем или значением поля
	public $isFieldTable1=1;
	
	// поле для сравнение
	public $fieldName2 = '';
	
	// название таблицы
	public $tableName2 = '';
	
	// является ли значение полем или значением поля
	public $isFieldTable2 = 0;
	
	// сравнение полей
	const COMPARE_TYPE_EQUALLY = 1; // равно
	const COMPARE_TYPE_LIKE = 2; // сравнение части строки
	const COMPARE_TYPE_ISNULL = 3; // равно ли NULL
	const COMPARE_TYPE_MORE = 4; // больше
	const COMPARE_TYPE_LESS = 5; // меньше
	const COMPARE_TYPE_MORE_EQUALLY = 6; // больше равно
	const COMPARE_TYPE_LESS_EQUALLY = 7; // меньше равно
	const COMPARE_TYPE_NOT_EQUALLY = 8; // не равно
	const COMPARE_TYPE_IN = 9; // in ()
	const COMPARE_TYPE_EQUALLY_LOWER = 10; // равно игнорируя регистр
    const COMPARE_TYPE_LIKE_SUBSTRING = 11; // сравнение части строки c массивом срок разделенных по разделителям: пробелы, табуляции и перенос строки
    const COMPARE_TYPE_LEXICON = 12; // полнотекстовый поиск
    const COMPARE_TYPE_REGULAR = 13; // проверка на регулярное выражение
    const COMPARE_TYPE_LIKE_BEGIN = 14; // сравнение части строки с начала
	
	public $compareType = 1;
	
	// отрицание операции NOT
	public $isNot = 0;

	// дополнительные параметры
	public $params = array();

    // название поля является функцией
    public $isFuncField1 = FALSE;

    /**
     * добавляем условие
     * @param string $fieldName1
     * @param string $tableName1
     * @param string $fieldName2
     * @param string $tableName2
     * @param int $compareType
     * @param array $params
     * @throws Exception
     * @return Model_Driver_DBBasicWhere
     */
	public function addField($fieldName1 = '', $tableName1 = '', $fieldName2 = '', $tableName2 = '',
                             $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, array $params = array())
	{
		throw new Exception('Function abstract.');
	}

    /**
     * Добавляем условие на NULL
     * @param $field
     * @param $tableName
     * @return Model_Driver_DBBasicWhere
     */
    public function addFieldIsNULL($field, $tableName)
    {
        return $this->addField($field, $tableName, '', '', self::COMPARE_TYPE_ISNULL);
    }

    /**
     * Добавление условие ИЛИ
     * @param $name
     * @return Model_Driver_DBBasicWhere
     */
    public function addOR($name)
    {
        $result = $this->addField($name);
        $result->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
        return $result;
    }

    /**
     * добавляем условие LIKE
     * @param string $fieldName1
     * @param string $tableName1
     * @param string $fieldName2
     * @param string $tableName2
     * @param array $params
     * @throws Exception
     */
    public function addFieldLike($fieldName1 = '', $tableName1 = '', $fieldName2 = '', $tableName2 = '', array $params = array())
    {
        $this->addField($fieldName1, $tableName1, $fieldName2, $tableName2, self::COMPARE_TYPE_LIKE, $params);
    }
	

	/** получаем строку запрос
	 * @return string
	 */
	public function getSQL()
	{

	}
}