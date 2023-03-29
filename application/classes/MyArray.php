<?php defined('SYSPATH') OR die('No direct script access.');

class MyArray {

	// ID элемента
	public $id;

	// список значений для вьюшки
	public $values = array();

	// готовая вьюшка
	public $str = NULL;

    /**
     * детвора элемента
     * @var array | MyArray[]
     */
	public $childs = array();

	// дополнительные данные
	public $additionDatas = array();

	public $siteData = NULL;

	// найдена ли запись в базе данных
	public $isFindDB = FALSE;
	public $isLoadElements = FALSE;
    public $isParseData = TRUE;

    private $isSetRoot;
    /**
     * Родительский элемент
     * @var MyArray
     */
    private $root = null;

    /**
     * По массиву ID создаем список детворы
     * MyArray constructor.
     * @param array $ids
     * @param bool $isSetRoot
     */
	public function __construct(array $ids = array(), $isSetRoot = false){
		foreach ($ids as $id){
			$this->addChild($id);
		}

		$this->isSetRoot = $isSetRoot;
	}

    /**
     * Уменьшаем количество детворы
     * @param $count
     */
    public function setCount($count){
        if($count > -1 && count($this->childs) > $count){
            $this->childs = array_slice($this->childs, 0, $count);
        }
    }

    /**
     * Возвращаем родителя
     * @return MyArray
     */
    public function getRoot(){
        return $this->root;
    }

    /**
     * Перестройка родителей для детворы
     */
    public function runRoot(){
        foreach ($this->childs as $child) {
            $child->root = $this;
            $child->runRoot();
        }
    }

    /**
     * Возвращаем количество детворы
     * @param bool $isCalcLastChild
     * @return int
     */
    public function getChildrenCount($isCalcLastChild = false){
        if($isCalcLastChild) {
            $result = 0;
            foreach ($this->childs as $child) {
                if(count($child->childs) > 0){
                    $result += $child->getChildrenCount(true);
                }else{
                    $result++;
                }
            }
        }else{
            $result = count($this->childs);
        }

        return $result;
    }

    /**
     * Из массива добавляем детвору
     * @param array $list
     * @return $this
     */
    public function addChildrenArray(array $list){
        foreach ($list as $one){
            $child = $this->addChild(0);
            $child->values = $one;
            $child->setIsFind(true);
        }

        return $this;
    }
    /**
     * Добавление ID проверяем на уникальность
     * @param $id
     * @param bool $isIndexID
     * @return mixed|MyArray
     */
	public function addUniqueChild($id, $isIndexID = FALSE){
	    if ($isIndexID){
	        if(key_exists($id, $this->childs)){
                return $this->childs[$id];
            }
        }else{
            foreach ($this->childs as $value) {
                if ($value->id == $id) {
                    return $value;
                }
            }
        }

		$tmp = new MyArray();
		$tmp->id = $id;
		if($isIndexID){
            $this->childs[$id] = $tmp;
        }else {
            $this->childs[] = $tmp;
        }

		return $tmp;
	}

    /**
     * Добавление объект по индексу
     * @param $index
     * @param MyArray $obj
     * @return MyArray
     */
    public function addChildObjectIndex($index, MyArray $obj){
        $this->childs[$index] = $obj;
        if($this->isSetRoot){
            $obj->root = $this;
        }

        return $obj;
    }

    /**
     * Добавление объект
     * @param MyArray $obj
     * @param int $rooID
     * @return MyArray
     */
	public function addChildObject(MyArray $obj, $rooID = 0){
		if ($rooID < 1){
			$this->childs[] = $obj;
            if($this->isSetRoot){
                $obj->root = $this;
            }
		}else{
			$root = $this->findChild($rooID);
			if ($root != NULL){
				$root->childs[] = $obj;
                if($this->isSetRoot){
                    $obj->root = $this;
                }
			}
		}

		return $obj;
	}

    /**
     * Добавление ID в указанного родителя, создается дерево
     * @param integer $id
     * @param integer $rooID
     * @param bool $isIndexID
     * @return MyArray|null
     */
	public function addChild($id, $rooID = 0, $isIndexID = FALSE){
		if ($rooID < 1){
            if(($isIndexID) && key_exists($id, $this->childs)) {
                return $this->childs[$id];
            }

			$tmp = new MyArray();
			$tmp->id = $id;

            if($this->isSetRoot){
                $tmp->root = $this;
            }

			if($isIndexID) {
                $this->childs[$id] = $tmp;
            }else{
                $this->childs[] = $tmp;
            }

			return $tmp;
		}else{
			$root = $this->findChild($rooID);
			if ($root !== NULL){
                if(($isIndexID) && key_exists($id, $root->childs)) {
                    return $root->childs[$id];
                }

				$tmp = new MyArray();
				$tmp->id = $id;

                if($this->isSetRoot){
                    $tmp->root = $this;
                }

				if($isIndexID) {
                    $root->childs[$id] = $tmp;
                }else{
                    $root->childs[] = $tmp;
                }

				return $tmp;
			}
		}

		return NULL;
	}

	/**
	 * Идет поиск по дереву элементов
	 * @param integer $id
	 * @return MyArray|NULL
	 */
	public function findChild($id){
		foreach ($this->childs as $value) {
			if($value->id == $id){
				return $value;
			}

			$tmp = $value->findChild($id);
			if ($tmp !== NULL){
				return $tmp;
			}
		}

		return NULL;
	}

    /**
     * Идет поиск по дереву элементов и возвращаем значение найденного элемента
     * @param $id
     * @param $field
     * @param string $default
     * @param bool $isChildRunIndex - предварительно проиндексированы ли детвора
     * @return mixed|string
     */
    public function findChildResultValue($id, $field, $default = '', $isChildRunIndex = false){
        $result = false;
        if($isChildRunIndex){
            if(key_exists($id, $this->childs)){
                $result = $this->childs[$id];
            }
        }else{
            $result = $this->findChild($id);
        }

        if($result === false){
            return $default;
        }

        return Arr::path($result->values, $field, $default);
    }

    /**
     * Находим список детворы по заданным значениям
     * @param array $values
     * @return MyArray
     */
    public function findChildren(array $values){
        $result = new MyArray();
        foreach ($this->childs as $child) {
            $isFind = TRUE;
            foreach ($values as $key => $value){
                if (Arr::path($child->values, $key, NULL) != $value) {
                    $isFind = FALSE;
                    break;
                }
            }
            if ($isFind){
                $result->addChildObject($child);
            }
        }

        return $result;
    }


    /**
     * Идет поиск по дереву элементов
     * @param string $name
     * @param string $value
     * @param bool $isFindChildren
     * @return bool|MyArray
     */
    public function findChildValue($name, $value, $isFindChildren = TRUE){
        return $this->findChildValues(array($name => $value), $isFindChildren);
    }

    /**
     * Идет поиск по дереву элементов
     * @param array $findValues
     * @param bool $isFindChildren
     * @return bool|MyArray
     */
	public function findChildValues($findValues, $isFindChildren = TRUE){
		foreach ($this->childs as $child) {
            $bool = TRUE;
            foreach ($findValues as $name => $value){
                if (Arr::path($child->values, $name, NULL) != $value) {
                    $bool = FALSE;
                    break;
                }
            }
            if($bool == TRUE){
                return $child;
            }

            if($isFindChildren){
                $tmp = $child->findChildValue($name, $value);
                if ($tmp !== FALSE){
                    return $tmp;
                }
            }
		}

		return FALSE;
	}

    /**
     * Удаляем ребенка
     * @param MyArray $child
     * @return bool
     */
    public function removeChild(MyArray $child)
    {
        $key = array_search($child, $this->childs, true);
        if ($key === false) {
            return false;
        }
        unset($this->childs[$key]);

        return true;
    }

    /**
     * Возвращается массив id элементов со всей детворой
     * @param array $data
     * @return array
     */
	public function getArrayID(array &$data){
		foreach ($this->childs as $child) {
			// соединяем все массивы
            $child->getArrayID($data);
			$data[] = $child->id;
		}

		return $data;
	}

    /**
     * Возвращается массив id элементов со всей детворой
     * @param bool $isUnique
     * @return array
     */
	public function getChildArrayID($isUnique = FALSE){
		$data = array();
		$this->getArrayID($data);

		if($isUnique){
			$data = array_unique($data);
		}
		return $data;
	}

    /**
     * Возвращается массив детворы с заданными полями
     * @param array $fields
     * @return array
     */
    public function getChildsFields(array $fields = array()){
        $result = array();

        if(empty($fields)){
            foreach ($this->childs as $child) {
                $result[] = $child->values;
            }
        }else {
            foreach ($this->childs as $value) {
                $array = array();
                foreach ($fields as $field) {
                    if (key_exists($field, $value->values)) {
                        $array[$field] = $value->values[$field];
                    }
                }

                $result[] = $array;
            }
        }

        return $result;
    }

    /**
     * Возвращается массив значений со всей детворы
     * @param $name
     * @return array
     */
	public function getChildArrayValue($name){
		$result = array();
		foreach ($this->childs as $value) {
			if (key_exists($name, $value->values)){
				$result[] = $value->values[$name];
			}
		}

		return $result;
	}

    /**
     * Возвращается массив значений больше 0 со всей детворы
     * @param $name
     * @param bool $isUnique
     * @return array
     */
	public function getChildArrayInt($name, $isUnique = FALSE){
		$result = array();
		foreach ($this->childs as $child) {
            $value = Arr::path($child->values, $name, NULL);
            if($value === NULL){
               continue;
            }

            if(intval($value) > 0) {
                if ($isUnique) {
                    $result[$value] = $value;
                }else{
                    $result[] = $value;
                }
            }
		}

		return $result;
	}

    /**
     * Передаем дополнительные параментры всех детворе
     * @param array
     */
    public function addAdditionDataChilds(array $data){
        foreach ($this->childs as $value) {
            foreach ($data as $childKey => $childValue) {
                $value->additionDatas[$childKey] = $childValue;
            }

            $value->addAdditionDataChilds($data);
        }
    }

    /**
     * Заменяем данные из одной переменной в другой
     * @param $fieldFrom
     * @param $fieldTo
     */
    public function replaceChildValue($fieldFrom, $fieldTo){
        foreach ($this->childs as $child) {
            $child->values[$fieldFrom] = Arr::path($child->values, $fieldTo);
        }
    }

	public function deleteChild($index){
		$count = count($this->childs);

		if (($count > $index) && ($index > -1)){
			for ($i = $index; $i < $count-1; $i++) {
				$this->childs[$i] = $this->childs[$i+1];
			}
			unset($this->childs[$count-1]); // Это удаляет элемент из массива
		}
	}

	public function deleteChildByID($id){

        for ($i = 0; $i < count($this->childs); $i++) {
            $child = $this->childs[$i];

            if ($this->childs[$i]->id == $id) {
                $this->deleteChild($i);
                return TRUE;
            }

            if ($child->deleteChildByID($id)){
                return TRUE;
            }
        }

        return FALSE;
	}

	public function cloneObj(MyArray $data){
		$this->id = $data->id;

		// список значений для вьюшки
		$this->values = $data->values;

		// готовая вьюшка
		$this->str = $data->str;

		// детвора элемента
		$this->childs = $data->childs;

		// дополнительные данные
		$this->additionDatas = $data->additionDatas;

		$this->siteData = $data->siteData;

		// найдена ли запись в базе данных
        $this->isFindDB = $data->isFindDB;
        $this->isLoadElements = $data->isLoadElements;
        $this->isParseData = $data->isParseData;

        return $this;
    }

    /**
     * Получаем массив дополнительных переменных
     * @return array
     */
	public function getAdditionDataChilds(){
		$result = array();
		foreach ($this->childs as $value) {
			$result[] = $value->additionDatas;
		}

		return $result;
	}

    private $_sortFields = array();
	private $_sortASC = TRUE;

	/**
     * @param MyArray $a
     * @param MyArray $b
     * @return int
     */
	private function isEqual(MyArray $a, MyArray $b) {
		foreach($this->_sortFields as $sortField){
            $value1 = Arr::path($a->values, $sortField, Arr::path($a->additionDatas, $sortField, NULL));
            $value2 = Arr::path($b->values, $sortField, Arr::path($b->additionDatas, $sortField, NULL));

            if(floatval($value1) && floatval($value2)){
                if ($value1 != $value2) {
					if($this->_sortASC){
						return ($value1 < $value2) ? -1 : 1;
					}else {
						return (($value1 < $value2) ? -1 : 1) * (-1);
					}
                }
            }else{
                $result = strnatcmp($value1, $value2);
                if($result !== 0){
					if($this->_sortASC) {
						return $result;
					}else{
						return $result * (-1);
					}
                }
            }
        }

        return 0;
	}

    /**
     * @param MyArray $a
     * @param MyArray $b
     * @return int
     */
    private function isEqualByAscOrDesc(MyArray $a, MyArray $b) {
        foreach($this->_sortFields as $sortField => $isAsc){
            $value1 = Arr::path($a->values, $sortField, NULL);
            if($value1 === null){
                $value1 = Arr::path($a->additionDatas, $sortField, NULL);
                if($value1 === null){
                    $value1 = Arr::path($a->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$sortField, NULL);
                }
            }
            $value2 = Arr::path($b->values, $sortField, NULL);
            if($value2 === null){
                $value2 = Arr::path($b->additionDatas, $sortField, NULL);
                if($value2 === null){
                    $value2 = Arr::path($b->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$sortField, NULL);
                }
            }

            if(($isAsc == 'asc')  || ($isAsc === TRUE)){
                $isAsc = TRUE;
            }else{
                $isAsc = FALSE;
            }

            if(((is_float($value1) || is_integer($value1) || substr_count($value1, '.') < 2)
                    && (is_float($value2) || is_integer($value2) || substr_count($value2, '.') < 2))
                &&((is_numeric($value1) && is_numeric($value2))
                    || (is_numeric($value1) && $value2 === null)
                    || ($value1 === null && is_numeric($value2)))){
                $value1 = floatval($value1);
                $value2 = floatval($value2);
                $result = strnatcmp($value1, $value2);
            }else{
                $date1 = strtotime($value1, null);
                $date2 = strtotime($value2, null);
                if(!empty($date1) && !empty($date2)){
                    $result = strnatcmp($date1, $date2);
                }else {
                    $result = strnatcmp($value1, $value2);
                }
            }

            if($result === 0){
                continue;
            }

            if(!$isAsc || !$this->_sortASC){
                $result = $result * (-1);
            }

            return $result;
        }

        return 0;
    }

    /**
     * Сортируем по параметрам values или additionDatas
     * @param array $fields - array('all' => 'desc', 'price_extra' => 'asc', 'price_child' => 'asc') или array('all', 'price_extra', 'price_child')
     * @param bool $isASC
     * @param bool $isFieldsASC - если для каждого поля отдельно задаем тип сортировки
     */
	public function childsSortBy(array $fields, $isASC = TRUE, $isFieldsASC = FALSE) {
        $this->_sortFields = $fields;
		$this->_sortASC = $isASC;

		if($isFieldsASC){
            usort($this->childs, array($this, 'isEqualByAscOrDesc'));
        }else {
            usort($this->childs, array($this, 'isEqual'));
        }
	}

    /**
     * Возвращается массив детворы с указанными полями
     * название полей может быть путем по массиву
     * @param array $fields ключ массива откуда брать значение массива куда ложить
     * @param bool $FromAndToEqually если откуда брать элемент и куда ложить одинаковое значение то TRUE
     * @return array
     */
    public function getArrayChildrenWithFields(array $fields, $FromAndToEqually = FALSE){
        $result = array();
        if (empty($fields)){
            foreach ($this->childs as $value) {
                $result[] = $value->values;
            }
        }elseif($FromAndToEqually) {
            foreach ($this->childs as $value) {
                $child = array();
                foreach ($fields as $field) {
                    Arr::set_path($child, $field, Arr::path($value->values, $field, NULL));
                }

                $result[] = $child;
            }
        }else{
            foreach ($this->childs as $value) {
                $child = array();
                foreach ($fields as $fieldFrom => $fieldTo) {
                    Arr::set_path($child, $fieldTo, Arr::path($value->values, $fieldFrom, NULL));
                }

                $result[] = $child;
            }
        }

        return $result;
    }

    /**
     * Переобразуем дерево в список
     * @param array $children
     */
    private function _treeInList(array &$children) {
        foreach ($this->childs as $child) {
            $children[] = $child;

            $child->_treeInList($children);
            $child->childs = [];
        }
    }

    /**
     * Переобразуем дерево в список
     * @return $this
     */
    public function treeInList() {
        $children = array();
        $this->_treeInList($children);
        $this->childs = $children;

        return $this;
    }

    /**
     * Индексируем массив номера элементов массива, это id записи
     * @param bool $isIndexID
     * @param string | array $fieldName
     * @param string $keyPostfix
     */
    public function runIndex($isIndexID = TRUE, $fieldName = 'id', $keyPostfix = '_') {
        $childs = array();
        if ($isIndexID) {
            if(is_array($fieldName)){
                foreach ($this->childs as $child) {
                    $key = [];
                    foreach ($fieldName as $fieldOne) {
                        if (empty($fieldOne) || $fieldOne == 'id') {
                            $key[] = $child->id;
                        } else {
                            $key[] = Arr::path($child->values, $fieldOne, '');
                        }
                    }

                    $childs[implode($keyPostfix, $key)] = $child;
                }
            }else {
                foreach ($this->childs as $child) {
                    if (empty($fieldName) || $fieldName == 'id') {
                        $childs[$child->id] = $child;
                    } else {
                        $childs[Arr::path($child->values, $fieldName, '')] = $child;
                    }
                }
            }
        }else{
            foreach ($this->childs as $child) {
                $childs[] = $child;
            }
        }
        $this->childs = $childs;
    }

    /**
     * Индексируем массив номера элементов массива, это список записей
     * @param array $fieldsName
     * @param string $delimiter
     */
    public function runIndexFields(array $fieldsName, $delimiter = '_') {

        $childs = array();
        foreach ($this->childs as $child) {
            $key = '';
            foreach ($fieldsName as $field){
                $key = $key . Arr::path($child->values, $field, '') . $delimiter;
            }
            $key = mb_substr($key, 0, mb_strlen($delimiter) * -1);

            $childs[$key] = $child;
        }
        $this->childs = $childs;
    }

    /**
     * Получаем значение дополнительного элемента объекта
     * @param $elementName
     * @param string $fieldName
     * @param string $default
     * @return mixed
     */
    public function getElementValue($elementName, $fieldName = 'name', $default = '') {
        if (empty($fieldName)){
            return Arr::path($this->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$elementName, $default);
        }else{
            return Arr::path($this->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$elementName.'.'.$fieldName, $default);
        }
    }

    /**
     * Задаем значение дополнительного элемента объекта
     * @param $elementName
     * @param string $value
     * @param string $fieldName
     * @return mixed
     */
    public function setElementValue($elementName, $value, $fieldName = 'name') {
        if (empty($fieldName)){
            return Arr::set_path($this->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$elementName, $value);
        }else{
            return Arr::set_path($this->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$elementName.'.'.$fieldName, $value);
        }
    }

    /**
     * Сохраняем первого ребенка в $model
     * @param Model_Basic_BasicObject $model
     * @return bool
     */
    public function saveChildValuesInModel(Model_Basic_BasicObject $model) {
        $result = count($this->childs) > 0;
        if ($result){
            $model->__setArray(
                array(
                    'values' => $this->childs[0]->values
                )
            );
        }

        return $result;
    }

    /**
     * Переводи из модели в MyArray
     * @param Model_Basic_BasicObject $model
     * @param SitePageData $sitePageData
     * @param $elements
     */
    public function setValues(Model_Basic_BasicObject $model, SitePageData $sitePageData, $elements = NULL) {
        if(is_array($elements)){
            foreach ($elements as $key => $value){
                if(is_array($value)){
                    $value = $key;
                }

                $model->getElement($value, TRUE, $sitePageData->shopMainID);
            }

            $this->isLoadElements = TRUE;
        }

        $this->id = $model->id;
        $this->values = $model->getValues(TRUE, TRUE, $sitePageData->shopMainID);
        $this->isFindDB = TRUE;
        $this->isParseData = TRUE;
    }

    /**
     * Переводи из MyArray в модель
     * @param Model_Basic_DBValue $model
     */
    public function setModel(Model_Basic_DBValue $model) {
        $model->clear();
        $model->__setArray(array('values' => $this->values));
    }

    /**
     * Создаем модель из MyArray
     * @param $dbObject
     * @param Model_Driver_DBBasicDriver|null $driver
     * @return Model_Basic_LanguageObject
     */
    public function createModel($dbObject, Model_Driver_DBBasicDriver $driver = null) {
        $model = DB_Basic::createModel($dbObject, $driver);
        $model->__setArray(array('values' => $this->values));

        return $model;
    }

    /**
     * Переводи из MyArray в модель и возвращаем модель
     * @param Model_Basic_DBValue $model
     * @param Model_Driver_DBBasicDriver $driver
     * @return Model_Basic_DBValue
     */
    public function getModel(Model_Basic_DBValue $model, Model_Driver_DBBasicDriver $driver = null) {
        if($driver != null) {
            $model->setDBDriver($driver);
        }
        $model->__setArray(array('values' => $this->values));

        return $model;
    }

    /**
     * Устанавливаем значение как найденая
     * @param bool $isFind
     * @return $this
     */
    public function setIsFind($isFind = TRUE) {
        $this->isFindDB = $isFind;
        $this->isParseData = !$isFind;
        $this->isLoadElements = $isFind;

        return $this;
    }

    /**
     * Возвращается массив id детворы с порядковым номером
     * @return array
     */
    public function getIndexChildIDs(){
        $index = array();
        foreach ($this->childs as $key => $child){
            $index[$child->id] = $key;
        }

        return $index;
    }

    /**
     * Добавляем детвору из другого массива
     * @param MyArray $data
     */
    public function addChilds(MyArray $data){
        foreach ($data->childs as $child){
            $this->childs[] = $child;

            if($this->isSetRoot){
                $child->root = $this;
            }
        }
    }

    /**
     * Группируем детвору по параметрам values или additionDatas
     * @param string $field
     * @return array
     */
    public function childsGroupBy($field) {
        $result = [];
        foreach ($this->childs as $child){
            $key = Arr::path($child->values, $field, Arr::path($child->additionDatas, $field, NULL));

            if(!key_exists($key, $result)){
                $result[$key] = [];
            }

            $result[$key][] = $child;
        }

        return $result;
    }

    /**
     * Считаем сумму значений
     * @param $field
     * @return int|float
     */
    public function calcTotalChild($field) {

        $result = 0;
        foreach ($this->childs as $child) {
            $result += floatval(Arr::path($child->values, $field, 0));
        }

        return $result;
    }

    /**
     * Считаем сумму нескольких значений
     * @param array $fields
     * @param bool $isAdditionData
     * @return array
     */
    public function calcTotalsChild(array $fields, $isAdditionData = false) {

        $result = array();
        foreach ($fields as $field){
            $result[$field] = 0;
        }

        if($isAdditionData) {
            foreach ($this->childs as $child) {
                foreach ($fields as $field) {
                    $result[$field] += floatval(Arr::path($child->additionDatas, $field, 0));
                }
            }
        }else{
            foreach ($this->childs as $child) {
                foreach ($fields as $field) {
                    $result[$field] += floatval(Arr::path($child->values, $field, 0));
                }
            }
        }

        return $result;
    }

    /**
     * Из детворы вырезаем элемент которые соответствует заданным параметрам
     * @param int $id
     * @param int $shopID
     * @param bool $isIndexID
     * @param array $values
     * @return MyArray|null
     */
    public function childShift($id = 0, $shopID = 0, $isIndexID = false, array $values = array()){
        $isFind = function (MyArray $child, array $values) {
            if(empty($values)){
                return true;
            }

            foreach ($values as $key => $value) {
                if(Arr::path($child->values, $key, null) != $value){
                    return false;
                }
            }

            return true;
        };

        if($id < 1 && $shopID < 1 && empty($values)){
            return array_shift($this->childs);
        }

        if($isIndexID){
            if(key_exists($id, $this->childs)){
                $child = $this->childs[$isIndexID];
                if(($id < 1 || $child->id == $id)
                    && ($shopID < 1 || $child->values['shop_id'] == $shopID)
                    && $isFind($child, $values)){
                    unset($this->childs[$isIndexID]);
                    return $child;
                }
            }

            return NULL;
        }

        if(empty($values)) {
            foreach ($this->childs as $key => $child) {
                if ((($id < 1 || $child->id == $id) && ($shopID < 1 || $child->values['shop_id'] == $shopID))) {
                    unset($this->childs[$key]);
                    return $child;
                }
            }
            return NULL;
        }

        foreach ($this->childs as $key => $child) {
            if ($isFind($child, $values)) {
                unset($this->childs[$key]);
                return $child;
            }
        }

        return NULL;
    }

    /**
     * Из детворы вырезаем элемент которые соответствует заданным параметрам и передаем в модель
     * @param Model_Basic_DBValue $model
     * @param int $id
     * @param int $shopID
     * @param bool $isIndexID
     * @param array $values
     * @return MyArray|null
     */
    public function childShiftSetModel(Model_Basic_DBValue $model, $id = 0, $shopID = 0, $isIndexID = false, array $values = array()){
        $child = $this->childShift($id, $shopID, $isIndexID, $values);
        if ($child !== NULL) {
            $child->setModel($model);
        } else {
            $model->clear();
        }

        return $child;
    }

    /**
     * Cnh
     * @param string $fieldName
     * @return $this
     */
    public function buildTree($fieldName = 'root_id') {
        if(!is_array($fieldName)){
            $fieldName = array($fieldName);
        }
        $result = $this->childs;
        $this->childs = array();
        for($i = 0; $i < 100; $i++) {
            $arrNew = array();
            foreach ($result as $child) {
                $rootID = 0;
                foreach ($fieldName as $field){
                    $rootID = $child->values[$field];
                    if($rootID > 0){
                        break;
                    }
                }

                if($rootID == 0){
                    $this->addChildObject($child);
                }else {
                    $root = $this->findChild($rootID);
                    if($root != null){
                        $root->addChildObject($child);
                    }else{
                        $arrNew[] = $child;
                    }
                }
            }
            $result = $arrNew;

            if(count($arrNew) == 0){
                break;
            }
        }
        foreach ($result as $child) {
            $this->addChildObject($child);
        }

        return $this;
    }


}