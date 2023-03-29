<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker_EntryExit_Log extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_worker_entry_exit_logs';
    const TABLE_ID = 428;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_passage_id',
                'shop_worker_id',
                'date_entry',
                'shop_card_id',
                'date_exit',
                'early_exit',
                'guest_id',
                'shop_worker_entry_exit_id',
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
                    case 'shop_worker_passage_id':
                        $this->_dbGetElement($this->getShopWorkerPassageID(), 'shop_worker_passage_id', new Model_Ab1_Shop_Worker_Passage(), $shopID);
                        break;
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
                        break;
                    case 'shop_card_id':
                        $this->_dbGetElement($this->getShopCardID(), 'shop_card_id', new Model_Magazine_Shop_Card(), $shopID);
                        break;
                    case 'guest_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'guest_id', new Model_Ab1_Guest(), $shopID);
                        break;
                    case 'shop_worker_entry_exit_id':
                        $this->_dbGetElement($this->getShopWorkerEntryExitID(), 'shop_worker_entry_exit_id', new Model_Ab1_Shop_Worker_EntryExit(), $shopID);
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
        $this->isValidationFieldInt('shop_worker_passage_id', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldInt('shop_card_id', $validation);
        $this->isValidationFieldInt('guest_id', $validation);
        $this->isValidationFieldInt('shop_worker_entry_exit_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerPassageID($value){
        $this->setValueInt('shop_worker_passage_id', $value);
    }
    public function getShopWorkerPassageID(){
        return $this->getValueInt('shop_worker_passage_id');
    }

    public function setShopWorkerPassageMessageID($value){
        $this->setValueInt('shop_worker_passage_message_id', $value);
    }
    public function getShopWorkerPassageMessageID(){
        return $this->getValueInt('shop_worker_passage_message_id');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setShopCardID($value){
        $this->setValueInt('shop_card_id', $value);
    }
    public function getShopCardID(){
        return $this->getValueInt('shop_card_id');
    }

    public function setDateEntry($value){
        $this->setValueDateTime('date_entry', $value);
    }
    public function getDateEntry(){
        return $this->getValueDateTime('date_entry');
    }

    public function setDateExit($value){
        $this->setValueDateTime('date_exit', $value);
    }
    public function getDateExit(){
        return $this->getValueDateTime('date_exit');
    }

    public function setEarlyExit($value){
        $this->setValueInt('early_exit', $value);
    }
    public function getEarlyExit(){
        return $this->getValueInt('early_exit');
    }

    public function setGuestID($value){
        $this->setValueInt('guest_id', $value);
    }
    public function getGuestID(){
        return $this->getValueInt('guest_id');
    }

    public function setShopWorkerEntryExitID($value){
        $this->setValueInt('shop_worker_entry_exit_id', $value);
    }
    public function getShopWorkerEntryExitID(){
        return $this->getValueInt('shop_worker_entry_exit_id');
    }

}
