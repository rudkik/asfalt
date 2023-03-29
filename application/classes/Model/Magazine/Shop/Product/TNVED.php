<?php defined('SYSPATH') or die('No direct script access.');

class Model_Magazine_Shop_Product_TNVED extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'sp_shop_product_tnveds';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'tnved',
			'kpved',
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

        $this->isValidationFieldStr('tnved', $validation);
        $this->isValidationFieldStr('kpved', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setTnved($value){
        $this->setValue('tnved', $value);
    }
    public function getTnved(){
        return $this->getValue('tnved');
    }

    public function setKpved($value){
        $this->setValue('kpved', $value);
    }
    public function getKpved(){
        return $this->getValue('kpved');
    }


}
