<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Contractor extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_contractors';
	const TABLE_ID = 97;

	public function __construct(){
		parent::__construct(
			array(
                'bik',
                'bin',
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
        $validation->rule('bin', 'max_length', array(':value', 12))
            ->rule('bik', 'max_length', array(':value', 8))
			->rule('address', 'max_length', array(':value', 250))
			->rule('iik', 'max_length', array(':value', 250))
            ->rule('is_state', 'max_length', array(':value', 1))
            ->rule('bank_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }

    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }

    public function setBIK($value){
        $this->setValue('bik', $value);
    }
    public function getBIK(){
        return $this->getValue('bik');
    }

    public function setAddress($value){
		$this->setValue('address', $value);
	}
	public function getAddress(){
		return $this->getValue('address');
	}

	public function setIIK($value){
		$this->setValue('iik', $value);
	}
	public function getIIK(){
		return $this->getValue('iik');
	}

	public function setIsState($value){
		$this->setValueBool('is_state', $value);
	}
	public function getIsState(){
		return $this->getValueBool('is_state');
	}
}
