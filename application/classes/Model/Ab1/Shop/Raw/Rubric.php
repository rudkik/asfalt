<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Raw_Rubric extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_raw_rubrics';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'root_id',
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
                   case 'root_id':
                            $this->_dbGetElement($this->getRootID(), 'root_id', new Model_Ab1_Shop_Raw_Rubric(), $shopID);
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

        $this->isValidationFieldInt('root_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setRootID($value){
        $this->setValueInt('root_id', $value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }


}
