<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Delivery extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_deliveries';
	const TABLE_ID = 147;

	public function __construct(){
		parent::__construct(
			array(
			    'delivery_type_id',
                'min_quantity',
                'km',
                'shop_delivery_group_id',
                'shop_product_rubric_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('name_1c', 'max_length', array(':value', 250))
			->rule('name_site', 'max_length', array(':value', 250))
            ->rule('price', 'max_length', array(':value', 14))
            ->rule('min_quantity', 'max_length', array(':value', 12))
            ->rule('km', 'max_length', array(':value', 12))
            ->rule('delivery_type_id', 'max_length', array(':value', 11));
        $this->isValidationFieldInt('shop_delivery_group_id', $validation);
        $this->isValidationFieldInt('shop_product_rubric_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setMinQuantity($value){
        $this->setValueFloat('min_quantity', $value);
    }
    public function getMinQuantity(){
        return $this->getValueFloat('min_quantity');
    }

    public function setDeliveryTypeID($value){
        $this->setValueInt('delivery_type_id', $value);
    }
    public function getDeliveryTypeID(){
        return $this->getValueInt('delivery_type_id');
    }

    public function setShopDeliveryGroupID($value){
        $this->setValueInt('shop_delivery_group_id', $value);
    }
    public function getShopDeliveryGroupID(){
        return $this->getValueInt('shop_delivery_group_id');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setName1C($value){
		$this->setValue('name_1c', $value);
	}
	public function getName1C(){
		return $this->getValue('name_1c');
	}

	public function setNameSite($value){
		$this->setValue('name_site', $value);
	}
	public function getNameSite(){
		return $this->getValue('name_site');
	}

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setKm($value){
        $this->setValueFloat('km', $value);
    }
    public function getKm(){
        return $this->getValueFloat('km');
    }
}
