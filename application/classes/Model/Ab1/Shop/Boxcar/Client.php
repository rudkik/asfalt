<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Boxcar_Client extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_boxcar_clients';
	const TABLE_ID = 208;

	public function __construct(){
		parent::__construct(
			array(
			    'organization_type_id',
                'kato_id'
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
        $validation->rule('bin', 'max_length', array(':value', 12))
			->rule('address', 'max_length', array(':value', 250))
            ->rule('bik', 'max_length', array(':value', 8))
			->rule('account', 'max_length', array(':value', 250))
			->rule('bank', 'max_length', array(':value', 250))
			->rule('contract', 'max_length', array(':value', 250))
            ->rule('shop_payment_type_id', 'max_length', array(':value', 11))
            ->rule('organization_type_id', 'max_length', array(':value', 11))
            ->rule('kato_id', 'max_length', array(':value', 11))
			->rule('name_1c', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setOrganizationTypeID($value){
        $this->setValueInt('organization_type_id', $value);
    }
    public function getOrganizationTypeID(){
        return $this->getValueInt('organization_type_id');
    }

    public function setKatoID($value){
        $this->setValueInt('kato_id', $value);
    }
    public function getKatoID(){
        return $this->getValueInt('kato_id');
    }

    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }

    public function setBIK($value){
        $this->setValue('bik', $value);
    }
    public function getBIK(){
        return $this->getValue('bik');
    }

    public function setAddress($value){
		$this->setValue('address', $value);
	}
	public function getAddress(){
		return $this->getValue('address');
	}

	public function setAccount($value){
		$this->setValue('account', $value);
	}
	public function getAccount(){
		return $this->getValue('account');
	}

	public function setBank($value){
		$this->setValue('bank', $value);
	}
	public function getBank(){
		return $this->getValue('bank');
	}

	public function setContact($value){
		$this->setValue('contract', $value);
	}
	public function getContact(){
		return $this->getValue('contract');
	}

	public function setShopPaymentTypeID($value){
		$this->setValueInt('shop_payment_type_id', $value);
	}
	public function getShopPaymentTypeID(){
		return $this->getValueInt('shop_payment_type_id');
	}

	public function setName1C($value){
		$this->setValue('name_1c', $value);
	}
	public function getName1C(){
		return $this->getValue('name_1c');
	}
}
