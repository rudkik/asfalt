<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_WriteOff_Type extends Model_Shop_Table_Basic_Table{

    // возмещение
    const WRITE_OFF_TYPE_REDRESS = 621074;
    // По нормам
    const WRITE_OFF_TYPE_BY_STANDART = 625978;
    // Сверх нормы
    const WRITE_OFF_TYPE_OVER_THE_NORM = 621073;
    // Приемная
    const WRITE_OFF_TYPE_RECEPTION = 616366;

	const TABLE_NAME = 'sp_shop_write_off_types';
	const TABLE_ID = 287;

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
        $validation->rule('name_1c', 'max_length', array(':value', 250));

        return $this->_validationFields($validation, $errorFields);
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

    public function setNames($name)
    {
        if (Func::_empty($name)) {
            return;
        }

        if (Func::_empty($this->getName())) {
            $this->setName($name);
        }
        if (Func::_empty($this->getName1C())) {
            $this->setName1C($name);
        }
    }
}
