<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Rubric extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_rubrics';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(
                'order',
                'path',
                'product_quantity',
                'name_url',
                'is_translates',
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
        $this->isValidationFieldStr('name_url', $validation);
        $this->isValidationFieldBool('is_translates', $validation);
        $this->isValidationFieldInt('order', $validation);
        $this->isValidationFieldInt('product_quantity', $validation);
        $this->isValidationFieldStr('path', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    // Путь для каталога
    public function setPath($value){
        $this->setValue('path', $value);
    }
    public function getPath(){
        return $this->getValue('path');
    }

    public function setProductQuantity($value){
        $this->setValueInt('product_quantity',$value);
    }
    public function getProductQuantity(){
        return $this->getValueInt('product_quantity');
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

    public function setOrder($value){
        $this->setValueInt('order',$value);
    }
    public function getOrder(){
        return $this->getValueInt('order');
    }

    public function setRootID($value){
        $this->setValueInt('root_id',$value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }
}
