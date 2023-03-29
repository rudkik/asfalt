<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Bid_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_bid_items';
	const TABLE_ID = 228;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_bid_id',
                'shop_product_id',
                'quantity',
                'delivery',
                'date',
                'month',
                'year',
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
		if(($elements === NULL) || (! is_array($elements))){
		}else{
			foreach($elements as $element){
				switch($element){
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
                        break;
                    case 'shop_bid_id':
                        $this->_dbGetElement($this->getShopBidID(), 'shop_bid_id', new Model_Ab1_Shop_Bid());
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
        $validation->rule('shop_client_id', 'max_length', array(':value', 11))
			->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('quantity', 'max_length', array(':value', 12))
			->rule('delivery', 'max_length', array(':value', 12))
			->rule('month', 'max_length', array(':value', 2))
            ->rule('year', 'max_length', array(':value', 4));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

    public function setMonth($value){
        $this->setValueInt('month', $value);
    }
    public function getMonth(){
        return $this->getValueInt('month');
    }

    public function setYear($value){
        $this->setValueInt('year', $value);
    }
    public function getYear(){
        return $this->getValueInt('year');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopBidID($value){
        $this->setValueInt('shop_bid_id', $value);
    }
    public function getShopBidID(){
        return $this->getValueInt('shop_bid_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setDelivery($value){
        $this->setValueFloat('delivery', $value);
    }
    public function getDelivery(){
        return $this->getValueFloat('delivery');
    }
}
