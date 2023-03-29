<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Driver extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_drivers';
    const TABLE_ID = 395;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_id',
                'shop_branch_from_id',
                'shop_transport_class_id',
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
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                        break;
                    case 'shop_transport_class_id':
                        $this->_dbGetElement($this->getShopTransportClassID(), 'shop_transport_class_id', new Model_Ab1_Shop_Transport_Class(), $shopID);
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
        $this->isValidationFieldInt('shop_worker_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setShopBranchFromID($value){
        $this->setValueInt('shop_branch_from_id', $value);
    }
    public function getShopBranchFromID(){
        return $this->getValueInt('shop_branch_from_id');
    }

    public function setShopTransportClassID($value){
        $this->setValueInt('shop_transport_class_id', $value);
    }
    public function getShopTransportClassID(){
        return $this->getValueInt('shop_transport_class_id');
    }
}
