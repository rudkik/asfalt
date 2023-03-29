<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Service extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'hc_shop_services';
	const TABLE_ID = 157;

	public function __construct(){
		parent::__construct(
			array(
                'price',
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
        $validation->rule('price', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }
}
