<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Bank_Account extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'tax_shop_bank_accounts';
	const TABLE_ID = 210;

	public function __construct(){
		parent::__construct(
			array(
                'iik',
                'bank_id'
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null $elements
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'bank_id':
                        $this->_dbGetElement($this->getBankID(), 'bank_id', new Model_Bank());
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
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('iik', 'max_length', array(':value', 250))
            ->rule('bank_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }

	public function setIIK($value){
		$this->setValue('iik', $value);
	}
	public function getIIK(){
		return $this->getValue('iik');
	}
}
