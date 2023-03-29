<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Transport_Waybill_Car extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_transport_waybill_cars';
    const TABLE_ID = 415;

    public function __construct(){
        parent::__construct(
            array(
                'shop_transport_driver_id',
                'shop_transport_id',
                'date',
                'from_at',
                'to_at',
                'distance',
                'shop_transport_waybill_id',
                'shop_car_to_material_id',
                'shop_ballast_id',
                'shop_piece_id',
                'shop_transportation_id',
                'shop_car_id',
                'shop_client_to_id',
                'shop_daughter_from_id',
                'shop_branch_to_id',
                'shop_branch_from_id',
                'shop_ballast_crusher_to_id',
                'shop_ballast_crusher_from_id',
                'quantity',
                'shop_transportation_place_to_id',
                'shop_material_id',
                'shop_raw_id',
                'shop_product_id',
                'count_trip',
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
                        $this->_dbGetElement($this->getShopTransportDriverID(), 'shop_transport_driver_id', new Model_Ab1_Shop_Transport_Driver(), $shopID);
                        break;
                    case 'shop_transport_id':
                        $this->_dbGetElement($this->getShopTransportID(), 'shop_transport_id', new Model_Ab1_Shop_Transport(), $shopID);
                        break;
                    case 'shop_transport_waybill_id':
                        $this->_dbGetElement($this->getShopTransportWaybillID(), 'shop_transport_waybill_id', new Model_Ab1_Shop_Transport_Waybill(), $shopID);
                        break;
                    case 'shop_car_to_material_id':
                        $this->_dbGetElement($this->getShopCarToMaterialID(), 'shop_car_to_material_id', new Model_Ab1_Shop_Car_To_Material(), $shopID);
                        break;
                    case 'shop_ballast_id':
                        $this->_dbGetElement($this->getShopBallastID(), 'shop_ballast_id', new Model_Ab1_Shop_Ballast(), $shopID);
                        break;
                    case 'shop_piece_id':
                        $this->_dbGetElement($this->getShopPieceID(), 'shop_piece_id', new Model_Ab1_Shop_Piece(), $shopID);
                        break;
                    case 'shop_transportation_id':
                        $this->_dbGetElement($this->getShopTransportationID(), 'shop_transportation_id', new Model_Ab1_Shop_Transportation(), $shopID);
                        break;
                    case 'shop_car_id':
                        $this->_dbGetElement($this->getShopCarID(), 'shop_car_id', new Model_Ab1_Shop_Car(), $shopID);
                        break;
                    case 'shop_client_to_id':
                        $this->_dbGetElement($this->getShopClientToID(), 'shop_client_to_id', new Model_Ab1_Shop_Client_To(), $shopID);
                        break;
                    case 'shop_daughter_from_id':
                        $this->_dbGetElement($this->getShopDaughterFromID(), 'shop_daughter_from_id', new Model_Ab1_Shop_Daughter_From(), $shopID);
                        break;
                    case 'shop_branch_to_id':
                        $this->_dbGetElement($this->getShopBranchToID(), 'shop_branch_to_id', new Model_Ab1_Shop_Branch_To(), $shopID);
                        break;
                    case 'shop_branch_from_id':
                        $this->_dbGetElement($this->getShopBranchFromID(), 'shop_branch_from_id', new Model_Ab1_Shop_Branch_From(), $shopID);
                        break;
                    case 'shop_ballast_crusher_to_id':
                        $this->_dbGetElement($this->getShopBallastCrusherToID(), 'shop_ballast_crusher_to_id', new Model_Ab1_Shop_Ballast_Crusher_To(), $shopID);
                        break;
                    case 'shop_ballast_crusher_from_id':
                        $this->_dbGetElement($this->getShopBallastCrusherFromID(), 'shop_ballast_crusher_from_id', new Model_Ab1_Shop_Ballast_Crusher_From(), $shopID);
                        break;
                    case 'shop_transportation_place_to_id':
                        $this->_dbGetElement($this->getShopTransportationPlaceToID(), 'shop_transportation_place_to_id', new Model_Ab1_Shop_Transportation_Place_To(), $shopID);
                        break;
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product(), $shopID);
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
        $this->isValidationFieldInt('shop_transport_waybill_id', $validation);
        $this->isValidationFieldInt('shop_car_to_material_id', $validation);
        $this->isValidationFieldInt('shop_ballast_id', $validation);
        $this->isValidationFieldInt('shop_transportation_id', $validation);
        $this->isValidationFieldInt('shop_car_id', $validation);
        $this->isValidationFieldInt('shop_client_to_id', $validation);
        $this->isValidationFieldInt('shop_branch_to_id', $validation);
        $this->isValidationFieldInt('shop_branch_from_id', $validation);
        $this->isValidationFieldInt('shop_ballast_crusher_to_id', $validation);
        $this->isValidationFieldInt('shop_ballast_crusher_from_id', $validation);
        $this->isValidationFieldInt('shop_transportation_place_to_id', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('count_trip', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldStr('distance', $validation);
        return $this->_validationFields($validation, $errorFields);
    }
    
    private function _setEmptyDocumentID($value){
        if($value > 0){
            return;
        }

        $this->setShopCarID(0);
        $this->setShopCarToMaterialID(0);
        $this->setShopLesseeCarID(0);
        $this->setShopMoveCarID(0);
        $this->setShopDefectCarID(0);
        $this->setShopMoveOtherID(0);
        $this->setShopPieceID(0);
        $this->setShopTransportationID(0);
        $this->setShopBallastID(0);
    }

    private function _setEmptyGoods($value){
        if($value < 1){
            return;
        }

        $this->setShopRawID(0);
        $this->setShopMaterialID(0);
        $this->setShopProductID(0);
        $this->setShopMaterialOtherID(0);
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

    public function setShopProductStorageID($value){
        $this->setValueInt('shop_product_storage_id', $value);
    }
    public function getShopProductStorageID(){
        return $this->getValueInt('shop_product_storage_id');
    }

    public function setShopStorageToID($value){
        $this->setValueInt('shop_storage_to_id', $value);
    }
    public function getShopStorageToID(){
        return $this->getValueInt('shop_storage_to_id');
    }

    public function setShopTransportWaybillID($value){
        $this->setValueInt('shop_transport_waybill_id', $value);
    }
    public function getShopTransportWaybillID(){
        return $this->getValueInt('shop_transport_waybill_id');
    }

    public function setShopCarToMaterialID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_car_to_material_id', $value);
    }
    public function getShopCarToMaterialID(){
        return $this->getValueInt('shop_car_to_material_id');
    }
    public function setShopBallastID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_ballast_id', $value);
    }
    public function getShopBallastID(){
        return $this->getValueInt('shop_ballast_id');
    }
    public function setShopPieceID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_piece_id', $value);
    }
    public function getShopPieceID(){
        return $this->getValueInt('shop_piece_id');
    }
    public function setShopTransportationID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_transportation_id', $value);
    }
    public function getShopTransportationID(){
        return $this->getValueInt('shop_transportation_id');
    }
    public function setShopCarID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_car_id', $value);
    }
    public function getShopCarID(){
        return $this->getValueInt('shop_car_id');
    }
    public function setShopClientToID($value){
        $this->setValueInt('shop_client_to_id', $value);
    }
    public function getShopClientToID(){
        return $this->getValueInt('shop_client_to_id');
    }
    public function setShopDaughterFromID($value){
        $this->setValueInt('shop_daughter_from_id', $value);
    }
    public function getShopDaughterFromID(){
        return $this->getValueInt('shop_daughter_from_id');
    }

    public function setShopBranchToID($value){
        $this->setValueInt('shop_branch_to_id', $value);
    }
    public function getShopBranchToID(){
        return $this->getValueInt('shop_branch_to_id');
    }

    public function setShopBranchFromID($value){
        $this->setValueInt('shop_branch_from_id', $value);
    }
    public function getShopBranchFromID(){
        return $this->getValueInt('shop_branch_from_id');
    }

    public function setShopBallastCrusherToID($value){
        $this->setValueInt('shop_ballast_crusher_to_id', $value);
    }
    public function getShopBallastCrusherToID(){
        return $this->getValueInt('shop_ballast_crusher_to_id');
    }

    public function setShopBallastDistanceID($value){
        $this->setValueInt('shop_ballast_distance_id', $value);
    }
    public function getShopBallastDistanceID(){
        return $this->getValueInt('shop_ballast_distance_id');
    }

    public function setShopBallastCrusherFromID($value){
        $this->setValueInt('shop_ballast_crusher_from_id', $value);
    }
    public function getShopBallastCrusherFromID(){
        return $this->getValueInt('shop_ballast_crusher_from_id');
    }
    public function setShopTransportationPlaceToID($value){
        $this->setValueInt('shop_transportation_place_to_id', $value);
    }
    public function getShopTransportationPlaceToID(){
        return $this->getValueInt('shop_transportation_place_to_id');
    }

    public function setShopMaterialID($value){
        $this->_setEmptyGoods($value);
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID(){
        return $this->getValueInt('shop_material_id');
    }

    public function setShopMaterialOtherID($value){
        $this->_setEmptyGoods($value);
        $this->setValueInt('shop_material_other_id', $value);
    }
    public function getShopMaterialOtherID(){
        return $this->getValueInt('shop_material_other_id');
    }

    public function setShopRawID($value){
        $this->_setEmptyGoods($value);
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
    }

    public function setShopProductID($value){
        $this->_setEmptyGoods($value);
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopProductRubricID($value){
        $this->_setEmptyGoods($value);
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setShopMoveCarID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_move_car_id', $value);
    }
    public function getShopMoveCarID(){
        return $this->getValueInt('shop_move_car_id');
    }

    public function setShopDefectCarID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_defect_car_id', $value);
    }
    public function getShopDefectCarID(){
        return $this->getValueInt('shop_defect_car_id');
    }

    public function setShopMoveOtherID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_move_other_id', $value);
    }
    public function getShopMoveOtherID(){
        return $this->getValueInt('shop_move_other_id');
    }

    public function setShopMoveClientToID($value){
        $this->setValueInt('shop_move_client_to_id', $value);
    }
    public function getShopMoveClientToID(){
        return $this->getValueInt('shop_move_client_to_id');
    }

    public function setShopMovePlaceToID($value){
        $this->setValueInt('shop_move_place_to_id', $value);
    }
    public function getShopMovePlaceToID(){
        return $this->getValueInt('shop_move_place_to_id');
    }

    public function setShopLesseeCarID($value){
        $this->_setEmptyDocumentID($value);
        $this->setValueInt('shop_lessee_car_id', $value);
    }
    public function getShopLesseeCarID(){
        return $this->getValueInt('shop_lessee_car_id');
    }

    public function setShopTransportRouteID($value){
        $this->setValueInt('shop_transport_route_id', $value);
    }
    public function getShopTransportRouteID(){
        return $this->getValueInt('shop_transport_route_id');
    }

    public function setCountTrip($value){
        $this->setValueInt('count_trip', $value);
    }
    public function getCountTrip(){
        return $this->getValueInt('count_trip');
    }

    public function setWage($value){
        $this->setValueFloat('wage', round($value, 2));
    }
    public function getWage(){
        return $this->getValueFloat('wage');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
    public function setDistance($value){
        $this->setValueFloat('distance', $value);
    }
    public function getDistance(){
        return $this->getValueFloat('distance');
    }

    public function setDate($value){
        $this->setValueDateTime('date', $value);
    }
    public function getDate(){
        return $this->getValueDateTime('date');
    }

    public function setIsHand($value){
        $this->setValueBool('is_hand', $value);
    }
    public function getIsHand(){
        return $this->getValueBool('is_hand');
    }

    public function setIsWage($value){
        $this->setValueBool('is_wage', $value);
    }
    public function getIsWage(){
        return $this->getValueBool('is_wage');
    }

    public function setToName($value){
        $this->setValue('to_name', $value);
    }
    public function getToName(){
        return $this->getValue('to_name');
    }

    public function setProductName($value){
        $this->setValue('product_name', $value);
    }
    public function getProductName(){
        return $this->getValue('product_name');
    }

    public function setCoefficient($value){
        if($value <= 0){
            $value = 1;
        }

        $this->setValueFloat('coefficient', $value);
    }
    public function getCoefficient(){
        return $this->getValueFloat('coefficient');
    }
}
