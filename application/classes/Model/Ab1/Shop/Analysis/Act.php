<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Analysis_Act extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_analysis_acts';
    const TABLE_ID = 377;

    public function __construct(){
        parent::__construct(
            array(
                'shop_analysis_id',
                'date',
                'shop_raw_id',
                'shop_material_id',
                'shop_product_id',
                'number',
                'shop_worker_id',
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
                    case 'shop_analysis_id':
                        $this->_dbGetElement($this->getShopAnalysisID(), 'shop_analysis_id', new Model_Ab1_Shop_Analysis(), $shopID);
                        break;
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
                        break;
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product(), $shopID);
                        break;
                    case 'shop_worker_id':
                        $this->_dbGetElement($this->getShopWorkerID(), 'shop_worker_id', new Model_Ab1_Shop_Worker(), $shopID);
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
        $this->isValidationFieldInt('shop_analysis_id', $validation);
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);
        $this->isValidationFieldStr('number', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopAnalysisID($value){
        $this->setValueInt('shop_analysis_id', $value);
    }
    public function getShopAnalysisID(){
        return $this->getValueInt('shop_analysis_id');
    }
    public function setShopRawID($value){
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
    }
    public function setShopMaterialID($value){
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }
    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }
    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }
    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }
    public function setUnit($value){
        $this->setValue('number', $value);
    }
    public function getUnit(){
        return $this->getValue('number');
    }

}
