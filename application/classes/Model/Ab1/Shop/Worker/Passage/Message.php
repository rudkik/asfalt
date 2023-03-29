<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker_Passage_Message extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_worker_passage_messages';
    const TABLE_ID = 427;

    public function __construct(){
        parent::__construct(
            array(
                'shop_worker_passage_id',
                'message_number',
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
        $this->isValidationFieldStr('message_number', $validation, 20);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopWorkerPassageID($value){
        $this->setValueInt('shop_worker_passage_id', $value);
    }
    public function getShopWorkerPassageID(){
        return $this->getValueInt('shop_worker_passage_id');
    }

    public function setMessageNumber($value){
        $this->setValue('message_number', $value);
    }
    public function getMessageNumber(){
        return $this->getValue('message_number');
    }

}
