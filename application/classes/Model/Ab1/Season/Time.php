<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Season_Time extends Model_Basic_Name{

	const TABLE_NAME = 'ab_season_times';
	const TABLE_ID = 376;

	public function __construct(){
		parent::__construct(
			array(
			    'season_id',
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

        return $this->_validationFields($validation, $errorFields);
    }

    public function setSeasonID($value){
        $this->setValueInt('season_id', $value);
    }
    public function getSeasonID(){
        return $this->getValueInt('season_id');
    }
}
