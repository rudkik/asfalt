<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Person extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_persons';
	const TABLE_ID = 124;

	public function __construct(){
		parent::__construct(
			array(
                'date_from',
                'number',
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
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('name_d', 'max_length', array(':value', 250))
            ->rule('number', 'max_length', array(':value', 12))
            ->rule('issued_by', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValue('date_from');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setIssuedBy($value){
        $this->setValue('issued_by', $value);
    }
    public function getIssuedBy(){
        return $this->getValue('issued_by');
    }

    public function setNameD($value){
        $this->setValue('name_d', $value);
    }
    public function getNameD(){
        return $this->getValue('name_d');
    }
}
