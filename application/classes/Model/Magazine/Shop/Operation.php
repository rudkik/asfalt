<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Operation extends Model_Shop_Operation
{
    const RUBRIC_BAR = 1;
    const RUBRIC_BOOKKEEPING = 2;
    const RUBRIC_SOCIAL = 103;


    public function __construct(){
        parent::__construct(
            array(
                'shop_cashbox_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'shop_cashbox_id':
                        $this->_dbGetElement($this->getShopCashboxID(), 'shop_cashbox_id', new Model_Ab1_Shop_Cashbox(), $shopID);
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

        if ($this->id < 1) {
            $validation->rule('password', 'not_empty');
            $validation->rule('email', 'not_empty');
        }

        $validation->rule('name', 'max_length', array(':value', 250))
            ->rule('user_id', 'max_length', array(':value', 11))
            ->rule('is_admin', 'max_length', array(':value', 1))
            ->rule('email', 'max_length', array(':value', 150))
            ->rule('password', 'max_length', array(':value', 150))
            ->rule('access', 'max_length', array(':value', 650000))
            ->rule('password', 'not_null')
            ->rule('email', 'not_null')
            ->rule('user_hash', 'max_length', array(':value', 32));

        if ($this->isFindFieldAndIsEdit('user_id')) {
            $validation->rule('user_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('is_admin')) {
            $validation->rule('is_admin', 'digit');
        }

        $this->isValidationFieldInt('shop_cashbox_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCashboxID($value){
        $this->setValueInt('shop_cashbox_id', $value);
    }
    public function getShopCashboxID(){
        return $this->getValueInt('shop_cashbox_id');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }
}