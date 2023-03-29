<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Invoice_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_invoice_items';
	const TABLE_ID = 284;

	public function __construct(){
		parent::__construct(
			array(
                'shop_production_id',
                'shop_product_id',
                'shop_invoice_id',
                'amount',
                'price',
                'quantity',
                'is_esf',
                'shop_realization_item_id',
                'shop_realization_return_item_id',
                'esf_quantity'
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
		if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopProductionID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
                        break;
                    case 'shop_invoice_id':
                        $this->_dbGetElement($this->getShopInvoiceID(), 'shop_invoice_id', new Model_Magazine_Shop_Invoice());
                        break;
                    case 'shop_realization_item_id':
                        $this->_dbGetElement($this->getShopRealizationItemID(), 'shop_realization_item_id', new Model_Magazine_Shop_Realization_Item(), $shopID);
                        break;
                    case 'shop_realization_return_item_id':
                        $this->_dbGetElement($this->getShopRealizationReturnItemID(), 'shop_realization_return_item_id', new Model_Magazine_Shop_Realization_Return_Item(), $shopID);
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
        $this->isValidationFieldInt('shop_production_id', $validation);
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_invoice_id', $validation);
        $this->isValidationFieldInt('shop_realization_item_id', $validation);
        $this->isValidationFieldInt('shop_realization_return_item_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldFloat('esf_quantity', $validation);
        $this->isValidationFieldBool('is_esf', $validation);

        return $this->_validationFields($validation, $errorFields);
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
            // $arr['esf'] = $this->getESFArray();
        }

        return $arr;
    }

    public function setShopProductionID($value){
        $this->setValueInt('shop_production_id', $value);
    }
    public function getShopProductionID(){
        return $this->getValueInt('shop_production_id');
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

    public function setESFQuantity($value){
        $this->setValueFloat('esf_quantity', round($value, 3));
    }
    public function getESFQuantity(){
        return $this->getValueFloat('esf_quantity');
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

    public function setShopInvoiceID($value){
        $this->setValueInt('shop_invoice_id', $value);
    }
    public function getShopInvoiceID(){
        return $this->getValueInt('shop_invoice_id');
    }

    public function setShopRealizationItemID($value){
        $this->setValueInt('shop_realization_item_id', $value);
    }
    public function getShopRealizationItemID(){
        return $this->getValueInt('shop_realization_item_id');
    }

    public function setShopRealizationReturnItemID($value){
        $this->setValueInt('shop_realization_return_item_id', $value);
    }
    public function getShopRealizationReturnItemID(){
        return $this->getValueInt('shop_realization_return_item_id');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }
}
