<?php defined('SYSPATH') or die('No direct script access.');

class Model_OrganizationType extends Model_Basic_Name{

    const ORGANIZATION_TYPE_TOO = 738; // ТОО
    const ORGANIZATION_TYPE_IP = 739; // ИП
    const ORGANIZATION_TYPE_INDIVIDUAL = 740; // Физическое лицо

	const TABLE_NAME='ct_organization_types';
	const TABLE_ID = 83;

	public function __construct(){
		parent::__construct(
			array(
				'land_id',
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
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		$validation->rule('land_id', 'max_length', array(':value', 11));

		if ($this->isFindFieldAndIsEdit('land_id')) {
			$validation->rule('land_id', 'digit');
		}
	
		return $this->_validationFields($validation, $errorFields);
	}

	public function setLandID($value)
	{
		$this->setValueInt('land_id', $value);
	}

	public function getLandID()
	{
		return $this->getValueInt('land_id');
	}
}