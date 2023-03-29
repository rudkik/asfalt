<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_LoadFile extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'ct_shop_load_files';
	const TABLE_ID = 54;

	public function __construct(){
		parent::__construct(
			array(
				'table_id',
                'first_row',
				'type',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'table_id':
                        $this->_dbGetElement($this->getTableID(), 'table_id', new Model_Table());
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('table_id', 'max_length', array(':value', 11))
			->rule('type', 'max_length', array(':value', 11))
			->rule('first_row', 'max_length', array(':value', 11))
			->rule('data', 'max_length', array(':value', 650000));

        if ($this->isFindFieldAndIsEdit('table_id')) {
            $validation->rule('table_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('type')) {
            $validation->rule('type', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('first_row')) {
            $validation->rule('first_row', 'digit');
        }

		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Возвращаем cписок всех переменных
	 */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['data'] = $this->getDataArray();
		}

		return $arr;
	}

	// JSON настройки списка полей
	public function setData($value){
		$this->setValue('data', $value);
	}
	public function getData(){
		return $this->getValue('data');
	}
	public function setDataArray(array $value){
		$this->setValueArray('data', $value);
	}
	public function getDataArray(){
		return $this->getValueArray('data');
	}
	public function addDataArray(array &$value){
		$this->setDataArray(array_merge($this->getDataArray(), $value));
	}

	public function setTableID($value)
	{
		$this->setValueInt('table_id', $value);
	}
	public function getTableID()
	{
		return $this->getValueInt('table_id');
	}

	public function setType($value)
	{
		$this->setValueInt('type', $value);
	}
	public function getType()
	{
		return $this->getValueInt('type');
	}

	public function setFirstRow($value)
	{
		$this->setValueInt('first_row', $value);
	}

	public function getFirstRow()
	{
		return $this->getValueInt('first_row');
	}
}

