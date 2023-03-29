<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Invoice_Proforma_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_invoice_proforma_items';
	const TABLE_ID = 297;

	public function __construct(){
		parent::__construct(
			array(
                'shop_client_id',
                'shop_client_contract_id',
                'shop_invoice_proforma_id',
                'shop_product_id',
                'shop_product_rubric_id',
                'amount',
                'price',
                'quantity',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
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
                    case 'shop_client_contract_id':
                        $this->_dbGetElement($this->getShopClientContractID(), 'shop_contract_id', new Model_Ab1_Shop_Client_Contract());
                        break;
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Ab1_Shop_Client());
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
            ->rule('shop_invoice_proforma_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('price', 'max_length', array(':value', 12))
            ->rule('quantity', 'max_length', array(':value', 12));

        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_client_contract_id', $validation);

        $this->isValidationFieldInt('shop_product_rubric_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setShopClientContractID($value){
        $this->setValueInt('shop_client_contract_id', $value);
    }
    public function getShopClientContractID(){
        return $this->getValueInt('shop_client_contract_id');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopProductRubricID($value){
        $this->setValueInt('shop_product_rubric_id', $value);
    }
    public function getShopProductRubricID(){
        return $this->getValueInt('shop_product_rubric_id');
    }

    public function setShopInvoiceProformaID($value){
        $this->setValueInt('shop_invoice_proforma_id', $value);
    }
    public function findOneID(){
        return $this->getValueInt('shop_invoice_proforma_id');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', round($value, 0));
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setPrice($value){
        $this->setValueFloat('price', $value);

        $this->setAmount($this->getPrice() * $this->getQuantity());
    }
    public function getPrice(){
        return $this->getValueFloat('price');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);

        $this->setAmount($this->getPrice() * $this->getQuantity());
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
}
