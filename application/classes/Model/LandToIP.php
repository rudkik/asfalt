<?php defined('SYSPATH') or die('No direct script access.');

class Model_LandToIP extends Model_Basic_DBValue{

	const TABLE_NAME='ct_land_to_ips';
	const TABLE_ID = 226;

	public function __construct(){
		parent::__construct(
			array(
                'ip_from',
                'ip_to',
                'land_id',
                'land_code',
                'ip_from_int',
                'ip_to_int',
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isTranslate = FALSE;
	}


    /**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

        $this->isValidationFieldInt('ip_from_int', $validation);
        $this->isValidationFieldInt('ip_to_int', $validation);
        $this->isValidationFieldInt('land_id', $validation);

		return $this->_validationFields($validation, $errorFields);
	}

    public function setIPFrom($value){
        $this->setValue('ip_from', $value);

        $arr = explode('.', $value);
        if(count($arr) == 4){
            $this->setIPFromInt(
                $arr[0]
                .Func::addBeginSymbol($arr[1], 0, 3)
                .Func::addBeginSymbol($arr[2], 0, 3)
                .Func::addBeginSymbol($arr[3], 0, 3)
            );
        }
    }
    public function getIPFrom(){
        return $this->getValue('ip_from');
    }

    public function setIPTo($value){
        $this->setValue('ip_to', $value);

        $arr = explode('.', $value);
        if(count($arr) == 4){
            $this->setIPToInt(
                $arr[0]
                .Func::addBeginSymbol($arr[1], 0, 3)
                .Func::addBeginSymbol($arr[2], 0, 3)
                .Func::addBeginSymbol($arr[3], 0, 3)
            );
        }
    }
    public function getIPTo(){
        return $this->getValue('ip_to');
    }

    public function setIPFromInt($value){
        $this->setValueInt('ip_from_int', $value);
    }
    public function getIPFromInt(){
        return $this->getValueInt('ip_from_int');
    }

    public function setIPToInt($value){
        $this->setValueInt('ip_to_int', $value);
    }
    public function getIPToInt(){
        return $this->getValueInt('ip_to_int');
    }

    public function setLandID($value){
        $this->setValueInt('land_id', $value);
    }
    public function getLandID(){
        return $this->getValueInt('land_id');
    }

    public function setLandCode($value){
        $this->setValue('land_code', $value);
    }
    public function getLandCode(){
        return $this->getValue('land_code');
    }
}
