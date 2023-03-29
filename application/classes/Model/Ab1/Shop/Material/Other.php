<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Material_Other extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_material_others';
	const TABLE_ID = 217;

	public function __construct(){
		parent::__construct(
			array(),
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
			->rule('unit', 'max_length', array(':value', 250))
			->rule('type_1c', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
    }

	public function setType1C($value){
		$this->setValue('type_1c', $value);
	}
	public function getType1C(){
		return $this->getValue('type_1c');
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

	public function setUnit($value){
		$this->setValue('unit', $value);
	}
	public function getUnit(){
		return $this->getValue('unit');
	}
}
