<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Department extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_departments';
	const TABLE_ID = 120;

	public function __construct(){
		parent::__construct(
            array(
                'interface_id',
                'shop_department_id',
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

    public function setShopDepartmentID($value){
        $this->setValueInt('shop_department_id', $value);
    }
    public function getShopDepartmentID(){
        return $this->getValueInt('shop_department_id');
    }

    public function setInterfaceIDs($value){
        $this->setValue('contract_interface_ids', $value);
    }
    public function getInterfaceIDs(){
        return $this->getValue('contract_interface_ids');
    }

    public function setInterfaceIDsArray(array $value){
        $array = array();
        foreach ($value as $child){
            if($child > 0){
                $array[] = $child;
            }
        }

        $this->setValueArray('contract_interface_ids', $value, false, true);
    }
    public function getInterfaceIDsArray(){
        return $this->getValueArray('contract_interface_ids', null, array(), false, true);
    }
}
