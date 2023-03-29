<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Unit extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_units';
	const TABLE_ID = 242;

	public function __construct(){
		parent::__construct(
			array(
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
        $validation->rule('name_1c', 'max_length', array(':value', 250));
        $this->isValidationFieldStr('code_esf', $validation, 10);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setName($value){
        parent::setName($value);
        $this->setNames($value);
    }

    public function setCodeESF($value){
        $this->setValue('code_esf', $value);
    }
    public function getCodeESF(){
        return $this->getValue('code_esf');
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

    /**
     * получение записи из бд по id
     * @param $id
     * @param int $languageID
     * @param int $languageIDDefault
     * @param int $shopID
     * @return bool|void
     */
    function dbGet($id, $languageID = 0, $languageIDDefault = 0, $shopID = 0)
    {
        $id = intval($id);
        if ($id < 1) {
            return FALSE;
        }
        if($this->isTranslate !== TRUE){
            $languageID = 0;
            $languageIDDefault = 0;
        }

        $this->_isDBDriver();
        return $this->getDBDriver()->getObject($id, $this, $languageID, $languageIDDefault, 0);
    }
}
