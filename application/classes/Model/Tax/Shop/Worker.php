<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Worker extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_workers';
	const TABLE_ID = 135;

	public function __construct(){
		parent::__construct(
			array(
                'iin',
                'date_of_birth',
                'number',
                'date_from',
                'date_work_from',
                'date_work_to',
                'wage_basic',
                'worker_status_id',

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
        $validation->rule('iin', 'max_length', array(':value', 12))
            ->rule('name_d', 'max_length', array(':value', 150))
            ->rule('number', 'max_length', array(':value', 50))
            ->rule('worker_status_id', 'max_length', array(':value', 11))
            ->rule('wage_basic', 'max_length', array(':value', 12))
            ->rule('issued_by', 'max_length', array(':value', 250))
            ->rule('position', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDateWorkFrom($value){
        $this->setValueDate('date_work_from', $value);
    }
    public function getDateWorkFrom(){
        return $this->getValueDateTime('date_work_from');
    }

    public function setDateWorkTo($value){
        $this->setValueDate('date_work_to', $value);
    }
    public function getDateWorkTo(){
        return $this->getValueDateTime('date_work_to');
    }

    public function setWorkerStatusID($value){
        $this->setValue('worker_status_id', $value);
    }
    public function getWorkerStatusID(){
        return $this->getValue('worker_status_id');
    }

    public function setWageBasic($value){
        $this->setValueFloat('wage_basic', $value);
    }
    public function getWageBasic(){
        return $this->getValueFloat('wage_basic');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setNameD($value){
        $this->setValue('name_d', $value);
    }
    public function getNameD(){
        return $this->getValue('name_d');
    }

    public function setIssuedBy($value){
        $this->setValue('issued_by', $value);
    }
    public function getIssuedBy(){
        return $this->getValue('issued_by');
    }

    public function setPosition($value){
        $this->setValue('position', $value);
    }
    public function getPosition(){
        return $this->getValue('position');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setIIN($value){
        $this->setValue('iin', $value);
    }
    public function getIIN(){
        return $this->getValue('iin');
    }

    public function setDateOfBirth($value){
        $this->setValueDate('date_of_birth', $value);
    }
    public function getDateOfBirth(){
        return $this->getValueDateTime('date_of_birth');
    }
}
