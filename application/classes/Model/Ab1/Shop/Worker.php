<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_workers';
	const TABLE_ID = 257;

	public function __construct(){
		parent::__construct(
			array(
                'shop_department_id',
                'shop_subdivision_id',
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
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_department_id':
                        $this->_dbGetElement($this->getShopDepartmentID(), 'shop_department_id', new Model_Ab1_Shop_Department());
                        break;
                    case 'shop_subdivision_id':
                        $this->_dbGetElement($this->getShopSubdivisioID(), 'shop_subdivision_id', new Model_Shop());
                        break;
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('shop_department_id', $validation);
        $this->isValidationFieldInt('shop_subdivision_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopDepartmentID($value){
        $this->setValueInt('shop_department_id', $value);
    }
    public function getShopDepartmentID(){
        return $this->getValueInt('shop_department_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }
}
