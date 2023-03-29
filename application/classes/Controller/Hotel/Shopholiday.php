<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopHoliday extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Holiday';
        $this->controllerName = 'shopholiday';
        $this->tableID = Model_Hotel_Shop_Holiday::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Holiday::TABLE_NAME;
        $this->objectName = 'holiday';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopholiday/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/holiday/list/index',
            )
        );

        View_View::find('DB_Hotel_Shop_Holiday', $this->_sitePageData->shopID, "_shop/holiday/list/index",
            "_shop/holiday/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/holiday/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopholiday/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/holiday/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/holiday/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Holiday(),
            '_shop/holiday/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopholiday/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/holiday/one/edit',
            )
        );

        // id записи
        $shopHolidayID = Request_RequestParams::getParamInt('id');
        if ($shopHolidayID === NULL) {
            throw new HTTP_Exception_404('Holiday not is found!');
        }else {
            $model = new Model_Hotel_Shop_Holiday();
            if (! $this->dublicateObjectLanguage($model, $shopHolidayID)) {
                throw new HTTP_Exception_404('Holiday not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Holiday', $this->_sitePageData->shopID, "_shop/holiday/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopHolidayID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopholiday/save';

        $result = Api_Hotel_Shop_Holiday::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shopholiday/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shopholiday/index'
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
