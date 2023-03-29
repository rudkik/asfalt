<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Supplier extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_suppliers';
	const TABLE_ID = 241;

	public function __construct(){
		parent::__construct(
			array(
			    'bik',
                'bin',
                'organization_type_id',
                'is_nds',
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
			->rule('name_1c', 'max_length', array(':value', 250))
			->rule('name_site', 'max_length', array(':value', 250));
        $this->isValidationFieldInt('organization_type_id', $validation);
        $this->isValidationFieldBool('is_nds', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsNDS($value){
        $this->setValueBool('is_nds', $value);
    }
    public function getIsNDS(){
        return $this->getValueBool('is_nds');
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

    public function setAmount($value){
        $this->setValueFloat('amount', $value);
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

	public function setContact($value){
		$this->setValue('contract', $value);
	}
	public function getContact(){
		return $this->getValue('contract');
	}

    public function setName($value){
        parent::setName($value);
        $this->setNames($value);
    }

	public function setName1C($value){
		$this->setValue('name_1c', $value);
        $this->setNames($value);
	}
	public function getName1C(){
		return $this->getValue('name_1c');
	}
	public function setNameSite($value){
		$this->setValue('name_site', $value);
        $this->setNames($value);
	}
	public function getNameSite(){
		return $this->getValue('name_site');
	}

    public function setOrganizationTypeID($value){
        $this->setValueInt('organization_type_id', $value);
    }
    public function getOrganizationTypeID(){
        return $this->getValueInt('organization_type_id');
    }

    public function setNames($name)
    {
        if (Func::_empty($name)) {
            return;
        }

        if (Func::_empty($this->getName())) {
            $this->setName($name);
        }
        if (Func::_empty($this->getNameSite())) {
            $this->setNameSite($name);
        }
        if (Func::_empty($this->getName1C())) {
            $this->setName1C($name);
        }
    }
}
