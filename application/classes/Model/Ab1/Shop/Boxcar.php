<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Boxcar extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_boxcars';
	const TABLE_ID = 207;

	public function __construct(){
		parent::__construct(
			array(
                'shop_raw_id',
                'shop_boxcar_departure_station_id',
                'shop_boxcar_client_id',
                'shop_boxcar_train_id',
                'shop_client_id',
                'number',
                'stamp',
                'quantity',
                'date_drain_from',
                'date_drain_to',
                'date_departure',
                'is_exit',
                'date_arrival',
                'drain_to_shop_operation_id_1',
                'drain_from_shop_operation_id_1',
                'drain_to_shop_operation_id_2',
                'drain_from_shop_operation_id_2',
                'brigadier_drain_to_shop_operation_id',
                'brigadier_drain_from_shop_operation_id',
                'drain_zhdc_from_shop_operation_id',
                'drain_zhdc_to_shop_operation_id',
                'zhdc_shop_operation_id',
                'shop_client_contract_id',
                'shop_raw_drain_chute_id',
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
                    case 'shop_boxcar_train_id':
                        $this->_dbGetElement($this->getShopBoxcarTrainID(), 'shop_boxcar_train_id', new Model_Ab1_Shop_Boxcar_Train());
                        break;
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw());
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
        $this->isValidationFieldInt('shop_boxcar_departure_station_id', $validation);
        $this->isValidationFieldInt('shop_boxcar_train_id', $validation);
        $this->isValidationFieldStr('number', $validation, 64);
        $this->isValidationFieldStr('stamp', $validation, 64);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldBool('is_exit', $validation);
        $this->isValidationFieldInt('drain_to_shop_operation_id_1', $validation);
        $this->isValidationFieldInt('drain_from_shop_operation_id_1', $validation);
        $this->isValidationFieldInt('drain_to_shop_operation_id_2', $validation);
        $this->isValidationFieldInt('drain_from_shop_operation_id_2', $validation);
        $this->isValidationFieldInt('brigadier_drain_to_shop_operation_id', $validation);
        $this->isValidationFieldInt('brigadier_drain_from_shop_operation_id', $validation);
        $this->isValidationFieldInt('drain_zhd_from_shop_operation_id', $validation);
        $this->isValidationFieldInt('drain_zhdc_to_shop_operation_id', $validation);
        $this->isValidationFieldInt('zhdc_shop_operation_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_raw_drain_chute_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopRawDrainChuteID($value){
        $this->setValueInt('shop_raw_drain_chute_id', $value);
    }
    public function getShopRawDrainChuteID(){
        return $this->getValueInt('shop_raw_drain_chute_id');
    }

    public function setIsExit($value){
        $this->setValueBool('is_exit', $value);
    }
    public function getIsExit(){
        return $this->getValueBool('is_exit');
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

    public function setShopBoxcarTrainID($value){
        $this->setValueInt('shop_boxcar_train_id', $value);
    }
    public function getShopBoxcarTrainID(){
        return $this->getValueInt('shop_boxcar_train_id');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }

    public function setStamp($value){
        $this->setValue('stamp', $value);
    }
    public function getStamp(){
        return $this->getValue('stamp');
    }

    public function setDrainText($value){
        $this->setValue('drain_text', $value);
    }
    public function getDrainText(){
        return $this->getValue('drain_text');
    }

    public function setSending($value){
        $this->setValue('sending', $value);
    }
    public function getSending(){
        return $this->getValue('sending');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
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

        $this->setIsExit(Func::_empty($this->getDateDeparture()));
    }
    public function getDateDeparture(){
        return $this->getValueDateTime('date_departure');
    }

    public function setDateArrival($value){
        $this->setValueDateTime('date_arrival', $value);
    }
    public function getDateArrival(){
        return $this->getValueDateTime('date_arrival');
    }

    public function setDrainFromShopOperationID1($value){
        $this->setValueInt('drain_from_shop_operation_id_1', $value);
    }
    public function getDrainFromShopOperationID1(){
        return $this->getValueInt('drain_from_shop_operation_id_1');
    }

    public function setDrainToShopOperationID1($value){
        $this->setValueInt('drain_to_shop_operation_id_1', $value);
    }
    public function getDrainToShopOperationID1(){
        return $this->getValueInt('drain_to_shop_operation_id_1');
    }

    public function setDrainFromShopOperationID2($value){
        $this->setValueInt('drain_from_shop_operation_id_2', $value);
    }
    public function getDrainFromShopOperationID2(){
        return $this->getValueInt('drain_from_shop_operation_id_2');
    }

    public function setDrainToShopOperationID2($value){
        $this->setValueInt('drain_to_shop_operation_id_2', $value);
    }
    public function getDrainToShopOperationID2(){
        return $this->getValueInt('drain_to_shop_operation_id_2');
    }

    public function setBrigadierDrainFromShopOperationID($value){
        $this->setValueInt('brigadier_drain_from_shop_operation_id', $value);
    }
    public function getBrigadierDrainFromShopOperationID(){
        return $this->getValueInt('brigadier_drain_from_shop_operation_id');
    }

    public function setBrigadierDrainToShopOperationID($value){
        $this->setValueInt('brigadier_drain_to_shop_operation_id', $value);
    }
    public function getBrigadierDrainToShopOperationID(){
        return $this->getValueInt('brigadier_drain_to_shop_operation_id');
    }

    public function setDrainZHDCFromShopOperationID($value){
        $this->setValueInt('drain_zhdc_from_shop_operation_id', $value);
    }
    public function getDrainZHDCFromShopOperationID(){
        return $this->getValueInt('drain_zhdc_from_shop_operation_id');
    }

    public function setDrainZHDCToShopOperationID($value){
        $this->setValueInt('drain_zhdc_to_shop_operation_id', $value);
    }
    public function getDrainZHDCToShopOperationID(){
        return $this->getValueInt('drain_zhdc_to_shop_operation_id');
    }

    public function setZHDCShopOperationID($value){
        $this->setValueInt('zhdc_shop_operation_id', $value);
    }
    public function getZHDCShopOperationID(){
        return $this->getValueInt('zhdc_shop_operation_id');
    }

    public function setResidue($value){
        $this->setValueFloat('residue', $value);
    }
    public function getResidue(){
        return $this->getValueFloat('residue');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }
}
