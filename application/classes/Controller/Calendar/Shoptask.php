<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_ShopTask extends Controller_Calendar_BasicCalendar {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoptask';
        $this->tableID = Model_Calendar_Shop_Task::TABLE_ID;
        $this->tableName = Model_Calendar_Shop_Task::TABLE_NAME;
        $this->objectName = 'task';

        parent::__construct($request, $response);
    }

    public function getClient()
    {
        require_once APPPATH . 'vendor/GoogleCalendar/vendor/autoload.php';

        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig(APPPATH . 'vendor/GoogleCalendar/credentials.json');
        $client->setAccessType('online');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = APPPATH . 'vendor/GoogleCalendar/token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }
        return $client;
    }

    public function action_index() {
        if(Request_RequestParams::getParamBoolean('is')) {
            $googleCalendar = new Drivers_Google_Calendar();
            $googleCalendar->auth($this->_sitePageData);



            $calendarID =  $googleCalendar->getCalendarIDByName('KINGSTON');

           echo $calendarID; die;

            printf('Event created: %s\n', $event->htmlLink);
            echo $event->getId();die;
            die;
        }


        if($this->_sitePageData->operation->getShopTableUnitID()){
            self::redirect('/calendar/shoptask/index');
        }

        $this->_sitePageData->url = '/calendar/shoptask/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/list/index',
            )
        );
        $this->_requestShopProducts();
        $this->_requestShopResults();
        $this->_requestShopRubrics();
        $this->_requestShopPartners();

        // получаем список
        View_View::find('DB_Calendar_Shop_Task',
            $this->_sitePageData->shopID, "_shop/task/list/index", "_shop/task/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(
                'shop_product_id' => array('name'),
                'shop_partner_id' => array('name'),
                'shop_rubric_id' => array('name'),
                'shop_result_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/task/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/calendar/shoptask/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/task/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Calendar_Shop_Task(),
            '_shop/task/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/task/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/calendar/shoptask/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/task/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Calendar_Shop_Task();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Task not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Calendar_Shop_Task',
            $this->_sitePageData->shopID, "_shop/task/one/edit", $this->_sitePageData,
            $this->_driverDB,
            array('id' => $id),
            array(
                'shop_product_id',
                'shop_partner_id',
                'shop_rubric_id',
                'shop_result_id',
            )
        );

        $this->_putInMain('/main/_shop/task/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/calendar/shoptask/save';

        $result = Api_Calendar_Shop_Task::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/calendar/shoptask/del';
        $result = Api_Calendar_Shop_Task::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_calc() {
        $params = array_merge(
            $_GET, $_POST,
            Request_RequestParams::setParams(
                array(
                    'sum_cost' => TRUE,
                )
            )
        );
        unset($params['limit_page']);

        // получаем список
        $ids = Request_Calendar_Shop_Task::find(
            $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params
        );

        if(count($ids->childs) > 0){
            $this->response->body($ids->childs[0]->values['cost']);
        }else{
            $this->response->body(0);
        }
    }
}
