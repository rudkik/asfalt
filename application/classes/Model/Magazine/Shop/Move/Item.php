<?php defined('SYSPATH') or die('No direct script access.');


class Model_Magazine_Shop_Move_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'sp_shop_move_items';
	const TABLE_ID = 259;

	public function __construct(){
		parent::__construct(
			array(
			    'branch_move_id',
                'shop_move_id',
                'quantity',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(($elements !== NULL) && (! is_array($elements))){
            foreach($elements as $element){
                switch($element){
                    case 'branch_move_id':
                        $this->_dbGetElement($this->getBrancMoveID(), 'branch_move_id', new Model_Shop);
                        break;
                    case 'shop_move_id':
                        $this->_dbGetElement($this->getShopMoveID(), 'shop_move_id', new Model_Magazine_Shop_Move());
                        break;
                    case 'shop_production_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_production_id', new Model_Magazine_Shop_Production(), $shopID);
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
        $this->isValidationFieldInt('shop_production_id', $validation);
        $this->isValidationFieldInt('shop_move_id', $validation);
        $this->isValidationFieldInt('branch_move_id', $validation);
        $this->isValidationFieldFloat('quantity', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopProductionID($value){
        $this->setValueInt('shop_production_id', $value);
    }
    public function getShopProductionID(){
        return $this->getValueInt('shop_production_id');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setShopMoveID($value){
        $this->setValueInt('shop_move_id', $value);
    }
    public function getShopMoveID(){
        return $this->getValueInt('shop_move_id');
    }

    public function setBranchMoveID($value){
        $this->setValueInt('branch_move_id', $value);
    }
    public function getBranchMoveID(){
        return $this->getValueInt('branch_move_id');
    }
}
