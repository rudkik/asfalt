<?php defined('SYSPATH') or die('No direct script access.');

class Model_City extends Model_Basic_Name{

	const TABLE_NAME='ct_cities';
	const TABLE_ID = 32;

	public function __construct(){
		parent::__construct(
			array(
                'land_id',
                'region_id',
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

		$validation->rule('land_id', 'max_length', array(':value', 11))
            ->rule('region_id', 'max_length', array(':value', 11));

        if ($this->isFindFieldAndIsEdit('land_id')) {
            $validation->rule('land_id', 'digit');
        }
        if ($this->isFindFieldAndIsEdit('region_id')) {
            $validation->rule('region_id', 'digit');
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

    public function setRegionID($value)
    {
        $this->setValueInt('region_id', $value);
    }
    public function getRegionID()
    {
        return $this->getValueInt('region_id');
    }
}