<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_MissType extends Model_Basic_Options{

    const TABLE_NAME = 'ab_miss_types';
    const TABLE_ID = 423;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_id',
                'miss_from',
                'miss_to'
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

        $this->isValidationFieldInt('shop_worker_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }
    public function setMissFrom($value){
        $this->setValue('miss_from', $value);
    }
    public function getMissFrom(){
        return $this->getValue('miss_from');
    }
    public function setMissTo($value){
        $this->setValue('miss_to', $value);
    }
    public function getMissTo(){
        return $this->getValue('miss_to');
    }

}
