<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tax_KBK extends Model_Basic_Name{
	
	const TABLE_NAME='tax_kbks';
	const TABLE_ID = 131;

	public function __construct(){
		parent::__construct(
			array(
                'code',
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

		$validation->rule('fields_options', 'max_length', array(':value', 650000))
            ->rule('options', 'max_length', array(':value', 650000))
            ->rule('code', 'max_length', array(':value', 6));

		return $this->_validationFields($validation, $errorFields);
	}

	/**
	 * Возвращаем cписок всех переменных
	 */
	public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
	{
		$arr = parent::getValues($isGetElement, $isParseArray, $shopID);

		if($isParseArray === TRUE) {
			$arr['fields_options'] = $this->getFieldsOptionsArray();
			$arr['options'] = $this->getFieldsOptionsArray();
		}

		return $arr;
	}

    public function setCode($value){
        $this->setValueInt('code', $value);
    }
    public function getCode(){
        return $this->getValueInt('code');
    }

    // JSON настройки списка полей
    public function setFieldsOptions($value){
        $this->setValue('fields_options', $value);
    }

    public function getFieldsOptions(){
        return $this->getValue('fields_options');
    }

    // JSON настройки списка полей
    public function setFieldsOptionsArray(array $value){
        $this->setValueArray('fields_options', $value);
    }

    public function getFieldsOptionsArray(){
        return $this->getValueArray('fields_options');
    }

    // JSON настройки списка полей
    public function setOptions($value){
        $this->setValue('options', $value);
    }

    public function getOptions(){
        return $this->getValue('options');
    }

    // JSON настройки списка полей
    public function setOptionsArray(array $value){
        $this->setValueArray('options', $value);
    }

    public function getOptionsArray(){
        return $this->getValueArray('options');
    }
}
