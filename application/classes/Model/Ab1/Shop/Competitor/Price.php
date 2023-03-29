<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Competitor_Price extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_competitor_prices';
	const TABLE_ID = 112;

	public function __construct(){
		parent::__construct(
			array(
                'shop_competitor_id',
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
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements !== NULL) || ( is_array($elements))){
			foreach($elements as $element){
				switch($element){
                    case 'shop_competitor_id':
                        $this->_dbGetElement($this->getShopCompetitorID(), 'shop_competitor_id', new Model_Ab1_Shop_Competitor(), $shopID);
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

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopCompetitorID($value){
        $this->setValueInt('shop_competitor_id', $value);
    }
    public function getShopCompetitorID(){
        return $this->getValueInt('shop_competitor_id');
    }

    public function setDate($value){
        $this->setValueDate('date', $value);
    }
    public function getDate(){
        return $this->getValue('date');
    }

}
