<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Addition_Service_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_addition_service_items';
	const TABLE_ID = 311;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_product_id',
                'quantity',
                'price',
                'amount',
                'shop_car_id',
                'shop_client_id',
                'shop_client_attorney_id',
                'shop_client_contract_id',
                'shop_act_service_id',
                'shop_piece_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements !== NULL) && (! is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
                        break;
                    case 'shop_car_id':
                        $this->_dbGetElement($this->getShopCarID(), 'shop_car_id', new Model_Ab1_Shop_Car());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_client_contract_id', new Model_Ab1_Shop_Client_Contract(), $shopID);
                        break;
                    case 'shop_client_attorney_id':
                        $this->_dbGetElement($this->getShopClientAttorneyID(), 'shop_client_attorney_id', new Model_Ab1_Shop_Client_Attorney(), $shopID);
                        break;
                    case 'shop_act_service_id':
                        $this->_dbGetElement($this->getShopActServiceID(), 'shop_act_service_id', new Model_Ab1_Shop_Act_Service());
                        break;
                    case 'shop_piece_id':
                        $this->_dbGetElement($this->getShopPieceID(), 'shop_piece_id', new Model_Ab1_Shop_Piece());
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
        $validation->rule('quantity', 'max_length', array(':value', 12))
			->rule('price', 'max_length', array(':value', 12))
			->rule('amount', 'max_length', array(':value', 12));

        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_car_id', $validation);
        $this->isValidationFieldInt('shop_client_attorney_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);
        $this->isValidationFieldInt('shop_client_id', $validation);
        $this->isValidationFieldInt('shop_act_service_id', $validation);
        $this->isValidationFieldInt('shop_piece_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('amount', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopPieceID($value){
        $this->setValueInt('shop_piece_id', $value);
    }
    public function getShopPieceID(){
        return $this->getValueInt('shop_piece_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
        $this->setAmount($this->getQuantity() * $this->getPrice());
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setShopCarID($value){
        $this->setValueInt('shop_car_id', $value);
    }
    public function getShopCarID(){
        return $this->getValueInt('shop_car_id');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientAttorneyID($value){
        $this->setValueInt('shop_client_attorney_id', $value);
    }
    public function getShopClientAttorneyID(){
        return $this->getValueInt('shop_client_attorney_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopActServiceID($value){
        $this->setValueInt('shop_act_service_id', $value);
    }
    public function getShopActServiceID(){
        return $this->getValueInt('shop_act_service_id');
    }
}
