<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Storage extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_storages';
	const TABLE_ID = 117;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_turn_type_id',
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

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTurnTypeID($value){
        $this->setValueInt('shop_turn_type_id', $value);
    }
    public function getShopTurnTypeID(){
        return $this->getValueInt('shop_turn_type_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }
}
