<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tax_Akimat extends Model_Basic_Name{
	
	const TABLE_NAME='tax_akimats';
	const TABLE_ID = 164;

	public function __construct(){
		parent::__construct(
			array(
                'bin',
                'code',
                'authority_id',
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
                    case 'authority_id':
                        $this->_dbGetElement($this->getAuthorityID(), 'authority_id', new Model_Tax_Authority());
                        break;
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

		$validation->rule('fields_options', 'max_length', array(':value', 650000))
            ->rule('options', 'max_length', array(':value', 650000))
            ->rule('bin', 'max_length', array(':value', 12))
            ->rule('code', 'max_length', array(':value', 4))
            ->rule('authority_id', 'max_length', array(':value', 11));

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

    public function setBin($value){
        $this->setValue('bin', $value);
    }
    public function getBin(){
        return $this->getValue('bin');
    }

    public function setCode($value){
        $this->setValueInt('code', $value);
    }
    public function getCode(){
        return $this->getValueInt('code');
    }

    public function setAuthorityID($value){
        $this->setValueInt('authority_id', $value);
    }
    public function getAuthorityID(){
        return $this->getValueInt('authority_id');
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
