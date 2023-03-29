<?php defined('SYSPATH') or die('No direct script access.');

class Model_Shop_Gallery extends Model_Shop_Basic_Collations
{

    const TABLE_NAME = 'ct_shop_galleries';
    const TABLE_ID = 15;

    public function __construct(){
        parent::__construct(
            array(
                'is_group',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'shop_table_preview_id':
                        $this->_dbGetElement($this->id, 'shop_table_preview', new Model_Shop_Table_Preview());
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $validation->rule('is_group', 'max_length', array(':value', 1));

        if ($this->isFindFieldAndIsEdit('is_group')) {
            $validation->rule('is_group', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
    }

    // Группа ли
    public function setIsGroup($value){
        $this->setValueBool('is_group', $value);
    }

    public function getIsGroup(){
        return $this->getValueBool('is_group');
    }
}
