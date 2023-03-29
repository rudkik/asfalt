<?php defined('SYSPATH') or die('No direct script access.');


class Model_Nur_Shop_Task_Group_Item extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'nr_shop_task_group_items';
	const TABLE_ID = 263;

	public function __construct(){
		parent::__construct(
			array(
			    'shop_task_id',
                'shop_task_group_id',
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
                    case 'shop_task_id':
                        $this->_dbGetElement($this->getShopSupplierID(), 'shop_task_id', new Model_Nur_Shop_Task());
                        break;
                    case 'shop_task_group_id':
                        $this->_dbGetElement($this->getShopReceiveID(), 'shop_task_group_id', new Model_Nur_Shop_Task_Group());
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
        $this->isValidationFieldInt('shop_task_group_id', $validation);
        $this->isValidationFieldInt('shop_task_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopTaskID($value){
        $this->setValueInt('shop_task_id', $value);
    }
    public function getShopTaskID(){
        return $this->getValueInt('shop_task_id');
    }

    public function setShopTaskGroupID($value){
        $this->setValueInt('shop_task_group_id', $value);
    }
    public function getShopTaskGroupID(){
        return $this->getValueInt('shop_task_group_id');
    }
}
