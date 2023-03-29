<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker_Passage extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_worker_passages';
    const TABLE_ID = 403;

    public function __construct(){
        parent::__construct(
            array(
                'is_car',
                'is_inside_move',
                'is_exit',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldBool('is_car', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsCar($value){
        $this->setValueBool('is_car', $value);
    }
    public function getIsCar(){
        return $this->getValueBool('is_car');
    }

    public function setIsExit($value){
        $this->setValueBool('is_exit', $value);
    }
    public function getIsExit(){
        return $this->getValueBool('is_exit');
    }

    public function setIsInsideMove($value){
        $this->setValueBool('is_inside_move', $value);
    }
    public function getIsInsideMove(){
        return $this->getValueBool('is_inside_move');
    }

    public function setControllerNumber($value){
        $this->setValue('controller_number', $value);
    }
    public function getControllerNumber(){
        return $this->getValue('controller_number');
    }

    public function setIP($value){
        $this->setValue('ip', $value);
    }
    public function getIP(){
        return $this->getValue('ip');
    }

    public function setLastOperation($value){
        $this->setValue('last_operation', $value);
    }
    public function getLastOperation(){
        return $this->getValue('last_operation');
    }

    public function setDateConnect($value){
        $this->setValueDateTime('date_connect', $value);
    }
    public function getDateConnect(){
        return $this->getValueDateTime('date_connect');
    }
}
