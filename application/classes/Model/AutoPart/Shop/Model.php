<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Model extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_models';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(
                'is_translates',
                'name_url',
                'shop_mark_id',
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
                    case 'shop_mark_id':
                        $this->_dbGetElement($this->id, 'shop_mark_id', new Model_Shop_Mark());
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
        $this->isValidationFieldStr('name_url', $validation);
        $this->isValidationFieldBool('is_translates', $validation);
        $this->isValidationFieldInt('shop_mark_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setNameURL($value){
        $this->setValue('name_url', $value);
    }
    public function getNameURL(){
        return $this->getValue('name_url');
    }
    public function setIsTranslates($value){
        $this->setValue('is_translates', $value);
    }
    public function getIsTranslates(){
        return $this->getValue('is_translates');
    }
    public function setShopMarkID($value){
        $this->setValueInt('shop_mark_id',$value);
    }
    public function getShopMarkID(){
        return $this->getValueInt('shop_mark_id');
    }
}
