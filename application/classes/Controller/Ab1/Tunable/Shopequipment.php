<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopEquipment extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Equipment';
        $this->controllerName = 'shopequipment';
        $this->tableID = Model_Ab1_Shop_Equipment::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Equipment::TABLE_NAME;
        $this->objectName = 'equipment';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shopequipment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/equipment/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Equipment', $this->_sitePageData->shopMainID, "_shop/equipment/list/index", "_shop/equipment/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/equipment/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shopequipment/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/equipment/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/equipment/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Equipment(),
            '_shop/equipment/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/equipment/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shopequipment/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/equipment/one/edit',
            )
        );

        // id записи
        $shopEquipmentID = Request_RequestParams::getParamInt('id');
        if ($shopEquipmentID === NULL) {
            throw new HTTP_Exception_404('Equipment not is found!');
        }else {
            $model = new Model_Ab1_Shop_Equipment();
            if (! $this->dublicateObjectLanguage($model, $shopEquipmentID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Equipment not is found!');
            }
        }
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Equipment', $this->_sitePageData->shopMainID, "_shop/equipment/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopEquipmentID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/equipment/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shopequipment/save';

        $result = Api_Ab1_Shop_Equipment::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tunable/shopequipment/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tunable/shopequipment/index'
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

    public function action_del()
    {
        $this->_sitePageData->url = '/tunable/shopequipment/del';
        $result = Api_Ab1_Shop_Equipment::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
