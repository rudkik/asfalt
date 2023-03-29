<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_Data extends Controller_BasicControler
{
    /**
     * Получить данные машины
     * @return array|mixed
     */
    public static function getDataCar()
    {
        $result = array('weight' => 0, 'number' => '', 'coefficient' => 0, 'is_test' => false);
        // имя компьютера берем по IP
        $name = self::_getName();
        $result['name'] = $name;

        $data = self::_getData($name);
        if (key_exists($name, $data)){
            $result = $data[$name];
        }

        return $result;
    }

    public function action_get()
    {
        $result = array('weight' => 0, 'number' => '', 'coefficient' => 0);
        // имя компьютера берем по IP
        $name = self::_getName();
        $result['name'] = $name;

        $data = self::_getData($name);
        if (key_exists($name, $data)){
            $result = $data[$name];
        }
        $this->response->body(json_encode(self::getDataCar()));
    }

    public function action_get_car_driver()
    {
        $result = array('weight' => 0, 'number' => '', 'coefficient' => 0);
        // имя компьютера берем по IP
        $name = self::_getName();
        $result['name'] = $name;

        $data = self::_getData($name);
        if (key_exists($name, $data)){
            $result = $data[$name];
        }

       $number = Request_RequestParams::getParamStr('number');
        if(!empty($number)) {
            $ids = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array('name_full' => $number, 'shop_driver_id_from' => 0,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE,
                array('shop_driver_id' => array('name')));
        }else{
            $ids = new MyArray();
        }
        if (count($ids->childs) == 1){
            $result['car'] = array(
                    'shop_transport_company_id' => $ids->childs[0]->values['shop_transport_company_id'],
                    'shop_driver_name' => Arr::path($ids->childs[0]->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''),
                );
        }else{
            $result['car'] = array(
                    'shop_transport_company_id' => 0,
                    'shop_driver_name' => '',
                );
        }

        $this->response->body(json_encode($result));
    }

    public function action_save()
    {
        // имя компьютера берем по IP
        $name = self::_getName();
        $data = self::_getData($name);

        $tmp = Request_RequestParams::getParamStr('weight');
        if ($tmp !== NULL) {
            $data[$name]['weight'] = str_replace(',', '.', $tmp);
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamStr('number');
        if ($tmp !== NULL) {
            $data[$name]['number'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamFloat('coefficient');
        if ($tmp !== NULL) {
            $data[$name]['coefficient'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamStr('action');
        if ($tmp !== NULL) {
            $data[$name]['action'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamStr('type');
        if ($tmp !== NULL) {
            $data[$name]['type'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamInt('id');
        if ($tmp !== NULL) {
            $data[$name]['id'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamInt('table_id');
        if ($tmp !== NULL) {
            $data[$name]['table_id'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamStr('pages');
        if ($tmp !== NULL) {
            $data[$name]['pages'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }
        $tmp = Request_RequestParams::getParamBoolean('is_test');
        if ($tmp !== NULL) {
            $data[$name]['is_test'] = $tmp;
            $data[$name]['date'] = date('Y-m-d H:i:s');
        }

        $this->_setData($name, $data);

        if (key_exists($name, $data)) {
            $data = $data[$name];
            $data['name'] = $name;
        }else{
            $data = array();
        }
        $this->response->body(json_encode($data));
    }

    private static function _getData($name)
    {
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR .'ab1' .DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR .md5($name) . EXT;
        if (file_exists($path)) {
            $data = file_get_contents($path);
            try{
                $data = json_decode($data, TRUE);
                if (! is_array($data)) {
                    $data = array();
                }
            }catch(Exception $e) {
                $data = array();
            }
        } else {
            $data = array();
        }

        return $data;
    }

    private static function _setData($name, $data)
    {
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR .'ab1' .DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR .md5($name) . EXT;
        $html = json_encode($data);
        for($i = 0; $i < 20; $i++){
            $html = $html. '                                 ';
        }

        $file = fopen($path, 'w');
        fwrite($file, $html);
        fclose($file);
    }

    private static function _getName(){
        $result = '';
        if(key_exists('HTTP_CLIENT_IP', $_SERVER)){
            $result = $result.$_SERVER['HTTP_CLIENT_IP'].'_';
        }
        if(key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
            $result = $result.$_SERVER['HTTP_X_FORWARDED_FOR'].'_';
        }
        if(key_exists('REMOTE_ADDR', $_SERVER)){
            $result = $result.$_SERVER['REMOTE_ADDR'].'_';
        }

        return $result;
    }

    public function action_get_car()
    {
        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        if ($shopCarID === NULL) {
            throw new HTTP_Exception_404('Car not is found!');
        }else {
            $tableID = Request_RequestParams::getParamInt('table_id');
            if ($tableID == Model_Ab1_Shop_Move_Car::TABLE_ID){
                $model = new Model_Ab1_Shop_Move_Car();
            }elseif ($tableID == Model_Ab1_Shop_Defect_Car::TABLE_ID){
                $model = new Model_Ab1_Shop_Defect_Car();
            }elseif ($tableID == Model_Ab1_Shop_Lessee_Car::TABLE_ID){
                $model = new Model_Ab1_Shop_Lessee_Car();
            }else{
                $model = new Model_Ab1_Shop_Car();
            }
            $model->setDBDriver($this->_driverDB);
            if (! Helpers_DB::dublicateObjectLanguage($model, $shopCarID, $this->_sitePageData, -1, false)) {
                throw new HTTP_Exception_404('Car not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('shop_payment_id', 'shop_turn_id', 'shop_driver_id',
            'shop_transport_company_id', 'shop_product_id', 'shop_client_id', 'weighted_exit_operation_id', 'cash_operation_id'));

        $this->response->body(json_encode($model->getValues(TRUE, TRUE), JSON_UNESCAPED_UNICODE));
    }

    public function action_get_car_material()
    {
        // id записи
        $shopCarID = Request_RequestParams::getParamInt('id');
        if ($shopCarID === NULL) {
            throw new HTTP_Exception_404('Car to material not is found!');
        }

        $tableID = Request_RequestParams::getParamInt('table_id');
        if ($tableID == Model_Ab1_Shop_Move_Other::TABLE_ID){
            $model = new Model_Ab1_Shop_Move_Other();
        }else {
            $model = new Model_Ab1_Shop_Car_To_Material();
        }
        $model->setDBDriver($this->_driverDB);
        if (! Helpers_DB::dublicateObjectLanguage($model, $shopCarID, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Car not is found!');
        }
        $model->dbGetElements($this->_sitePageData->shopID,
            array(
                'shop_material_other_id',
                'shop_daughter_id',
                'shop_material_id',
                'shop_driver_id',
                'shop_client_material_id',
                'shop_transport_company_id',
                'weighted_operation_id',
                'shop_branch_receiver_id',
                'shop_branch_daughter_id',
                'shop_heap_receiver_id',
                'shop_heap_daughter_id',
                'shop_subdivision_receiver_id',
                'shop_subdivision_daughter_id',
                'shop_move_place_id',
            )
        );

        $result = $model->getValues(TRUE, TRUE);

        if ($tableID == Model_Ab1_Shop_Move_Other::TABLE_ID){
            $result['$elements$']['shop_client_id']['name'] = Arr::path($result,'$elements$.shop_move_place_id.name', '');
            $result['$elements$']['shop_product_id']['name'] = Arr::path($result,'$elements$.shop_material_other_id.name', '');
        }else {
            if($result['quantity'] == 0){
                $result['quantity'] = $model->getQuantityDaughter();

            }
            $result['$elements$']['shop_client_id']['name'] = Arr::path($result,'$elements$.shop_branch_receiver_id.name', '');

            $s = Arr::path($result,'$elements$.shop_subdivision_receiver_id.name', '');
            if(!empty($s)){
                $result['$elements$']['shop_client_id']['name'] = $result['$elements$']['shop_client_id']['name'] . ', ' . $s;
            }
        }

        $this->response->body(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    public function action_get_car_turn()
    {
        $result = array();
        $ids = Request_Request::find('DB_Ab1_Shop_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_exit' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                'shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU,
                    Model_Ab1_Shop_Turn::TURN_CASH_EXIT, Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY))), 0, TRUE);
        foreach ($ids->childs as $child){
            $result[] = $child->values['name'];
        }

        $moveIDs = Request_Request::find('DB_Ab1_Shop_Move_Car', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('is_exit' => 0, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                'shop_turn_id' => array('value' => array(Model_Ab1_Shop_Turn::TURN_WEIGHTED_EXIT, Model_Ab1_Shop_Turn::TURN_ASU,
                    Model_Ab1_Shop_Turn::TURN_CASH_EXIT, Model_Ab1_Shop_Turn::TURN_WEIGHTED_ENTRY))), 0, TRUE);
        foreach ($moveIDs->childs as $child){
            $result[] = $child->values['name'];
        }

        $tareIDs = Request_Request::find('DB_Ab1_Shop_Car_Tare', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            array('is_client' => false, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        foreach ($tareIDs->childs as $child){
            $result[] = $child->values['name'];
        }

        $this->response->body(json_encode($result, JSON_UNESCAPED_UNICODE));
    }

    public function action_loadimage() {

        ini_set('display_errors', 'on');

        if (!ImageFunc::IS_POST() || !$_FILES) {
            ImageFunc::stopAndResponseMessage('error', 'Только POST, FILES');
        }

        $files = ImageFunc::convertFileInformation($_FILES);

        if (!isset($files['file'])) {
            ImageFunc::stopAndResponseMessage('error', 'Файл не загружался');
        }

        $file = $files['file'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            ImageFunc::stopAndResponseMessage('error', ImageFunc::uploadCodeToMessage($file['error']));
        }

        $mimeType = ImageFunc::guessMimeType($file['tmp_name']);
        if (!$mimeType) {
            ImageFunc::stopAndResponseMessage('error', 'Тип файла не распознан.');
        }

        $validMimeType = array('image/png', 'image/jpeg', 'image/gif', 'image/tif', 'image/tiff');
        if (!in_array($mimeType, $validMimeType)) {
            ImageFunc::stopAndResponseMessage('error', 'Загружать можно только png, jpg, tiff.');
        }

        $size = filesize($file['tmp_name']);
        if ($size > 100 * 1024 * 1024) {
            ImageFunc::stopAndResponseMessage('error', 'Файл слишком большой.');
        }

        $uploadDir = DOCROOT . '/tmp_files';
        if (!is_writable($uploadDir)) {
            ImageFunc::stopAndResponseMessage('error', 'Папка для файлов не доступна для записи.');
        }

        $filename = time() . '-' . mt_rand(0000, 9999) . '.' . ImageFunc::guessFileExtension($mimeType);
        if (!move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $filename)) {
            ImageFunc::stopAndResponseMessage('error', 'Файл не был перемещен.');
        }else{
            // имя компьютера берем по IP
            $name = self::_getName();
            
            $data = self::_getData($name);

            $type = Request_RequestParams::getParamStr('type');
            $tmp = Arr::path($data[$name], 'files.'.$type, '');
            if ((!empty($tmp)) && file_exists($uploadDir . '/' .$tmp)){
                unlink($uploadDir . '/' .$tmp);
            }
            $data[$name]['files'][$type] = $filename;
            $data[$name]['date'] = date('Y-m-d H:i:s');
            $this->_setData($name, $data);
        }

        ImageFunc::sendResponse('upload', array('url' => $this->_sitePageData->url.'/tmp_files/' . $filename, 'file' => $filename, 'file_name' => $file['name']));

        #
        # if used php-fpm
        #   * send response (finish request)
        #   * clear old images (created >= 5 minutes ago)
        #
        if (!function_exists('fastcgi_finish_request'))
            exit;

        fastcgi_finish_request();

        ImageFunc::clearOldFiles($uploadDir, '/*.{jpg,png,jpeg}', 5);
    }
    
    public static function getDataFiles()
    {
        // имя компьютера берем по IP
        $name = self::_getName();

        $data = self::_getData($name);
        if (key_exists($name, $data) && key_exists('files', $data[$name])){
            $result = $data[$name]['files'];
            unset($data[$name]['files']);
            self::_setData($name, $data);

            return $result;
        }

        return array();
    }
}