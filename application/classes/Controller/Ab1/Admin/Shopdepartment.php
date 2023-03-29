<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopDepartment extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Department';
        $this->controllerName = 'shopdepartment';
        $this->tableID = Model_Ab1_Shop_Department::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Department::TABLE_NAME;
        $this->objectName = 'department';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/shopdepartment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/department/list/index',
            )
        );


        $ids = Request_Request::find(
            'DB_Ab1_Shop_Department', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => 0), 0, true,
            [
                'shop_department_id' => ['name'],
                'shop_table_rubric_id' => ['name'],
            ]
        );
        $pageOptions = $this->_sitePageData->getPageOptions();

        foreach ($ids->childs as $child){
            if(empty($child->values['contract_interface_ids'])){
                continue;
            }
            /** @var Model_Ab1_Shop_Department $model */
            $model = $child->createModel('DB_Ab1_Shop_Department', $this->_driverDB);

            $interfaces = array();
            foreach ($model->getInterfaceIDsArray() as $interfaceID){
                if($interfaceID > 0){
                    $interfaces[] = $interfaceID;
                }
            }
            if(empty($interfaces)){
                $child->values['contract_interface_ids'] = '';
                continue;
            }

            $interfaceIDs = Request_Request::find(
                'DB_Ab1_Interface', $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'id' => $interfaces,
                    )
                ),
                0, true
            );
            $child->values['contract_interface_ids'] = implode(', ', $interfaceIDs->getChildArrayValue('name'));
        }

        $this->_sitePageData->setPageOptions($pageOptions);
        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_ClientContract_Type(),
            "_shop/department/list/index", "_shop/department/one/index",
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->replaceDatas['view::_shop/department/list/index'] = $result;

        $this->_putInMain('/main/_shop/department/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ab1-admin/shopdepartment/new';
        $this->_actionShopDepartmentNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/shopdepartment/edit';
        $this->_actionShopDepartmentEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/shopdepartment/save';

        $result = Api_Ab1_Shop_Department::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
