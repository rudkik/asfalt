<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Catalog extends Model_Shop_Basic_FormData{

	const TABLE_NAME = 'ct_shop_table_catalogs';
	const TABLE_ID = 4;

    public function __construct(array $overallLanguageFields = array(), $tableName = 'ct_shop_table_catalogs', $tableID = self::TABLE_ID, $isTranslate = TRUE){

        $overallLanguageFields[] = 'table_id';
        $overallLanguageFields[] = 'root_table_id';
        $overallLanguageFields[] = 'root_shop_table_catalog_id';
        $overallLanguageFields[] = 'child_shop_table_catalog_ids';

        parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		if ($this->id < 1){
			$validation->rule('name', 'not_empty');
            $validation->rule('table_id', 'digit');
		}

		$validation->rule('name', 'max_length', array(':value', 100))
            ->rule('table_id', 'max_length', array(':value', 11))
            ->rule('root_table_id', 'max_length', array(':value', 11))
            ->rule('root_shop_table_catalog_id', 'max_length', array(':value', 11))
			->rule('text', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('table_id')) {
            $validation->rule('table_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('root_table_id')) {
            $validation->rule('root_table_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('root_shop_table_catalog_id')) {
            $validation->rule('root_shop_table_catalog_id', 'digit');
        }

		return $this->_validationFields($validation, $errorFields);
	}

    /**
     * Возвращаем cписок всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray) {
            $arr['child_shop_table_catalog_ids'] = $this->getChildShopTableCatalogIDsArray();
            $arr['fields_params'] = $this->getFieldsParamsArray();
        }

        return $arr;
    }

	// Название
	public function setName($value){
		$this->setValue('name', $value);
	}

	public function getName(){
		return $this->getValue('name');
	}

	//	Описание каталога (HTML-код)
	public function setText($value){
		$this->setValue('text', $value);
	}

	public function getText(){
		return $this->getValue('text');
	}

    public function setTableID($value)
    {
        $this->setValue('table_id', intval($value));
    }

    public function getTableID()
    {
        return intval($this->getValue('table_id'));
    }

    public function setRootTableID($value)
    {
        $this->setValue('root_table_id', intval($value));
    }

    public function getRootTableID()
    {
        return intval($this->getValue('root_table_id'));
    }

    public function setRootShopTableCatalogID($value)
    {
        $this->setValue('root_shop_table_catalog_id', intval($value));
    }

    public function getRootShopTableCatalogID()
    {
        return intval($this->getValue('root_shop_table_catalog_id'));
    }

    // JSON настройки списка полей
    public function setChildShopTableCatalogIDs($value){
        $this->setValue('child_shop_table_catalog_ids', $value);
    }

    public function getChildShopTableCatalogIDs(){
        return $this->getValue('child_shop_table_catalog_ids');
    }

    // JSON настройки списка полей
    public function setChildShopTableCatalogIDsArray(array $value, $languageID = Model_Language::LANGUAGE_RUSSIAN){
        $tmp = $this->getChildShopTableCatalogIDs();
        if (empty($tmp)){
            $tmp = array($languageID => $value);
        }else{
            $tmp = json_decode($tmp, TRUE);
            $tmp[$languageID] = $value;
        }

        $this->setValueArray('child_shop_table_catalog_ids', $tmp);
    }
    public function getChildShopTableCatalogIDsArray($languageID = Model_Language::LANGUAGE_RUSSIAN){
        return Arr::path($this->getValueArray('child_shop_table_catalog_ids'), $languageID, array());
    }
    public function setChildShopTableCatalogID($name, $value, $languageID)
    {
        $arr = $this->getChildShopTableCatalogIDsArray($languageID);
        $arr[$name] = $value;

        $this->setChildShopTableCatalogIDsArray($arr, $languageID = Model_Language::LANGUAGE_RUSSIAN);
    }
    public function getChildShopTableCatalogID($name, $languageID = Model_Language::LANGUAGE_RUSSIAN)
    {
        $tmp = $this->getChildShopTableCatalogIDsArray($languageID);
        return Arr::path($tmp, $name.'.id', 0);
    }

    // SQL после вставки записи
    public function setInsetSQLChild($value){
        $this->setValue('inset_sql_child', $value);
    }

    public function getInsetSQLChild(){
        return $this->getValue('inset_sql_child');
    }

    // JSON настройки списка полей учавствующие в поиске
    public function setFieldsParams($value){
        $this->setValue('fields_params', $value);
    }
    public function getFieldsParams(){
        return $this->getValue('fields_params');
    }
    public function getFieldsParamsArray(){
        return $this->getValueArray('fields_params');
    }
    public function setFieldsParamsArray(array $value, $isFirstLevel = TRUE){
        $params = array();
        if($isFirstLevel) {
            foreach ($value as $field) {
                if ((is_array($field)) && (key_exists('name', $field)) && (key_exists('title', $field))) {
                    $name = $field['name'];
                    $title = $field['title'];
                    if ((!empty($name)) && (!empty($title))) {
                        $params[] = array(
                            'field' => $name,
                            'title' => $title,
                            'type' => Arr::path($field, 'type', ''),
                            'params' => Arr::path($field, 'params', ''),
                        );
                    }
                }
            }
        }else{
            foreach ($value as $firstName => $firstValue) {
                foreach ($firstValue as $field) {
                    if ((is_array($field)) && (key_exists('name', $field)) && (key_exists('title', $field))) {
                        $name = $field['name'];
                        $title = $field['title'];
                        if ((!empty($name)) && (!empty($title))) {

                            if(! key_exists($firstName, $params)){
                                $params[$firstName] = array();
                            }

                            $params[$firstName][] = array(
                                'field' => $name,
                                'title' => $title,
                                'type' => Arr::path($field, 'type', ''),
                                'params' => Arr::path($field, 'params', ''),
                            );
                        }
                    }
                }
            }
        }
        $this->setValueArray('fields_params', $params);
    }

}

