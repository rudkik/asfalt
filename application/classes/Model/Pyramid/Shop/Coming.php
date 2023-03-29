<?php defined('SYSPATH') or die('No direct script access.');


class Model_Pyramid_Shop_Coming extends Model_Shop_Basic_Options{

	const TABLE_NAME = 'np_shop_comings';
	const TABLE_ID = 236;

	public function __construct(){
		parent::__construct(
			array(
                'from_shop_client_id',
                'to_shop_client_id',
                'amount',
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
        $this->isValidationFieldInt('from_shop_client_id', $validation);
        $this->isValidationFieldInt('to_shop_client_id', $validation);
        $this->isValidationFieldFloat('amount', $validation, 20);

        return $this->_validationFields($validation, $errorFields);
    }

	public function setAmount($value){
		$this->setValueFloat('amount', $value);
	}
	public function getAmount(){
		return $this->getValueFloat('amount');
	}

    public function setFromShopClientID($value){
        $this->setValueInt('from_shop_client_id', $value);
    }
    public function getFromShopClientID(){
        return $this->getValueInt('from_shop_client_id');
    }

    public function setToShopClientID($value){
        $this->setValueInt('to_shop_client_id', $value);
    }
    public function getToShopClientID(){
        return $this->getValueInt('to_shop_client_id');
    }
}
