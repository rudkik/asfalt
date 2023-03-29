<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Waybill extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_waybills';
    const TABLE_ID = 361;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_driver_id',
                'shop_transport_id',
                'season_id',
                'season_time_id',
                'fuel_issue_id',
                'fuel_type_id',
                'fuel_quantity',
                'date',
                'from_at',
                'to_at',
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
                    case 'shop_transport_driver_id':
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), 0);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), 0);
                        break;
                    case 'season_id':
                        $this->_dbGetElement($this->getSeasonID(), 'season_id', new Model_Ab1_Season(), 0);
                        break;
                    case 'season_time_id':
                        $this->_dbGetElement($this->getSeasonTimeID(), 'season_time_id', new Model_Ab1_Season_Time(), 0);
                        break;
                    case 'fuel_issue_id':
                        $this->_dbGetElement($this->getFuelIssueID(), 'fuel_issue_id', new Model_Ab1_Fuel_Issue(), 0);
                        break;
                    case 'fuel_type_id':
                        $this->_dbGetElement($this->getFuelTypeID(), 'fuel_type_id', new Model_Ab1_Fuel_Type(), 0);
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
        $this->isValidationFieldInt('shop_transport_driver_id', $validation);
        $this->isValidationFieldInt('shop_transport_id', $validation);
        $this->isValidationFieldInt('season_id', $validation);
        $this->isValidationFieldInt('season_time_id', $validation);
        $this->isValidationFieldInt('fuel_issue_id', $validation);
        $this->isValidationFieldInt('fuel_type_id', $validation);
        $this->isValidationFieldFloat('fuel_quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopSubdivisionID($value){
        $this->setValueInt('shop_subdivision_id', $value);
    }
    public function getShopSubdivisionID(){
        return $this->getValueInt('shop_subdivision_id');
    }

    public function setShopTransportDriverID($value){
        $this->setValueInt('shop_transport_driver_id', $value);
    }
    public function getShopTransportDriverID(){
        return $this->getValueInt('shop_transport_driver_id');
    }

    public function setShopTransportID($value){
        $this->setValueInt('shop_transport_id', $value);
    }
    public function getShopTransportID(){
        return $this->getValueInt('shop_transport_id');
    }

    public function setSeasonID($value){
        $this->setValueInt('season_id', $value);
    }
    public function getSeasonID(){
        return $this->getValueInt('season_id');
    }
    public function setSeasonTimeID($value){
        $this->setValueInt('season_time_id', $value);
    }
    public function getSeasonTimeID(){
        return $this->getValueInt('season_time_id');
    }
    public function setFuelIssueID($value){
        $this->setValueInt('fuel_issue_id', $value);
    }
    public function getFuelIssueID(){
        return $this->getValueInt('fuel_issue_id');
    }
    public function setFuelTypeID($value){
        $this->setValueInt('fuel_type_id', $value);
    }
    public function getFuelTypeID(){
        return $this->getValueInt('fuel_type_id');
    }

    public function setFuelQuantityFrom($value){
        $this->setValueFloat('fuel_quantity_from', $value);
    }
    public function getFuelQuantityFrom(){
        return $this->getValueFloat('fuel_quantity_from');
    }

    public function setFuelQuantityTo($value){
        $this->setValueFloat('fuel_quantity_to', $value);
    }
    public function getFuelQuantityTo(){
        return $this->getValueFloat('fuel_quantity_to');
    }

    public function getFuelQuantityExpenses(){
        return $this->getValueFloat('fuel_quantity_expenses');
    }

    public function getFuelQuantityIssues(){
        return $this->getValueFloat('fuel_quantity_issues');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setFromAt($value){
        $this->setValueDateTime('from_at', $value);
    }
    public function getFromAt(){
        return $this->getValueDateTime('from_at');
    }

    public function setToAt($value){
        $this->setValueDateTime('to_at', $value);
    }
    public function getToAt(){
        return $this->getValueDateTime('to_at');
    }

    public function setTransportViewID($value){
        $this->setValueInt('transport_view_id', $value);
    }
    public function getTransportViewID(){
        return $this->getValueInt('transport_view_id');
    }

    public function setTransportWorkID($value){
        $this->setValueInt('transport_work_id', $value);
    }
    public function getTransportWorkID(){
        return $this->getValueInt('transport_work_id');
    }

    public function setTransportWageID($value){
        $this->setValueInt('transport_wage_id', $value);
    }
    public function getTransportWageID(){
        return $this->getValueInt('transport_wage_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setMilageFrom($value){
        $this->setValueFloat('milage_from', $value);
    }
    public function getMilageFrom(){
        return $this->getValueFloat('milage_from');
    }

    public function setMilageTo($value){
        $this->setValueFloat('milage_to', $value);
    }
    public function getMilageTo(){
        return $this->getValueFloat('milage_to');
    }

    public function setMilage($value){
        $this->setValueFloat('milage', $value);
    }
    public function getMilage(){
        return $this->getValueFloat('milage');
    }

    public function setTransportFormPaymentID($value){
        $this->setValueInt('transport_form_payment_id', $value);
    }
    public function getTransportFormPaymentID(){
        return $this->getValueInt('transport_form_payment_id');
    }

    public function setWage($value){
        $this->setValueFloat('wage', $value);
    }
    public function getWage(){
        return $this->getValueFloat('wage');
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}
