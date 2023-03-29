<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker_Department extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_worker_departments';
    const TABLE_ID = 401;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_department_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_worker_department_id':
                        $this->_dbGetElement($this->getShopWorkerDepartmentID(), 'shop_worker_department_id', new Model_Ab1_Shop_Worker_Department());
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
        $this->isValidationFieldInt('shop_worker_department_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerDepartmentID($value){
        $this->setValueInt('shop_worker_department_id', $value);
    }
    public function getShopWorkerDepartmentID(){
        return $this->getValueInt('shop_worker_department_id');
    }
}
