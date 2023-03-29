<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Production_Rubric extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_production_rubrics';
	const TABLE_ID = 249;

	public function __construct(){
		parent::__construct(
			array(),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'root_id':
                        $this->_dbGetElement($this->getRootID(), 'root_id', new Model_Magazine_Shop_Production_Rubric(), $shopID);
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('root_id', 'max_length', array(':value', 11));
        $this->isValidationFieldStr('name_1c', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

	public function setRootID($value){
		$this->setValueInt('root_id', $value);
	}
	public function getRootID(){
		return $this->getValueInt('root_id');
	}

    // Название
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
