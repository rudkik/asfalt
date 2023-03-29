<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BasicAdmin extends Controller_BasicControler
{
    protected $controllerName = '';
    protected $dbObject = '';
    protected $shopID = -1;
    protected $editAndNewBasicTemplate = '';

    protected $limit = 1000;

    /**
     * Получаем ID магазина для действий
     * @return int
     */
    private function getRecordShopID()
    {
        $shopID = $this->shopID;
        if($shopID < 0){
            $shopID = $this->_sitePageData->shopID;
        }

        return $shopID;
    }

    /**
     * Дублировать запись с заданным языком
     * @param Model_Basic_DBObject $model
     * @param $id
     * @param int $shopID
     * @param bool $isIgnoreIDZero
     * @return bool
     */
    public function dublicateObjectLanguage(Model_Basic_DBObject $model, $id, $shopID = -1, $isIgnoreIDZero = TRUE)
    {
        if(intval($id) < 1){
            return $isIgnoreIDZero;
        }

        if($model->getDBDriver() === NULL){
            $model->setDBDriver($this->_driverDB);
        }

        return Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, $shopID, $isIgnoreIDZero);
    }

    /**
     * Сохранение записи в базу данных
     * @param Model_Basic_DBObject $model
     * @param int $shopID
     * @return int
     */
    public function saveDBObject(Model_Basic_DBObject $model, $shopID = -1)
    {
        if($model->getDBDriver() === NULL){
            $model->setDBDriver($this->_driverDB);
        }

        return Helpers_DB::saveDBObject($model, $this->_sitePageData, $shopID);
    }

    /**
     * Удаление записи в базе данных
     * @param Model_Basic_DBObject $model
     * @param int $languageID
     * @param int $shopID
     */
    public function deleteDBObject(Model_Basic_DBObject $model, $languageID = 0, $shopID = -1)
    {
        if($shopID === -1){
            $shopID = $this->_sitePageData->shopID;
        }

        return $model->dbDelete($this->_sitePageData->userID, $languageID, $shopID);
    }

    /**
     * Восстановение записи в базе данных
     * @param Model_Basic_DBObject $model
     * @param int $languageID
     * @param int $shopID
     */
    public function unDeleteDBObject(Model_Basic_DBObject $model, $languageID = 0, $shopID = -1)
    {
        if($shopID === -1){
            $shopID = $this->_sitePageData->shopID;
        }

        return $model->dbUnDelete($this->_sitePageData->userID, $languageID, $shopID);
    }

    /**
     * Получение списка языков с необходимыми параметрами для других языков
     * @param $url
     * @param bool $isShopID
     */
    public function getLanguagesByShop($url, $isShopID = TRUE)
    {
        if($isShopID){
            if(empty($url)){
                $url = '?shop_id='.$this->_sitePageData->shopID;
            }else{
                $url .= '&shop_id='.$this->_sitePageData->shopID;
            }
        }

        if(empty($url)){
            $url = '?';
        }

        // получаем языки перевода
        if($this->_sitePageData->shopID > 0){
            $languageIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'language_ids', NULL);
            if (is_array($languageIDs) && (! empty($languageIDs))) {
                $params = Request_RequestParams::setParams(
                    array(
                        'id' => $languageIDs,
                        'url' => $this->_sitePageData->url . $url,
                    )
                );
                View_View::find('DB_Language',
                    $this->_sitePageData->shopMainID,
                    'language/list/translate', 'language/one/translate',
                    $this->_sitePageData, $this->_driverDB, $params
                );
            }else{
                $params = Request_RequestParams::setParams(
                    array(
                        'url' => $this->_sitePageData->url . $url,
                    )
                );
                View_View::findAll('DB_Language', $this->_sitePageData->shopMainID,
                    'language/list/translate', 'language/one/translate',
                    $this->_sitePageData, $this->_driverDB, $params
                );
            }
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'url' => $this->_sitePageData->url . $url,
                )
            );
            View_View::findAll('DB_Language', $this->_sitePageData->shopID,
                'language/list/translate', 'language/one/translate',
                $this->_sitePageData, $this->_driverDB, $params
            );
        }

        $this->_sitePageData->globalDatas['view::language/list/translate'] = '^#@view::language/list/translate@#^';
    }

    /**
     * Задание изменяемых параметров для замены в документе
     * @param array $keys
     */
    public function _setGlobalDatas(array $keys){
        $this->_sitePageData->addKeysInGlobalDatas($keys);
    }

    /**
     * Сохранить данные в файл
     * @param $shopID
     * @param MyArray $ids
     * @param Model_Basic_LanguageObject $model
     * @param $viewObjects
     * @param $viewObject
     * @param $typeFile
     * @param null $elements
     * @param string $fileName
     */
    protected function _saveFile($shopID, MyArray $ids, Model_Basic_LanguageObject $model, $viewObjects, $viewObject, $typeFile, $elements = NULL,
                                 $fileName = '')
    {
        $typeFile = mb_strtolower($typeFile);
        switch ($typeFile) {
            case 'xls':
                break;
            case 'xml':
                break;
            default:
                $typeFile = 'txt';
        }

        if(empty($fileName)){
            $fileName = $typeFile;
        }

        $datas = Helpers_View::getViewObjects($ids, $model,
            $viewObjects."/save/".$fileName, $viewObject."/save/".$fileName, $this->_sitePageData, $this->_driverDB, $shopID, TRUE, $elements);

        switch ($typeFile){
            case 'xls':
                $datas = '<?xml version="1.0"?>'."\r\n".'<?mso-application progid="Excel.Sheet"?>'.$datas;
                header('Content-Description: File Transfer');
                header('Content-Type: application/excel');
                header('Content-Disposition: filename=save.xls');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . strlen($datas));
                break;
            case 'xml':
                header('Content-Description: File Transfer');
                header('Content-Type: text/xml');
                header('Content-Disposition: filename=save.xml');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . strlen($datas));
                break;
            default:
                header('Content-Description: File Transfer');
                header('Content-Type: text/plain');
                header('Content-Disposition: filename=save.txt');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . strlen($datas));
        }

        echo $datas;
        exit;
    }

    /**
     * Список записей
     * @param null $elements
     * @param array $params
     * @param int $shopID
     * @param string $file
     */
    public function _actionIndex($elements = null, $params = array(), $shopID = -1, $file = 'index', $mainShablonPath = '') {
        $viewPath = DB_Basic::getViewPath($this->dbObject);

        if($shopID == -1){
            $shopID = $this->getRecordShopID();
        }

        $limit = intval(Request_RequestParams::getParamInt('limit'));
        if($limit < 1){
            $limit = $this->limit;
        }

        // получаем список
        $this->_sitePageData->newShopShablonPath($mainShablonPath);
        View_View::find(
            $this->dbObject, $shopID,
            $viewPath . 'list/' . $file, $viewPath . 'one/' . $file,
            $this->_sitePageData, $this->_driverDB,
            array_merge(
                array(
                    'limit_page' => 25,
                    'limit' => $limit,
                ),
                Request_RequestParams::setParams($params, false)
            ),
            $elements
        );

        $this->_sitePageData->previousShopShablonPath();


        $this->_putInMain('/main/' . $viewPath . $file, $mainShablonPath);
    }

    /**
     * Список записей
     */
    public function action_index() {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/index';
        $this->_actionIndex();
    }

    /**
     * Добавления записи
     */
    public function _actionNew(){
        $viewPath = DB_Basic::getViewPath($this->dbObject);

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);

        // выводим связанные записи 1коМногим
        foreach ($this->dbObject::ITEMS as $name => $field) {
            if(!Arr::path($field, 'is_view', false)){
                continue;
            }

            $viewItemPath = DB_Basic::getViewPath($field['table']);

            if(!key_exists('view::' . $viewItemPath . 'list/index', $this->_sitePageData->replaceDatas)) {
                Helpers_View::getViews(
                    $viewItemPath . 'list/index', $viewItemPath . 'one/index',
                    $this->_sitePageData, $this->_driverDB
                );
            }
        }

        Helpers_View::getView(
            $viewPath . 'one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/' . $viewPath . 'new');
    }

    /**
     * Добавления записи
     */
    public function action_new()    {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/new';
        $this->_actionNew();
    }

    /**
     * Редактирование записи
     * @param $model
     * @param $shopID
     * @throws Exception
     */
    public function _actionEdit($model, $shopID)
    {
        $id = $model->id;

        $viewPath = DB_Basic::getViewPath($this->dbObject);

        // получаем данные
        $ids = new MyArray();
        $ids->setValues($model, $this->_sitePageData);
        $ids->setIsFind(true);

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);

        // выводим связанные записи 1коМногим
        foreach ($this->dbObject::ITEMS as $name => $field) {
            if(!Arr::path($field, 'is_view', false)){
                continue;
            }

            $params = Request_RequestParams::setParams(
                array(
                    $field['field_id'] => $id,
                    'sort_by' => array(
                        'created_at' => 'asc'
                    ),
                )
            );

            $viewItemPath = DB_Basic::getViewPath($field['table']);
            if(!key_exists('view::' . $viewItemPath . 'list/index', $this->_sitePageData->replaceDatas)) {
                View_View::find(
                    $field['table'], $shopID,
                    $viewItemPath . 'list/index', $viewItemPath . 'one/index',
                    $this->_sitePageData, $this->_driverDB, $params
                );
            }
        }

        $result = Helpers_View::getViewObject(
            $ids, $model, $viewPath . 'one/edit', $this->_sitePageData, $this->_driverDB, $shopID
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::' . $viewPath . 'one/edit',  $result);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/' . $viewPath . 'edit');
    }

    /**
 * Редактирование записи
 */
    public function action_edit()
    {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/edit';

        $shopID = $this->getRecordShopID();

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = DB_Basic::createModel($this->dbObject);
        if (! $this->dublicateObjectLanguage($model, $id, $shopID, false)) {
            throw new HTTP_Exception_404('Object id="' . $id . '" "' . $this->dbObject . '" not is found!');
        }

        $this->_actionEdit($model, $shopID);
    }

    /**
     * Сохранение записи полученной из HTML-формы
     */
    public function action_save()
    {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/save';

        $result = DB_Basic::save($this->dbObject, $this->getRecordShopID(), $this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Удаление записи из базы данных
     */
    public function action_del()
    {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/del';

        $result = array('error' => !DB_Basic::delete($this->dbObject, $this->getRecordShopID(), $this->_sitePageData, $this->_driverDB));

        $this->response->body(Json::json_encode($result));
    }

    /**
     * Получаем JSON списка записей
     * @param int $shopID
     * @param array $params
     * @param array $elements
     * @param int $limit
     * @return array
     */
    protected function getJSONList($shopID = -1, array $params = array(), array $elements = array(), $limit = 5000) {
        $params = array_merge($params, $_POST, $_GET);
        if ((key_exists('offset', $params)) && (intval($params['offset']) > 0)) {
            $params['page'] =  round($params['offset'] / $params['limit']) + 1;
        }
        if ((key_exists('sort', $params)) ) {
            $params['sort_by'] = array('value' => array($params['sort'] => Arr::path($params, 'order', 'asc')));
        }
        if ((key_exists('limit', $params)) ) {
            $params['limit_page'] = intval($params['limit']);
            unset($params['limit']);
        }else{
            $params['limit_page'] = 25;
        }
        unset($params['order']);
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        if($shopID == -1){
            $shopID = $this->_sitePageData->shopID;
        }

        // получаем список
        $ids = Request_Request::find(
            $this->dbObject, $shopID, $this->_sitePageData, $this->_driverDB, $params, $limit, TRUE, $elements
        );

        $fields = Request_RequestParams::getParam('_fields');
        if(!is_array($fields)){
            if($fields != '*'){
                $fields = array($fields);
            }
        }

        $model = DB_Basic::createModel($this->dbObject, $this->_driverDB);

        $result = array();
        if($fields == '*'){
            foreach ($ids->childs as $child) {
                $result[] = $child->values;
            }
        }elseif(!empty($fields)) {
            $elementsFields = array();
            if(!empty($elements)) {
                foreach ($elements as $key => $values) {
                    if (!is_array($values)) {
                        continue;
                    }
                    foreach ($values as $value) {
                        if (is_array($value)) {
                            $value = Json::json_encode($value);
                        }
                        $elementsFields[substr($key, 0, -2) . $value] = array(
                            'id' => $key,
                            'name' => $value,
                        );
                    }
                }
            }

            foreach ($ids->childs as $child) {
                $child->setModel($model);
                $child->setValues($model, $this->_sitePageData);

                $values = array('id' => $child->id);
                foreach ($fields as $field) {
                    if (key_exists($field, $child->values)) {
                        $values[$field] = $child->values[$field];
                    }elseif (key_exists($field, $elementsFields)){
                        $values[$field] = $child->getElementValue($elementsFields[$field]['id'], $elementsFields[$field]['name']);
                    }else{
                        $values[$field] = Arr::path($child->values, $field, '');
                    }
                }

                $result[] = $values;
            }
        }

        return $result;
    }

    /**
     * Получаем JSON списка записей и выводим их
     * @param int $shopID
     * @param array $params
     * @param array $elements
     * @param int $limit
     */
    protected function _getJSONList($shopID = -1, array $params = array(), array $elements = array(), $limit = 5000) {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/json';

        $result = $this->getJSONList($shopID, $params, $elements, $limit);

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(Json::json_encode(array('total' => $this->_sitePageData->countRecord, 'rows' => $result)));
        }else{
            $this->response->body(Json::json_encode($result));
        }
    }

    /**
     * Получаем JSON списка записей
     */
    public function action_json() {
        $this->_getJSONList(
            $this->_sitePageData->shopID,
            array(),
            Request_RequestParams::setParams(
                array(
                    'sort_by' => array('name' => 'asc')
                )
            )
        );
    }

    /**
     * Клонирование записи
     */
    public function action_clone(){
        $this->action_edit();
    }
}