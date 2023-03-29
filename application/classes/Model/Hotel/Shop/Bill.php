<?php defined('SYSPATH') or die('No direct script access.');


class Model_Hotel_Shop_Bill extends Model_Shop_Basic_Bill{

    const TABLE_NAME = 'hc_shop_bills';
    const TABLE_ID = 143;

    public function __construct(){
        parent::__construct(
            array(
                'shop_client_id',
                'paid_type_id',
                'date_to',
                'date_from',
                'discount',
                'is_finish',
                'finish_date',
                'bill_cancel_status_id',
                'bill_cancel_date',
            ),
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
            foreach($elements as $key => $element){
                if(is_array($element)){
                    $element = $key;
                }
                switch($element){
                    case 'shop_client_id':
                        $this->_dbGetElement($this->getShopClientID(), 'shop_client_id', new Model_Hotel_Shop_Client());
                        break;
                    case 'paid_type_id':
                        $this->_dbGetElement($this->getPaidTypeID(), 'paid_type_id', new Model_Tax_PaidType());
                        break;
                    case 'bill_cancel_status_id':
                        $this->_dbGetElement($this->getBillCancelStatusID(), 'bill_cancel_status_id', new Model_Tax_PaidType());
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
        $validation->rule('shop_client_id', 'max_length', array(':value', 11))
            ->rule('paid_type_id', 'max_length', array(':value', 11))
            ->rule('amount', 'max_length', array(':value', 12))
            ->rule('discount', 'max_length', array(':value', 12))
            ->rule('is_finish', 'max_length', array(':value', 1))
            ->rule('paid_amount', 'max_length', array(':value', 12));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setDiscount($value){
        $value = intval($value);
        if($value < 0){
            $value = 0;
        }elseif ($value > 100){
            $value = 100;
        }

        $this->setValueFloat('discount', $value);
        $this->setAmount(round(($this->getAmountItems() + $this->getAmountServices()) / 100 * (100 - $this->getDiscount())));
    }
    public function getDiscount(){
        return $this->getValueFloat('discount');
    }

    public function setShopClientID($value){
        $this->setValueInt('shop_client_id', $value);
    }
    public function getShopClientID(){
        return $this->getValueInt('shop_client_id');
    }

    public function setIsFinish($value){
        $this->setValueBool('is_finish', $value);

        if($this->getIsFinish()){
            if(Func::_empty($this->getFinishDate())){
                $this->setFinishDate($this->getDateTo());
            }
        }else{
            $this->setFinishDate(NULL);
        }
    }
    public function getIsFinish(){
        return $this->getValueBool('is_finish');
    }

    public function setFinishDate($value){
        $this->setValueDateTime('finish_date', $value);
    }
    public function getFinishDate(){
        return $this->getValueDateTime('finish_date');
    }

    public function setPaidTypeID($value){
        $this->setValueInt('paid_type_id', $value);
    }
    public function getPaidTypeID(){
        return $this->getValueInt('paid_type_id');
    }

    public function setBillCancelDate($value){
        $this->setValueDateTime('bill_cancel_date', $value);
    }
    public function getBillCancelDate(){
        return $this->getValueDateTime('bill_cancel_date');
    }

    public function setBillCancelStatusID($value){
        $this->setValueInt('bill_cancel_status_id', $value);

        if ($this->getBillCancelStatusID() > 0){
            if (Func::_empty($this->getBillCancelDate())){
                $this->setBillCancelDate(date('Y-m-d H:i:s'));
            }
        }else{
            $this->setBillCancelDate(NULL);
            $this->setText('');
        }
    }
    public function getBillCancelStatusID(){
        return $this->getValueInt('bill_cancel_status_id');
    }

    public function setAmountItems($value){
        $this->setValueFloat('amount_items', $value);
        $this->setAmount(round(($this->getAmountItems() + $this->getAmountServices()) / 100 * (100 - $this->getDiscount())));
    }
    public function getAmountItems(){
        return $this->getValueFloat('amount_items');
    }

    public function setAmountServices($value){
        $this->setValueFloat('amount_services', $value);
        $this->setAmount(round(($this->getAmountItems() + $this->getAmountServices()) / 100 * (100 - $this->getDiscount())));
    }
    public function getAmountServices(){
        return $this->getValueFloat('amount_services');
    }

    public function setLimitTime($value){
        $this->setValueDateTime('limit_time', $value);
    }
    public function getLimitTime(){
        return $this->getValueDateTime('limit_time');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDateTime('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDateTime('date_to');
    }

    public function setNumber($value){
        $this->setValue('number', $value);
    }
    public function getNumber(){
        return $this->getValue('number');
    }
}
