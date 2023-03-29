<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Boxcar_Train extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_boxcar_trains';
	const TABLE_ID = 211;

	public function __construct(){
		parent::__construct(
			array(
                'shop_raw_id',
                'shop_boxcar_departure_station_id',
                'shop_boxcar_client_id',
                'shop_boxcar_factory_id',
                'shop_client_id',
                'quantity',
                'tracker',
                'date_shipment',
                'date_drain_from',
                'date_drain_to',
                'date_departure',
                'contract_number',
                'contract_date',
                'is_exit',
                'downtime_permitted',
                'fine_day',
                'boxcars',
                'shop_client_contract_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements)){
			foreach($elements as $element){
				switch($element){
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw());
                        break;
                    case 'shop_boxcar_factory_id':
                        $this->_dbGetElement($this->getShopBoxcarFactoryID(), 'shop_boxcar_factory_id', new Model_Ab1_Shop_Boxcar_Factory());
                        break;
                    case 'shop_boxcar_departure_station_id':
                        $this->_dbGetElement($this->getShopBoxcarDepartureStationID(), 'shop_boxcar_departure_station_id', new Model_Ab1_Shop_Boxcar_Departure_Station());
                        break;
                    case 'shop_boxcar_client_id':
                        $this->_dbGetElement($this->getShopBoxcarClientID(), 'shop_boxcar_client_id', new Model_Ab1_Shop_Client());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client());
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    /**
     * Возвращаем список всех переменных
     * @param bool $isGetElement
     * @param bool $isParseArray
     * @param null $shopID
     * @return array
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['boxcars'] = $this->getBoxcarsArray();
        }

        return $arr;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('shop_boxcar_client_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_boxcar_factory_id', $validation);
        $this->isValidationFieldInt('shop_boxcar_departure_station_id', $validation);
        $this->isValidationFieldStr('contract_number', $validation, 64);
        $this->isValidationFieldStr('tracker', $validation, 64);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldBool('is_exit', $validation);
        $this->isValidationFieldInt('downtime_permitted', $validation);
        $this->isValidationFieldFloat('fine_day', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsExit($value){
        $this->setValueBool('is_exit', $value);
    }
    public function getIsExit(){
        return $this->getValueBool('is_exit');
    }

    public function setDowntimePermitted($value){
        $this->setValueInt('downtime_permitted', $value);
    }
    public function getDowntimePermitted(){
        return $this->getValueInt('downtime_permitted');
    }

    public function setFineDay($value){
        $this->setValueInt('fine_day', $value);
    }
    public function getFineDay(){
        return $this->getValueInt('fine_day');
    }

    public function setShopBoxcarFactoryID($value){
        $this->setValueInt('shop_boxcar_factory_id', $value);
    }
    public function getShopBoxcarFactoryID(){
        return $this->getValueInt('shop_boxcar_factory_id');
    }

    public function setShopBoxcarClientID($value){
        $this->setValueInt('shop_boxcar_client_id', $value);
    }
    public function getShopBoxcarClientID(){
        return $this->getValueInt('shop_boxcar_client_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopBoxcarDepartureStationID($value){
        $this->setValueInt('shop_boxcar_departure_station_id', $value);
    }
    public function getShopBoxcarDepartureStationID(){
        return $this->getValueInt('shop_boxcar_departure_station_id');
    }

    public function setShopRawID($value){
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID(){
        return $this->getValueInt('shop_raw_id');
    }

    public function setContractNumber($value){
        $this->setValue('contract_number', $value);
    }
    public function getContractNumber(){
        return $this->getValue('contract_number');
    }

    public function setContractDate($value){
        $this->setValueDate('contract_date', $value);
    }
    public function getContractDate(){
        return $this->getValueDateTime('contract_date');
    }

    public function setTracker($value){
        $this->setValue('tracker', $value);
    }
    public function getTracker(){
        return $this->getValue('tracker');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setDateShipment($value){
        $this->setValueDateTime('date_shipment', $value);
    }
    public function getDateShipment(){
        return $this->getValueDateTime('date_shipment');
    }

    public function setDateDrainFrom($value){
        $this->setValueDateTime('date_drain_from', $value);
    }
    public function getDateDrainFrom(){
        return $this->getValueDateTime('date_drain_from');
    }

    public function setDateDrainTo($value){
        $this->setValueDateTime('date_drain_to', $value);
    }
    public function getDateDrainTo(){
        return $this->getValueDateTime('date_drain_to');
    }

    public function setDateDeparture($value){
        $this->setValueDateTime('date_departure', $value);
    }
    public function getDateDeparture(){
        return $this->getValueDateTime('date_departure');
    }

    // JSON список номеров вагонов
    public function setBoxcars($value){
        $this->setValue('boxcars', $value);
    }
    public function getBoxcars(){
        return $this->getValue('boxcars');
    }
    public function setBoxcarsArray(array $value){
        $this->setValueArray('boxcars', $value);
    }
    public function getBoxcarsArray(){
        return $this->getValueArray('boxcars');
    }
}
