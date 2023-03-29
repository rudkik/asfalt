<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Bill_Item_Status extends Model_Shop_Table_Basic_Table{
    const STATUS_NEW = 1; // Необходимо купить
    const STATUS_OUT_OF_STOCK = 2; // Нет в наличии
    const STATUS_BUY = 3; // Куплен
    const STATUS_DELIVERY = 5; // Доставлен
    const STATUS_CANCEL = 7; // Отменён
    const STATUS_RETURN = 8; // Возвращён
    const STATUS_TO_BOOK = 9; // Бронь у поставщика
    const STATUS_TO_REQUEST_SUPPLIER = 10; // Отправлен запрос поставщику

    const TABLE_NAME = 'ap_shop_bill_item_statuses';
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
