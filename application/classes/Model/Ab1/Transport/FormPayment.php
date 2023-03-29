<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Transport_FormPayment extends Model_Shop_Table_Basic_Table{
    const TABLE_NAME = 'ab_transport_form_payments';
    const TABLE_ID = '';

    const FORM_PAYMENT_PIECE_RATE = 1; // Сдельная

    public function __construct(){
        parent::__construct(
            array(
			'number',
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

        $this->isValidationFieldStr('number', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }


}
