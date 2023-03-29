<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Rubric_Source extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_rubric_sources';
    const TABLE_ID = 433;

    public function __construct(){
        parent::__construct(
            array(
                'order',
                'path',
                'is_last',
                'shop_source_id',
                'root_id',
                'commission',
                'commission_sale',
                'is_sale',
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
        $this->isValidationFieldBool('is_last', $validation);
        $this->isValidationFieldBool('is_sale', $validation);
        $this->isValidationFieldInt('order', $validation);
        $this->isValidationFieldInt('shop_source_id', $validation);
        $this->isValidationFieldInt('root_id', $validation);
        $this->isValidationFieldStr('path', $validation);
        $this->isValidationFieldInt('commission', $validation);
        $this->isValidationFieldInt('commission_sale', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    // Путь для каталога
    public function setPath($value){
        $this->setValue('path', $value);
    }
    public function getPath(){
        return $this->getValue('path');
    }

    public function setCommission($value){
        $this->setValueInt('commission', $value);
    }
    public function getCommission(){
        return $this->getValueInt('commission');
    }

    public function setCommissionSale($value){
        $this->setValueInt('commission_sale', $value);
    }
    public function getCommissionSale(){
        return $this->getValueInt('commission_sale');
    }

    public function setIsLast($value){
        $this->setValueBool('is_last', $value);
    }
    public function getIsLast(){
        return $this->getValueBool('is_last');
    }

    public function setIsSale($value){
        $this->setValueBool('is_sale', $value);
    }
    public function getIsSale(){
        return $this->getValueBool('is_sale');
    }

    public function setOrder($value){
        $this->setValueInt('order',$value);
    }
    public function getOrder(){
        return $this->getValueInt('order');
    }

    public function setShopSourceID($value){
        $this->setValueInt('shop_source_id',$value);
    }
    public function getShopSourceID(){
        return $this->getValueInt('shop_source_id');
    }

    public function setRootID($value){
        $this->setValueInt('root_id',$value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }
}
