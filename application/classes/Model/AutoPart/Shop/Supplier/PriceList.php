<?php defined('SYSPATH') or die('No direct script access.');


class Model_AutoPart_Shop_Supplier_PriceList extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ap_shop_supplier_price_lists';
    const TABLE_ID = 348;

    public function __construct(){
        parent::__construct(
            array(
                'order',
                'integrations',
                'shop_supplier_id',
                'first_row',
                'is_load_data',
                'old_count',
                'new_count',
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
                    case 'shop_storage_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_Ab1_Shop_Supplier());
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
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldInt('order', $validation);
        $this->isValidationFieldInt('first_row', $validation);
        $this->isValidationFieldFloat('is_load_data', $validation);
        $this->isValidationFieldInt('old_count', $validation);
        $this->isValidationFieldInt('new_count', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setIntegrations($value){
        $this->setValue('integrations', $value);
    }
    public function getIntegrations(){
        return $this->getValue('integrations');
    }
    public function setIntegrationsArray(array $value){
        $this->setValueArray('integrations', $value);
    }
    public function getIntegrationsArray(){
        return $this->getValueArray('integrations');
    }

    public function setOrder($value){
        $this->setValueInt('order',$value);
    }
    public function getOrder(){
        return $this->getValueInt('order');
    }

    public function setFirstRow($value){
        $this->setValueInt('first_row',$value);
    }
    public function getFirstRow(){
        return $this->getValueInt('first_row');
    }

    public function setOldCount($value){
        $this->setValueInt('old_count',$value);
    }
    public function getOldCount(){
        return $this->getValueInt('old_count');
    }

    public function setNewCount($value){
        $this->setValueInt('new_count',$value);
    }
    public function getNewCount(){
        return $this->getValueInt('new_count');
    }

    public function setIsLoadData($value){
        $this->setValueFloat('is_load_data',$value);
    }
    public function getIsLoadData(){
        return $this->getValueFloat('is_load_data');
    }
}
