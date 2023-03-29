<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Invoice_Proforma_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_invoice_proforma_items';
	const TABLE_ID = 165;

	public function __construct(){
		parent::__construct(
			array(
                'shop_contractor_id',
                'shop_invoice_proforma_id',
                'shop_product_id',
                'amount',
                'price',
                'quantity',
                'unit_id',
                'nds',
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
        $validation->rule('shop_contractor_id', 'max_length', array(':value', 11))
            ->rule('shop_invoice_proforma_id', 'max_length', array(':value', 11))
            ->rule('shop_product_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('quantity', 'max_length', array(':value', 12))
            ->rule('nds', 'max_length', array(':value', 5))
            ->rule('unit_name', 'max_length', array(':value', 250))
            ->rule('unit_id', 'max_length', array(':value', 11));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopContractorID($value){
        $this->setValueInt('shop_contractor_id', $value);
    }
    public function getShopContractorID(){
        return $this->getValueInt('shop_contractor_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopInvoiceProformaID($value){
        $this->setValueInt('shop_invoice_proforma_id', $value);
    }
    public function findOneID(){
        return $this->getValueInt('shop_invoice_proforma_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setUnitID($value){
        $this->setValueInt('unit_id', $value);
    }
    public function getUnitID(){
        return $this->getValueInt('unit_id');
    }

    public function setUnitName($value){
        $this->setValue('unit_name', $value);
    }
    public function getUnitName(){
        return $this->getValue('unit_name');
    }

    public function setNDS($value){
        $this->setValueFloat('nds', $value);
    }
    public function getNDS(){
        return $this->getValueFloat('nds');
    }
}
