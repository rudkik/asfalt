<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Investor extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_investors';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'percent',
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

        $validation->rule('percent', 'max_length', array(':value',13));


        return $this->_validationFields($validation, $errorFields);
    }

    public function setPercent($value){
        $this->setValueFloat('percent', $value);
    }
    public function getPercent(){
        return $this->getValueFloat('percent');
    }


}
