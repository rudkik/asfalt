<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Competitor_Price_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_competitor_price_items';
	const TABLE_ID = 278;

	public function __construct(){
		parent::__construct(
			array(
                'shop_competitor_id',
                'shop_competitor_price_id',
                'shop_product_id',
                'price',
                'delivery',
                'delivery_zhd',
                'date',
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
		if(($elements !== NULL) || (is_array($elements))){
			foreach($elements as $element){
				switch($element){
                    case 'shop_competitor_id':
                        $this->_dbGetElement($this->getShopCompetitorID(), 'shop_competitor_id', new Model_Ab1_Shop_Competitor(), $shopID);
                        break;
                    case 'shop_competitor_price_id':
                        $this->_dbGetElement($this->getShopCompetitorPriceID(), 'shop_competitor_price_id', new Model_Ab1_Shop_Competitor_Price());
                        break;
					case 'shop_product_id':
						$this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Ab1_Shop_Product());
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
        $validation->rule('shop_competitor_id', 'max_length', array(':value', 11))
			->rule('shop_product_id', 'max_length', array(':value', 11))
			->rule('delivery_zhd', 'max_length', array(':value', 12))
			->rule('price', 'max_length', array(':value', 12))
			->rule('delivery', 'max_length', array(':value', 12))
			->rule('product_capacity', 'max_length', array(':value', 250));
        $this->isValidationFieldInt('shop_competitor_price_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCompetitorPriceID($value){
        $this->setValueInt('shop_competitor_price_id', $value);
    }
    public function getShopCompetitorPriceID(){
        return $this->getValueInt('shop_competitor_price_id');
    }

    public function setShopCompetitorID($value){
        $this->setValueInt('shop_competitor_id', $value);
    }
    public function getShopCompetitorID(){
        return $this->getValueInt('shop_competitor_id');
    }

    public function setProductCapacity($value){
        $this->setValue('product_capacity', $value);
    }
    public function getProductCapacity(){
        return $this->getValue('product_capacity');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setDelivery($value){
        $this->setValueFloat('delivery', $value);
    }
    public function getDelivery(){
        return $this->getValueFloat('delivery');
    }

    public function setDeliveryZhd($value){
        $this->setValueFloat('delivery_zhd', $value);
    }
    public function getDeliveryZhd(){
        return $this->getValueFloat('delivery_zhd');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

}
