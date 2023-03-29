<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Position extends Model_Shop_Table_Basic_Table{
    const POSITION_COURIER = 1; // курьер
    const POSITION_INDETIFY = 2; // менеджер по распознованию
    const POSITION_BILL = 3; // обработка заказов
    const POSITION_BOOKKEEPING = 4; // бухгалтер
    const POSITION_INVESTOR = 5; // инвестор

    const TABLE_NAME = 'ap_shop_positions';
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
