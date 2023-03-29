<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Operation extends Model_Shop_Operation
{
	const RUBRIC_CASH = 1;
	const RUBRIC_WEIGHT = 2;
	const RUBRIC_ASU = 3;
    const RUBRIC_SBIT = 4;
	const RUBRIC_SBYT = 4;
    const RUBRIC_DIRECTOR = 5;
    const RUBRIC_BALLAST = 6;
    const RUBRIC_RECEPE = 7;
    const RUBRIC_TRAIN = 8;
    const RUBRIC_BID = 9;
    const RUBRIC_ABC = 10;
    const RUBRIC_OWNER = 11;
    const RUBRIC_OGM = 12;
    const RUBRIC_PTO = 13;
    const RUBRIC_BOOKKEEPING = 14;
    const RUBRIC_ATC = 15;
    const RUBRIC_CASHBOX = 16;
    const RUBRIC_GENERAL = 17;
    const RUBRIC_JURIST = 18;
    const RUBRIC_PEO = 19;
    const RUBRIC_CRUSHER = 20;
    const RUBRIC_MAKE = 21;
    const RUBRIC_LAB = 22;
    const RUBRIC_ECOLOGIST = 23;
    const RUBRIC_SGE = 24;
    const RUBRIC_SALES = 25;
    const RUBRIC_NBC = 26;
    const RUBRIC_NBU = 27;
    const RUBRIC_TECHNOLOGIST = 28;
    const RUBRIC_KPP = 29;
    const RUBRIC_ZHBIBC = 30;
    const RUBRIC_CONTROL = 31;

    // типы картинок для загрузки
    const IMAGE_TYPE_AUTOGRAPH = 1; // автограф
    const IMAGE_TYPE_FACE = 2; // лицо сотрудника

    public function __construct(){
        parent::__construct(
            array(
                'shop_cashbox_id',
                'shop_department_id',
                'shop_worker_id',
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
                    case 'shop_cashbox_id':
                        $this->_dbGetElement($this->getShopCashboxID(), 'shop_cashbox_id', new Model_Ab1_Shop_Cashbox(), $shopID);
                        break;
                    case 'shop_department_id':
                        $this->_dbGetElement($this->getShopDepartmentID(), 'shop_department_id', new Model_Ab1_Shop_Department());
                        break;
                    case 'shop_raw_rubric_id':
                        $this->_dbGetElement($this->getShopRawRubricID(), 'shop_raw_rubric_id', new Model_Ab1_Shop_Raw_Rubric());
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

        if ($this->id < 1) {
            $validation->rule('password', 'not_empty');
            $validation->rule('email', 'not_empty');
        }

        $validation->rule('name', 'max_length', array(':value', 250))
            ->rule('user_id', 'max_length', array(':value', 11))
            ->rule('is_admin', 'max_length', array(':value', 1))
            ->rule('email', 'max_length', array(':value', 150))
            ->rule('password', 'max_length', array(':value', 150))
            ->rule('access', 'max_length', array(':value', 650000))
            ->rule('password', 'not_null')
            ->rule('email', 'not_null')
            ->rule('user_hash', 'max_length', array(':value', 32));

        if ($this->isFindFieldAndIsEdit('user_id')) {
            $validation->rule('user_id', 'digit');
        }

        if ($this->isFindFieldAndIsEdit('is_admin')) {
            $validation->rule('is_admin', 'digit');
        }

        $this->isValidationFieldInt('shop_cashbox_id', $validation);
        $this->isValidationFieldInt('shop_department_id', $validation);
        $this->isValidationFieldInt('shop_worker_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCashboxID($value){
        $this->setValueInt('shop_cashbox_id', $value);
    }
    public function getShopCashboxID(){
        return $this->getValueInt('shop_cashbox_id');
    }

    public function setShopDepartmentID($value){
        $this->setValueInt('shop_department_id', $value);
    }
    public function getShopDepartmentID(){
        return $this->getValueInt('shop_department_id');
    }

    public function setShopWorkerID($value){
        $this->setValueInt('shop_worker_id', $value);
    }
    public function getShopWorkerID(){
        return $this->getValueInt('shop_worker_id');
    }

    public function setShopWorkerPassageID($value){
        $this->setValueInt('shop_worker_passage_id', $value);
    }
    public function getShopWorkerPassageID(){
        return $this->getValueInt('shop_worker_passage_id');
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    // Подразделения для работы с АБЦ, Малого СБЫТА, ЖБИ и БС
    public function setProductShopSubdivisionIDs($value){
        $this->setValue('product_shop_subdivision_ids', $value);
    }
    public function getProductShopSubdivisionIDs(){
        return $this->getValue('product_shop_subdivision_ids');
    }
    public function setProductShopSubdivisionIDsArray(array $value){
        $this->setValueArray('product_shop_subdivision_ids', $value, false, true);
    }
    public function getProductShopSubdivisionIDsArray(){
        return $this->getValueArray('product_shop_subdivision_ids', null, array(), false, true);
    }

    // Список доступных рубрик сырья
    public function setShopRawRubricID($value){
        $this->setValueInt('shop_raw_rubric_id', $value);
    }
    public function getShopRawRubricID(){
        return $this->getValueInt('shop_raw_rubric_id');
    }
    public function setShopRawRubricIDsArray(array $value){
        $this->setValueArray('shop_raw_rubric_ids', $value, false, true);
    }
    public function getShopRawRubricIDsArray(){
        return $this->getValueArray('shop_raw_rubric_ids', null, array(), false, true);
    }

    // Список доступных складов
    public function setProductShopStorageIDs($value){
        $this->setValue('product_shop_storage_ids', $value);
    }
    public function getProductShopStorageIDs(){
        return $this->getValue('product_shop_storage_ids');
    }
    public function setProductShopStorageIDsArray(array $value){
        $this->setValueArray('product_shop_storage_ids', $value, false, true);
    }
    public function getProductShopStorageIDsArray(){
        return $this->getValueArray('product_shop_storage_ids', null, array(), false, true);
    }

    public function setShopRawStorageTypeID($value){
        $this->setValueInt('shop_raw_storage_type_id', $value);
    }
    public function getShopRawStorageTypeID(){
        return $this->getValueInt('shop_raw_storage_type_id');
    }

}
