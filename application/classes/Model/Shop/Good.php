<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Good extends Model_Shop_Basic_Collations{

	const TABLE_NAME = 'ct_shop_goods';
	const TABLE_ID = 1;

	public function __construct(){
		parent::__construct(
			array(
				'article',
				'price_old',
                'price',
                'price_cost',
				'system_is_discount',
				'system_discount',
				'system_shop_discount_id',
				'system_shop_action_id',
				'system_is_action',
				'system_is_percent',
				'discount',
				'is_percent',
				'is_group',
				'is_in_stock',
                'discount_to_at',
                'discount_from_at',
                'shop_table_stock_id',
                'stock_name',
                'work_type_id',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isVersion = FALSE;
        $this->isAddUUID = TRUE;
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements)){
			foreach($elements as $element){
				switch($element){
                    case 'shop_table_preview_id':
                        $this->_dbGetElement($this->id, 'shop_table_preview', new Model_Shop_Table_Preview());
                        break;
                    case 'shop_table_stock_id':
                        $this->_dbGetElement($this->getShopTableStockID(), 'shop_table_stock_id', new Model_Shop_Table_Stock());
                        break;
                    case 'work_type_id':
                        $this->_dbGetElement($this->getWorkTypeID(), 'work_type_id', new Model_WorkType());
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

		$validation->rule('article', 'max_length', array(':value', 100))
			->rule('system_is_discount', 'max_length', array(':value', 1))
			->rule('system_shop_discount_id', 'max_length', array(':value', 11))
            ->rule('system_shop_action_id', 'max_length', array(':value', 11))
            ->rule('work_type_id', 'max_length', array(':value', 11))
			->rule('system_is_action', 'max_length', array(':value', 1))
			->rule('system_is_percent', 'max_length', array(':value', 1))
			->rule('is_percent', 'max_length', array(':value', 1))
			->rule('is_group', 'max_length', array(':value', 1))
            ->rule('discount_to_at', 'max_length', array(':value', 20))
            ->rule('discount_from_at', 'max_length', array(':value', 20))
			->rule('is_in_stock', 'max_length', array(':value', 1))
            ->rule('shop_table_stock_id', 'max_length', array(':value', 11))
            ->rule('stock_name', 'max_length', array(':value', 50));

        if ($this->isFindFieldAndIsEdit('shop_table_stock_id')) {
            $validation->rule('shop_table_stock_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('work_type_id')) {
            $validation->rule('work_type_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('discount_from_at')) {
            $validation->rule('discount_from_at', 'date');
        }
        if ($this->isFindFieldAndIsEdit('discount_to_at')) {
            $validation->rule('discount_to_at', 'date');
        }
		if ($this->isFindFieldAndIsEdit('system_is_discount')) {
			$validation->rule('system_is_discount', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('system_is_discount')) {
			$validation->rule('system_is_discount', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('system_shop_discount_id')) {
			$validation->rule('system_shop_discount_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('system_shop_action_id')) {
			$validation->rule('system_shop_action_id', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('system_is_action')) {
			$validation->rule('system_is_action', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('system_is_percent')) {
			$validation->rule('system_is_percent', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('is_percent')) {
			$validation->rule('is_percent', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('is_group')) {
			$validation->rule('is_group', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('is_in_stock')) {
			$validation->rule('is_in_stock', 'digit');
		}

		return $this->_validationFields($validation, $errorFields);
	}

    public function setWorkTypeID($value){
        $this->setValueInt('work_type_id', $value);
    }
    public function getWorkTypeID(){
        return $this->getValueInt('work_type_id');
    }

    public function setShopTableStockID($value){
        $this->setValueInt('shop_table_stock_id', $value);
    }
    public function getShopTableStockID(){
        return $this->getValueInt('shop_table_stock_id');
    }
    public function setStockName($value){
        $this->setValue('stock_name', $value);
    }
    public function getStockName(){
        return $this->getValue('stock_name');
    }

    //Время начала акции
    public function setDiscountFromAt($value){
        $this->setValueDateTime('discount_from_at',$value);
    }
    public function getDiscountFromAt(){
        return $this->getValue('discount_from_at');
    }

    //Время окончанияя акции
    public function setDiscountToAt($value){
        $this->setValueDateTime('discount_to_at',$value);
    }

    public function getDiscountToAt(){
        return $this->getValue('discount_to_at');
    }

    // Артикул
    public function setArticle($value){
        $this->setValue('article', $value);
    }

    public function getArticle(){
        return $this->getValue('article');
    }

    // Старая цена
    public function setPriceOld($value){
        $this->setValueFloat('price_old', $value);
    }
    public function getPriceOld(){
        return $this->getValueFloat('price_old');
    }

    // Себестоимость
    public function setPriceCost($value){
        $this->setValueFloat('price_cost', $value);
    }
    public function getPriceCost(){
        return $this->getValueFloat('price_cost');
    }

    // Цена
    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    // Есть ли скидка поставленная системой
    public function setSystemIsDiscount($value){
        if (($value === TRUE) || ($value === 1) || ($value === '1')){
            $this->setValue('system_is_discount', 1);
        }else{
            $this->setValue('system_is_discount', 0);
        }
    }

    public function getSystemIsDiscount(){
        return intval($this->getValue('system_is_discount')) === 1;
    }

    // Скидка поставленная системой
    public function setSystemDiscount($value){
        $this->setValue('system_discount', floatval($value));
    }

    public function getSystemDiscount(){
        return floatval($this->getValue('system_discount'));
    }

    // ID скидки
    public function setSystemShopDiscountID($value){
        $this->setValue('system_shop_discount_id', intval($value));
    }

    public function getSystemShopDiscountID(){
        return intval($this->getValue('system_shop_discount_id'));
    }

    // ID акции
    public function setSystemShopActionID($value){
        $this->setValue('system_shop_action_id', intval($value));
    }

    public function getSystemShopActionID(){
        return intval($this->getValue('system_shop_action_id'));
    }

    // Есть ли акция поставленная системой
    public function setSystemIsAction($value){
        if (($value === TRUE) || ($value === 1) || ($value === '1')){
            $this->setValue('system_is_action', 1);
        }else{
            $this->setValue('system_is_action', 0);
        }
    }

    public function getSystemIsAction(){
        return intval($this->getValue('system_is_action')) === 1;
    }

    // Скидка в виде процента
    public function setSystemIsPercent($value){
        if (($value === TRUE) || ($value === 1) || ($value === '1')){
            $this->setValue('system_is_percent', 1);
        }else{
            $this->setValue('system_is_percent', 0);
        }
    }

    public function getSystemIsPercent(){
        return intval($this->getValue('system_is_percent')) === 1;
    }

    // Скидка
    public function setDiscount($value){
        $this->setValue('discount', floatval($value));
    }

    public function getDiscount(){
        return floatval($this->getValue('discount'));
    }

    // Скидка в виде процента
    public function setIsPercent($value){
        $this->setValueBool('is_percent', $value);
    }
    public function getIsPercent(){
        return $this->getValueBool('is_percent');
    }

    // Группа ли
    public function setIsGroup($value){
        $this->setValueBool('is_group', $value);
    }
    public function getIsGroup(){
        return $this->getValueBool('is_group');
    }

    // Есть ли в наличии
    public function setIsInStock($value){
        $this->getValueBool('is_in_stock', $value);
    }
    public function getIsInStock(){
        return $this->getValueBool('is_in_stock');
    }

	// Итоговая скидка
	public function getFinalDiscount(){
		$discount = $this->getSystemDiscount();
		if ($discount <= 0){
			$discount = $this->getDiscount();
		}
		
		return $discount;
	}
	
	// Итоговая цена
	public function getFinalPrice(){
		$discount = $this->getFinalDiscount();
	
		$price = $this->getPrice();
		if ($discount > 0){
			$price = round($price/100*(100-$discount), 2);
		}
		
		return $price;
	}
}
