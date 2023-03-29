<?php defined('SYSPATH') or die('No direct script access.');

class Model_AutoPart_Shop_Courier_Route extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ap_shop_courier_routes';
    const TABLE_ID = '';

    public function __construct(){
        parent::__construct(
            array(
			'shop_courier_id',
			'price_km',
			'amount',
			'shop_courier_address_id_from',
			'date',
			'quantity_points',
			'seconds',
			'distance',
			'mean_point_distance_km',
			'mean_point_second',
			'wage',
			'price_point',
			'shop_courier_address_id_to',
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
                    case 'shop_courier_id':
                        $this->_dbGetElement($this->getShopCourierID(), 'shop_courier_id', new Model_AutoPart_Shop_Courier());
                        break;
                    case 'shop_courier_address_id_from':
                        $this->_dbGetElement($this->getShopCourierAddressIDFrom(), 'shop_courier_address_id_from', new Model_AutoPart_Shop_Courier_Address());
                        break;
                    case 'shop_courier_address_id_to':
                        $this->_dbGetElement($this->getShopCourierAddressIDTo(), 'shop_courier_address_id_to', new Model_AutoPart_Shop_Courier_Address());
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

        $this->isValidationFieldInt('shop_courier_id', $validation);
        $validation->rule('price_km', 'max_length', array(':value',13));
        $validation->rule('amount', 'max_length', array(':value',13));
        $this->isValidationFieldInt('shop_courier_address_id_from', $validation);
        $this->isValidationFieldInt('quantity_points', $validation);
        $validation->rule('seconds', 'max_length', array(':value',13));
        $validation->rule('distance', 'max_length', array(':value',13));
        $validation->rule('mean_point_distance_km', 'max_length', array(':value',13));
        $validation->rule('mean_point_second', 'max_length', array(':value',13));
        $validation->rule('wage', 'max_length', array(':value',13));
        $validation->rule('price_point', 'max_length', array(':value',13));
        $this->isValidationFieldInt('shop_courier_address_id_to', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCourierID($value){
        $this->setValueInt('shop_courier_id', $value);
    }
    public function getShopCourierID(){
        return $this->getValueInt('shop_courier_id');
    }

    public function setPriceKm($value){
        $this->setValueFloat('price_km', $value);
    }
    public function getPriceKm(){
        return $this->getValueFloat('price_km');

        $this->setAmount($this->getDistance() * $this->getPriceKm());
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopCourierAddressIDFrom($value){
        $this->setValueInt('shop_courier_address_id_from', $value);
    }
    public function getShopCourierAddressIDFrom(){
        return $this->getValueInt('shop_courier_address_id_from');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValueDate('date');
    }

    public function setQuantityPoints($value){
        $this->setValueInt('quantity_points', $value);

        if($this->getQuantityPoints() > 0) {
            $this->setMeanPointDistanceKm($this->getDistance() / $this->getQuantityPoints());
            $this->setMeanPointSecond($this->getSeconds() / $this->getQuantityPoints());
        }else{
            $this->setMeanPointDistanceKm(0);
            $this->setMeanPointSecond(0);
        }

        $this->setWage($this->getQuantityPoints() * $this->getPricePoint());
    }
    public function getQuantityPoints(){
        return $this->getValueInt('quantity_points');
    }

    public function setSeconds($value){
        $this->setValueFloat('seconds', $value);

        if($this->getQuantityPoints() > 0) {
            $this->setMeanPointSecond($this->getSeconds() / $this->getQuantityPoints());
        }else{
            $this->setMeanPointSecond(0);
        }
    }
    public function getSeconds(){
        return $this->getValueFloat('seconds');
    }

    public function setDistance($value){
        $this->setValueFloat('distance', $value);

        if($this->getQuantityPoints() > 0) {
            $this->setMeanPointDistanceKm($this->getDistance() / $this->getQuantityPoints());
        }else{
            $this->setMeanPointDistanceKm(0);
        }

        $this->setAmount($this->getDistance() * $this->getPriceKm());
    }
    public function getDistance(){
        return $this->getValueFloat('distance');
    }

    public function setMeanPointDistanceKm($value){
        $this->setValueFloat('mean_point_distance_km', round($value, 3));
    }
    public function getMeanPointDistanceKm(){
        return $this->getValueFloat('mean_point_distance_km');
    }

    public function setMeanPointSecond($value){
        $this->setValueFloat('mean_point_second', $value);
    }
    public function getMeanPointSecond(){
        return $this->getValueFloat('mean_point_second');
    }

    public function setWage($value){
        $this->setValueFloat('wage', $value);
    }
    public function getWage(){
        return $this->getValueFloat('wage');
    }

    public function setPricePoint($value){
        $this->setValueFloat('price_point', $value);

        $this->setWage($this->getQuantityPoints() * $this->getPricePoint());
    }
    public function getPricePoint(){
        return $this->getValueFloat('price_point');
    }

    public function setShopCourierAddressIDTo($value){
        $this->setValueInt('shop_courier_address_id_to', $value);
    }
    public function getShopCourierAddressIDTo(){
        return $this->getValueInt('shop_courier_address_id_to');
    }

    public function setFromAt($value){
        $this->setValueDateTime('from_at', $value);

        if(!Func::_empty($this->getFromAt()) && !Func::_empty($this->getToAt())){
            $this->setSeconds(Helpers_DateTime::diffSeconds($this->getToAt(), $this->getFromAt()));
        }else{
            $this->setSeconds(0);
        }
    }
    public function getFromAt(){
        return $this->getValueDateTime('from_at');
    }

    public function setToAt($value){
        $this->setValueDateTime('to_at', $value);

        if(!Func::_empty($this->getFromAt()) && !Func::_empty($this->getToAt())){
            $this->setSeconds(Helpers_DateTime::diffSeconds($this->getToAt(), $this->getFromAt()));
        }else{
            $this->setSeconds(0);
        }
        $this->setIsFinish(!Func::_empty($this->getToAt()));
    }
    public function getToAt(){
        return $this->getValueDateTime('to_at');
    }

    public function setShopCourierRouteItemIDCurrent($value){
        $this->setValueInt('shop_courier_route_item_id_current', $value);
    }
    public function getShopCourierRouteItemIDCurrent(){
        return $this->getValueInt('shop_courier_route_item_id_current');
    }

    public function setIsFinish($value){
        $this->setValueBool('is_finish', $value);
    }
    public function getIsFinish(){
        return $this->getValueBool('is_finish');
    }

    public function setQuantityPreOrderPoints($value){
        $this->setValueInt('quantity_pre_order_points', $value);

        $this->setQuantityPoints(
            $this->getQuantityPreOrderPoints() + $this->getQuantityBillPoints()
            + $this->getQuantityReturnPoints()+ $this->getQuantityOtherPoints()
        );
    }
    public function getQuantityPreOrderPoints(){
        return $this->getValueInt('quantity_pre_order_points');
    }

    public function setQuantityBillPoints($value){
        $this->setValueInt('quantity_bill_points', $value);

        $this->setQuantityPoints(
            $this->getQuantityPreOrderPoints() + $this->getQuantityBillPoints()
            + $this->getQuantityReturnPoints()+ $this->getQuantityOtherPoints()
        );
    }
    public function getQuantityBillPoints(){
        return $this->getValueInt('quantity_bill_points');
    }

    public function setQuantityReturnPoints($value){
        $this->setValueInt('quantity_return_points', $value);

        $this->setQuantityPoints(
            $this->getQuantityPreOrderPoints() + $this->getQuantityBillPoints()
            + $this->getQuantityReturnPoints()+ $this->getQuantityOtherPoints()
        );
    }
    public function getQuantityReturnPoints(){
        return $this->getValueInt('quantity_return_points');
    }

    public function setQuantityOtherPoints($value){
        $this->setValueInt('quantity_other_points', $value);

        $this->setQuantityPoints(
            $this->getQuantityPreOrderPoints() + $this->getQuantityBillPoints()
            + $this->getQuantityReturnPoints()+ $this->getQuantityOtherPoints()
        );
    }
    public function getQuantityOtherPoints(){
        return $this->getValueInt('quantity_other_points');
    }
}
