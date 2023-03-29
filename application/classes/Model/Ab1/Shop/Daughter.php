<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Daughter extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'ab_shop_daughters';
	const TABLE_ID = 78;

	public function __construct(){
		parent::__construct(
			array(
                'daughter_weight_id',
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
			->rule('name_site', 'max_length', array(':value', 250));

        $this->isValidationFieldInt('daughter_weight_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDaughterWeightID($value){
        $this->setValueInt('daughter_weight_id', $value);
    }
    public function getDaughterWeightID(){
        return $this->getValueInt('daughter_weight_id');
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
}
