<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bill_Status extends Model_Shop_Table_Basic_Table{
    const STATUS_DELIVERY = 3; // Завершён
    const STATUS_CANCEL = 4; // Отменён
    const STATUS_RETURN = 8; // Возвращён

    const TABLE_NAME = 'ap_shop_bill_statuses';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
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


        return $this->_validationFields($validation, $errorFields);
    }


}
