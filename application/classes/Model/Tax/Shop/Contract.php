<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Contract extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_contracts';
	const TABLE_ID = 100;

	public function __construct(){
		parent::__construct(
			array(
                'shop_contractor_id',
                'date',
                'date_from',
                'date_to',
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
        $validation->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('view', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
        $this->setDate($value);
    }
    public function getDateFrom(){
        return $this->getValue('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValue('date_to');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setView($value){
        $this->setValue('view', $value);
    }
    public function getView(){
        return $this->getValue('view');
    }
}
