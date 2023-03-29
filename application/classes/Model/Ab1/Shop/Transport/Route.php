<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Route extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_routes';
    const TABLE_ID = 398;

    public function __construct(){
        parent::__construct(
            array(
                'shop_branch_from_id',
                'shop_branch_to_id',
                'distance',
                'shop_daughter_from_id',
                'shop_daughter_to_id',
                'amount',
                'formula',
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
                    case 'shop_branch_from_id':
                        $this->_dbGetElement($this->getShopBranchFromID(), 'shop_branch_from_id', new Model_Ab1_Shop(), 0);
                        break;
                    case 'shop_branch_to_id':
                        $this->_dbGetElement($this->getShopBranchToID(), 'shop_branch_to_id', new Model_Ab1_Shop(), 0);
                        break;
                    case 'shop_daughter_from_id':
                        $this->_dbGetElement($this->getShopDaughterFromID(), 'shop_daughter_from_id', new Model_Ab1_Shop_Daughter(), $shopID);
                        break;
                    case 'shop_daughter_to_id':
                        $this->_dbGetElement($this->getShopDaughterToID(), 'shop_daughter_to_id', new Model_Ab1_Shop_Daughter(), $shopID);
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
        $this->isValidationFieldFloat('distance', $validation);
        $this->isValidationFieldInt('shop_branch_from_id', $validation);
        $this->isValidationFieldInt('shop_branch_to_id', $validation);
        $this->isValidationFieldInt('shop_daughter_from_id', $validation);
        $this->isValidationFieldInt('shop_daughter_to_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setFormula($value){
        $this->setValue('formula', $value);
    }
    public function getFormula(){
        return $this->getValue('formula');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDistance($value){
        $this->setValueFloat('distance', $value);
    }
    public function getDistance(){
        return $this->getValueFloat('distance');
    }

    public function setShopBranchFromID($value){
        $this->setValueInt('shop_branch_from_id', $value);
    }
    public function getShopBranchFromID(){
        return $this->getValueInt('shop_branch_from_id');
    }

    public function setShopBranchToID($value){
        $this->setValueInt('shop_branch_to_id', $value);
    }
    public function getShopBranchToID(){
        return $this->getValueInt('shop_branch_to_id');
    }

    public function setShopDaughterFromID($value){
        $this->setValueInt('shop_daughter_from_id', $value);
    }
    public function getShopDaughterFromID(){
        return $this->getValueInt('shop_daughter_from_id');
    }

    public function setShopDaughterToID($value){
        $this->setValueInt('shop_daughter_to_id', $value);
    }
    public function getShopDaughterToID(){
        return $this->getValueInt('shop_daughter_to_id');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setShopStorageID($value){
        $this->setValueInt('shop_storage_id', $value);
    }
    public function getShopStorageID(){
        return $this->getValueInt('shop_storage_id');
    }

    public function setShopBallastDistanceID($value){
        $this->setValueInt('shop_ballast_distance_id', $value);
    }
    public function getShopBallastDistanceID(){
        return $this->getValueInt('shop_ballast_distance_id');
    }

    public function setShopTransportationPlaceID($value){
        $this->setValueInt('shop_transportation_place_id', $value);
    }
    public function getShopTransportationPlaceID(){
        return $this->getValueInt('shop_transportation_place_id');
    }
}
