<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Move extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_moves';
	const TABLE_ID = 258;

	public function __construct(){
		parent::__construct(
			array(
                'quantity',
                'branch_move_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'branch_move_id':
                        $this->_dbGetElement($this->getBranchMoveID(), 'branch_move_id', new Model_Shop());
                        break;
                }
            }
        }

		return parent::dbGetElements($shopID, $elements);
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldInt('branch_move_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setBranchMoveID($value){
        $this->setValueInt('branch_move_id', $value);
    }
    public function getBranchMoveID(){
        return $this->getValueInt('branch_move_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }
}
