<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker_Miss extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_worker_misses';
    const TABLE_ID = 426;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_id',
                'from_at',
                'to_at',
                'miss_type_id',
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
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                        break;
                    case 'miss_type_id':
                        $this->_dbGetElement($this->getMissTypeID(), 'miss_type_id', new Model_Ab1_MissType(), $shopID);
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
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldInt('miss_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setFromAt($value){
        $this->setValueDateTime('from_at', $value);
    }
    public function getFromAt(){
        return $this->getValue('from_at');
    }

    public function setToAt($value){
        $this->setValueDateTime('to_at', $value);
    }
    public function getToAt(){
        return $this->getValue('to_at');
    }

    public function setMissTypeID($value){
        $this->setValueInt('miss_type_id', $value);
    }
    public function getMissTypeID(){
        return $this->getValueInt('miss_type_id');
    }
}
