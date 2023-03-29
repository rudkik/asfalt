<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Question extends Model_Shop_Basic_Collations{

	const TABLE_NAME="ct_shop_questions";
	const TABLE_ID = 57;

    public function __construct(){
        parent::__construct(
            array(
                'is_answer',
                'answer_at',
                'is_operation',
                'email',
                'answer_user_id',
                'shop_operator_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID,
            TRUE
        );

        $this->isAddCreated = TRUE;
    }

    /**
	 * Проверяем поля на ошибки
	 * @param array $errorFields - массив ошибок
	 * @return boolean
	 */
	public function validationFields(array &$errorFields){
		$validation = new Validation($this->getValues());

		if (($this->id < 1) ||($this->isFindFieldAndIsEdit('text'))){
			$validation->rule('text', 'not_empty');
		}

		$validation->rule('answer_user_id', 'max_length', array(':value', 11))
			->rule('user_name', 'max_length', array(':value', 250))
			->rule('email', 'max_length', array(':value', 100))
			->rule('shop_operator_id', 'max_length', array(':value', 11))
			->rule('answer_text', 'max_length', array(':value', 650000))
			->rule('is_answer', 'max_length', array(':value', 1))
			->rule('is_operation', 'max_length', array(':value', 1));

		if ($this->isFindFieldAndIsEdit('is_answer')){
			$validation->rule('is_answer', 'digit');
		}
		if ($this->isFindFieldAndIsEdit('answer_at')){
			$validation->rule('answer_at', 'date');
		}
		if ($this->isFindFieldAndIsEdit('answer_user_id')){
			$validation->rule('answer_user_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('shop_operator_id')){
			$validation->rule('shop_operator_id', 'digit');
		}
        if ($this->isFindFieldAndIsEdit('is_operation')){
            $validation->rule('is_operation', 'digit');
        }

        return $this->_validationFields($validation, $errorFields);
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
					case 'shop_operator_id':
						$this->_dbGetElement($this->getShopOperatorID(), 'shop_operator_id', new Model_User());
						break;
                    case 'answer_user_id':
                        $this->_dbGetElement($this->getUserID(), 'user_id', new Model_User());
                        break;
				}
			}
		}

		parent::dbGetElements($shopID, $elements);
	}

    // Отвечен ли вопрос
    public function setIsAnswer($value){
        $this->setValueBool('is_answer', $value);
    }
    public function getIsAnswer(){
        return $this->getValueBool('is_answer');
    }

    // Вопрос создан оператором
    public function setIsOperation($value){
        $this->setValueBool('is_operation', $value);
    }
    public function getIsOperation(){
        return $this->getValueBool('is_operation');
    }

    // ID пользователя
    public function setAnswerUserID($value){
        $this->setValueInt('answer_user_id', $value);
    }
    public function getAnswerUserID(){
        return $this->getValueInt('answer_user_id');
    }

    // Имя пользователя
    public function setUserName($value){
        $this->setValue('user_name', $value);
    }
    public function getUserName(){
        return $this->getValue('user_name');
    }

    // Оператор отвечающий на вопрос
    public function setShopOperatorID($value){
        $this->setValueInt('shop_operator_id', $value);
    }
    public function getShopOperatorID(){
        return $this->getValueInt('shop_operator_id');
    }

    // Текст ответа
    public function setAnswerText($value){
        if (empty($value)){
            $this->setAnswerAt(NULL);
            $this->setIsAnswer(FALSE);
            $this->setShopOperatorID(0);
        }else{
            if(Func::_empty($this->getAnswerAt())) {
                $this->setAnswerAt(date('Y-m-d H:i:s'));
            }
            $this->setIsAnswer(TRUE);
        }

        $this->setValue('answer_text', $value);
    }
    public function getAnswerText(){
        return $this->getValue('answer_text');
    }

    // Время ответа
    public function setAnswerAt($value){
        $this->setValueDateTime('answer_at', $value);
    }
    public function getAnswerAt(){
        return $this->getValue('answer_at');
    }

    // e-mail
    public function setEMail($value){
        $this->setValue('email', $value);
    }
    public function getEMail(){
        return $this->getValue('email');
    }
}



