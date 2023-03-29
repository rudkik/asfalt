<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Equipment_Condition extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_equipment_conditions';
	const TABLE_ID = 381;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_department_id',
                'shop_equipment_state_id',
                'shop_equipment_id',
                'date',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }
    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_worker_department_id':
                        $this->_dbGetElement($this->getShopWorkerDepartmentID(), 'shop_worker_department_id', new Model_Ab1_Shop_Worker_Department(), $shopID);
                        break;
                    case 'shop_equipment_state_id':
                        $this->_dbGetElement($this->getShopEquipmentStateID(), 'shop_equipment_state_id', new Model_Ab1_Shop_Equipment_State(), $shopID);
                        break;
                    case 'shop_equipment_id':
                        $this->_dbGetElement($this->getShopEquipmentID(), 'shop_equipment_id', new Model_Ab1_Shop_Equipment(), $shopID);
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
        $this->isValidationFieldInt('shop_worker_department_id', $validation);
        $this->isValidationFieldInt('shop_equipment_state_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerDepartmentID($value){
        $this->setValueInt('shop_worker_department_id', $value);
    }
    public function getShopWorkerDepartmentID(){
        return $this->getValueInt('shop_worker_department_id');
    }
    public function setShopEquipmentStateID($value){
        $this->setValueInt('shop_equipment_state_id', $value);
    }
    public function getShopEquipmentStateID(){
        return $this->getValueInt('shop_equipment_state_id');
    }
    public function setShopEquipmentID($value){
        $this->setValueInt('shop_equipment_id', $value);
    }
    public function getShopEquipmentID(){
        return $this->getValueInt('shop_equipment_id');
    }
    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

}
