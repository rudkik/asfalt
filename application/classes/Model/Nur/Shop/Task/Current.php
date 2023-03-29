<?php defined('SYSPATH') or die('No direct script access.');


class Model_Nur_Shop_Task_Current extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'nr_shop_task_currents';
	const TABLE_ID = 267;

	public function __construct(){
		parent::__construct(
			array(
                'shop_task_id',
                'date_start',
                'date_finish',
                'shop_bookkeeper_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
	}

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

        $this->isValidationFieldInt('shop_task_id', $validation);
        $this->isValidationFieldInt('shop_bookkeeper_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL)
    {
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'shop_bookkeeper_id':
                        $this->_dbGetElement($this->getShopBookkeeperID(), 'shop_bookkeeper_id', new Model_Nur_Shop_Operation(), $shopID);
                        break;
                    case 'shop_task_id':
                        $this->_dbGetElement($this->getShopTaskID(), 'shop_task_id', new Model_Nur_Shop_Task(), $shopID);
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

    public function setShopTaskID($value){
        $this->setValueInt('shop_task_id', $value);
    }
    public function getShopTaskID(){
        return $this->getValueInt('shop_task_id');
    }

    public function setShopBookkeeperID($value){
        $this->setValueInt('shop_bookkeeper_id', $value);
    }
    public function getShopBookkeeperID(){
        return $this->getValueInt('shop_bookkeeper_id');
    }

    public function setDateStart($value){
        $this->setValueDateTime('date_start', $value);
    }
    public function getDateStart(){
        return $this->getValueDateTime('date_start');
    }

    public function setDateFinish($value){
        $this->setValueDateTime('date_finish', $value);
    }
    public function getDateFinish(){
        return $this->getValueDateTime('date_finish');
    }

    public function setDateFrom($value){
        $this->setValueDateTime('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDateTime('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }
}
