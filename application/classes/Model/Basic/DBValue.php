<?php defined('SYSPATH') or die('No direct script access.');

class Model_Basic_DBValue extends Model_Basic_Files
{

	// добавлять поля создания записи
	public $isAddCreated = TRUE;

	// добавлять поля изменения записи
	public $isAddUpdated = TRUE;

	// добавлять поля UUID записи
	public $isAddUUID = FALSE;

	public function __construct(array $overallLanguageFields, $tableName, $tableID, $isTranslate = TRUE)
	{
        array_push($overallLanguageFields,
            'is_public',
            'is_block',
            'uuid',
            'create_user_id',
            'update_user_id',
            'delete_user_id',
            'is_delete',
            'created_at',
            'updated_at',
            'deleted_at'
        );

		parent::__construct($overallLanguageFields, $tableName, $tableID, $isTranslate);

		$this->setIsDelete(false);
        $this->setIsPublic(true);
	}

    /**
     * Изменен ли список значений
     * Возвращает true/false
     */
    public function isEdit()
    {
        return ($this->globalID < 1) || ($this->id < 1) || parent::isEdit();
    }

    public function _GUID()
	{
		if (function_exists('com_create_guid') === TRUE) {
			return trim(com_create_guid(), '{}');
		}

		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	/**
	 * Получение данных для вспомогательных элементов из базы данных
	 * и добавление его в массив
	 */
	public function dbGetElements($shopID = 0, $elements = NULL){
		if(is_array($elements) && $elements !== NULL) {
			foreach ($elements as $element) {
				switch ($element) {
					case 'update_user_id':
						$this->_dbGetElement($this->getUpdateUserID(), 'update_user_id', new Model_User());
						break;
					case 'create_user_id':
						$this->_dbGetElement($this->getCreateUserID(), 'create_user_id', new Model_User());
						break;
					case 'delete_user_id':
						$this->_dbGetElement($this->getDeleteUserID(), 'delete_user_id', new Model_User());
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
	protected function _validationFields(Validation $validation, array &$errorFields)
	{
		$validation->rule('is_public', 'range', array(':value', 0, 1))
			->rule('is_public', 'max_length', array(':value', 1))
			->rule('is_block', 'range', array(':value', 0, 1))
			->rule('is_block', 'max_length', array(':value', 1))
			->rule('uuid', 'max_length', array(':value', 38))
			->rule('create_user_id', 'max_length', array(':value', 11))
			->rule('update_user_id', 'max_length', array(':value', 11))
			->rule('delete_user_id', 'max_length', array(':value', 11))
			->rule('is_delete', 'range', array(':value', 0, 1))
			->rule('is_delete', 'max_length', array(':value', 1));

		if ($this->isFindFieldAndIsEdit('is_public')) {
			$validation->rule('is_public', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('is_block')) {
			$validation->rule('is_block', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('create_user_id')) {
			$validation->rule('create_user_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('update_user_id')) {
			$validation->rule('update_user_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('delete_user_id')) {
			$validation->rule('delete_user_id', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('is_delete')) {
			$validation->rule('is_delete', 'digit');
		}

		if ($this->isFindFieldAndIsEdit('created_at')) {
			$validation->rule('created_at', 'date');
		}

		if ($this->isFindFieldAndIsEdit('updated_at')) {
			$validation->rule('updated_at', 'date');
		}

		if ($this->isFindFieldAndIsEdit('deleted_at')) {
			$validation->rule('deleted_at', 'date');
		}

		return parent::_validationFields($validation, $errorFields);
	}

	// Опубликована ли запись
	public function setIsPublic($value){
		$this->setValueBool('is_public', $value);
	}
	public function getIsPublic(){
		return $this->getValueBool('is_public');
	}

	// Заблокированная ли запись
	public function setIsBlock($value){
		$this->setValueBool('is_block', $value);
	}
	public function getIsBlock(){
		return $this->getValueBool('is_block');
	}

	// Уникальный идентификатор записи
	public function setUUID($value)
	{
		if (($this->isAddUUID === TRUE)) {
			$this->setValue('uuid', $value);
		}
	}

	public function getUUID()
	{
		return $this->getValue('uuid');
	}

	// Кто создал эту запись
	public function setCreateUserID($value)
	{
		if (($this->isAddCreated === TRUE)) {
			$this->setValueInt('create_user_id', $value);
		}
	}

	public function getCreateUserID()
	{
		return $this->getValueInt('create_user_id');
	}

	// Кто отредактировал эту запись
	public function setUpdateUserID($value)
	{
        if (($this->isAddUpdated === TRUE)) {
            $this->setValueInt('update_user_id', $value);
        }
	}

	public function getUpdateUserID()
	{
		return intval($this->getValue('update_user_id'));
	}

	// Дата создание записи
	public function setCreatedAt($value)
	{
		if (($this->isAddCreated === TRUE)) {
			$this->setValueDateTime('created_at', $value);
		}
	}

	public function getCreatedAt()
	{
		return $this->getValueDateTime('created_at');
	}

	// Дата обновления записи
	public function setUpdatedAt($value)
	{
        if (($this->isAddUpdated === TRUE)) {
            $this->setValueDateTime('updated_at', $value);
        }
	}

	public function getUpdatedAt()
	{
		return $this->getValueDateTime('updated_at');
	}

	// Дата удаления записи
	public function setDeletedAt($value){
		$this->setValueDateTime('deleted_at', $value);
	}
	public function getDeletedAt(){
		return $this->getValueDateTime('deleted_at');
	}

	// Дата удаления записи
	public function setIsDelete($value)
	{
        $this->setValueBool('is_delete', $value);

		if (!$this->getIsDelete()) {
			$this->setDeleteUserID(0);
			$this->setDeletedAt(NULL);
		}
	}

	public function getIsDelete()
	{
		return $this->getValueBool('is_delete');
	}

	// Кто удалил запись
	public function setDeleteUserID($value)
	{
		$this->setValueInt('delete_user_id', $value);
	}

	public function getDeleteUserID()
	{
		return $this->getValueInt('delete_user_id');
	}

	/**
	 * задаем id пользователя редактирующий запись
	 */
	public function setEditUserID($userID, $isCreateUser = TRUE)
	{
		if ((($this->id < 1) || ($isCreateUser)) && ($this->getCreateUserID() == 0)) {
			$this->setCreateUserID($userID);
		}

		$this->setUpdateUserID($userID);
	}

    protected function _preDBSave($languageID, $userID = 0){
        if($userID > 0){
            $this->setEditUserID($userID);
        }elseif(($this->id < 1) && ($this->getUpdateUserID() == 0)){
            $this->setUpdateUserID(0);
        }

        if ($this->isAddUUID && ($this->id < 1) && ($this->getUUID() === '')) {
            $this->setUUID($this->_GUID());
        }

        if ($this->isAddCreated && ($this->id < 1) && ($this->getCreatedAt() == '')) {
            $this->setCreatedAt(date('Y-m-d H:i:s'));
        }

        $this->setUpdatedAt(date('Y-m-d H:i:s'));

        parent::_preDBSave($languageID);
    }

	/**
     * сохранение записи в базу данных
	 */
	public function dbSave($languageID = 0, $userID = 0)
	{
        $this->_preDBSave($languageID, $userID);

		return parent::dbSave($languageID);
	}

    /**
     * Копируем модель
     * @param Model_Basic_BasicObject $model
     * @param $isNew
     */
    public function copy(Model_Basic_BasicObject $model, $isNew)
    {
        if($model instanceof Model_Basic_DBValue){
            $this->isAddCreated = $model->isAddCreated;
            $this->isAddUpdated = $model->isAddUpdated;
            $this->isAddUUID = $model->isAddUUID;
        }

        parent::copy($model, $isNew);
    }
}