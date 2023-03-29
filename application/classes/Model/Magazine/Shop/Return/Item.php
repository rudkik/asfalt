<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Return_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_return_items';
	const TABLE_ID = 412;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_supplier_id',
                'shop_return_id',
                'amount',
                'price',
                'quantity',
                'is_esf',
                'esf',
                'is_nds',
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
                    case 'shop_supplier_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_supplier_id', new Model_Magazine_Shop_Supplier());
                        break;
                    case 'shop_return_id':
                        $this->_dbGetElement($this->getShopReturnID(), 'shop_return_id', new Model_Magazine_Shop_Return());
                        break;
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_product_id', new Model_Magazine_Shop_Product(), $shopID);
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
        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_return_id', $validation);
        $this->isValidationFieldInt('shop_supplier_id', $validation);
        $this->isValidationFieldFloat('amount', $validation);
        $this->isValidationFieldFloat('price', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldBool('is_esf', $validation);
        $this->isValidationFieldBool('is_nds', $validation);


        return $this->_validationFields($validation, $errorFields);
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

    public function setNDSPercent($value){
        $this->setValueFloat('nds_percent', $value);
    }
    public function getNDSPercent(){
        return $this->getValueFloat('nds_percent');
    }

    /**
     * Возвращаем сумму без НДС
     * @return float|int
     */
    public function getAmountWithoutNDS(){
        return Api_Tax_NDS::getAmountWithoutNDS($this->getAmount(), $this->getIsNDS());
    }

    /**
     * Возвращем сумму НДС
     * @return float|int
     */
    public function getAmountNDS(){
        return Api_Tax_NDS::getAmountNDS($this->getAmount(), $this->getIsNDS(), $this->getNDSPercent());
    }

    public function setIsNDS($value){
        $this->setValueBool('is_nds', $value);
    }
    public function getIsNDS(){
        return $this->getValueBool('is_nds');
    }

    public function setShopReturnID($value){
        $this->setValueInt('shop_return_id', $value);
    }
    public function getShopReturnID(){
        return $this->getValueInt('shop_return_id');
    }

    public function setShopSupplierID($value){
        $this->setValueInt('shop_supplier_id', $value);
    }
    public function getShopSupplierID(){
        return $this->getValueInt('shop_supplier_id');
    }

    public function setIsESF($value){
        $this->setValueBool('is_esf', $value);
    }
    public function getIsESF(){
        return $this->getValueBool('is_esf');
    }

    // Данные ЭСФ
    public function setESFObject(Helpers_ESF_Unload_Product $value){
        $value->setShopReceiveItemID($this->id);
        $this->setIsESF($value->getQuantity() == $this->getQuantity() && $value->getPrice() == $this->getPrice());
        $this->setNDSPercent($value->getNDSPercent());
        $this->setValueArray('esf', $value->saveInArray());
    }
    public function getESFObject(){
        $result = new Helpers_ESF_Unload_Product();
        $result->loadToArray($this->getValueArray('esf'));
        return $result;
    }

    public function setESFArray(array $value){
        $this->setValueArray('esf', $value);
    }
    public function getESFArray(){
        return $this->getValueArray('esf');
    }

    public function setESF($value){
        $this->setValue('esf', $value);

        if(empty($value)){
            $this->setIsESF(FALSE);
        }
    }
    public function getESF(){
        return $this->getValue('esf');
    }
}
