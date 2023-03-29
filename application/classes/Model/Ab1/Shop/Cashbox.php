<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Cashbox extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_cashboxes';
	const TABLE_ID = 306;

	public function __construct(){
		parent::__construct(
			array(
                'port',
                'ip',
                'symbol',
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
        $this->isValidationFieldInt('port', $validation);
        $this->isValidationFieldStr('ip', $validation, 20);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIP($value){
        $this->setValue('ip', $value);
    }
    public function getIP(){
        return $this->getValue('ip');
    }

    public function setSymbol($value){
        $this->setValue('symbol', $value);
    }
    public function getSymbol(){
        return $this->getValue('symbol');
    }

	public function setPort($value){
		$this->setValueInt('port', $value);
	}
	public function getPort(){
		return $this->getValueInt('port');
	}
}
