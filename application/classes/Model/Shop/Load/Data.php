<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Load_Data extends Model_Shop_Table_Basic_Object {

	const TABLE_NAME = 'ct_shop_load_datas';
	const TABLE_ID = 54;

	public function __construct(){
		parent::__construct(
			array(
                'first_row',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

	/**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('first_row', 'max_length', array(':value', 11))
			->rule('data', 'max_length', array(':value', 6500000));

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

	public function setFirstRow($value)
	{
		$this->setValueInt('first_row', $value);
	}
	public function getFirstRow()
	{
		return $this->getValueInt('first_row');
	}
}

