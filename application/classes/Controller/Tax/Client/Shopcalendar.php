<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopCalendar extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopcalendar';
        $this->tableID = Model_Tax_Shop_Calendar::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Calendar::TABLE_NAME;
        $this->objectName = 'calendar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopcalendar/index';

        $this->_putInMain('/main/_shop/calendar/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopcalendar/json';

        $params = array_merge($_POST, $_GET);
        if (key_exists('start', $params)) {
            $params['date_from'] =  $params['start'];
        }
        if (key_exists('end', $params)) {
            $params['date_to'] =  $params['end'];
        }
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Request_Tax_Shop_Calendar::findShopCalendarIDs($this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE);

        $fields = Request_RequestParams::getParam('_fields');
        if(!is_array($fields)){
            if($fields != '*'){
                $fields = array($fields);
            }
        }

        $result = array();
        if($fields == '*'){
            foreach ($ids->childs as $child) {
                $result[] = array_merge(
                    $child->values,
                    array(
                        'id' => $child->id,
                        'title' => $child->values['name'],
                        'start' => $child->values['date'],
                        'end' => $child->values['date'],
                    )
                );
            }
        }elseif(!empty($fields)) {
            foreach ($ids->childs as $child) {
                $values = array(
                    'id' => $child->id,
                    'title' => $child->values['name'],
                    'start' => $child->values['date'],
                    'end' => $child->values['date'],

                );
                if ($child->values['is_holiday']){
                    $values['className'] = 'ks-holiday';
                }else{
                    $values['className'] = 'ks-day-off';
                }
                foreach ($fields as $field) {
                    if (key_exists($field, $child->values)) {
                        $values[$field] = $child->values[$field];
                    }
                }

                $result[] = $values;
            }
        }

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(json_encode(array('total' => $this->_sitePageData->countRecord, 'rows' => $result)));
        }else{
            $this->response->body(json_encode($result));
        }
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopcalendar/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/calendar/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/calendar/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Calendar(),
            '_shop/calendar/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/calendar/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopcalendar/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/calendar/one/edit',
            )
        );

        // id записи
        $shopCalendarID = Request_RequestParams::getParamInt('id');
        if ($shopCalendarID === NULL) {
            throw new HTTP_Exception_404('Calendar not is found!');
        }else {
            $model = new Model_Tax_Shop_Calendar();
            if (! $this->dublicateObjectLanguage($model, $shopCalendarID)) {
                throw new HTTP_Exception_404('Calendar not is found!');
            }
        }
        $model->dbGetElements($this->_sitePageData->shopID, array('bank_id'));

        // получаем данные
        $data = View_View::find('DB_Tax_Shop_Calendar', $this->_sitePageData->shopID, "_shop/calendar/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCalendarID), array('bank_id'));

        $this->response->body($data);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopcalendar/save';

        $result = Api_Tax_Shop_Calendar::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopcalendar/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopcalendar/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }
}
