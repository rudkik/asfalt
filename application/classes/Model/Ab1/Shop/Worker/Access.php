<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Worker_Access extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_worker_access';
    const TABLE_ID = 432;

    public function __construct(){
        parent::__construct(
            array(
                'access',
                'shop_worker_id',
                'shop_card_id',
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
                    case 'shop_card_id':
                        $this->_dbGetElement($this->getShopCardID(), 'shop_card_id', new Model_Magazine_Shop_Card(), $shopID);
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
        $this->isValidationFieldInt('shop_card_id', $validation);
        $this->isValidationFieldBool('access', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * изменяет значение по именя
     * @param $name
     * @param $value
     */

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

    public function setAccess($value){
        $this->setValueBool('access', $value);
    }
    public function getAccess(){
        return $this->getValueBool('access');
    }

}
