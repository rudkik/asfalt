<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopMaterialRubricMake extends Controller_Ab1_Admin_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Rubric_Make';
        $this->controllerName = 'shopmaterialrubricmake';
        $this->tableID = Model_Ab1_Shop_Material_Rubric_Make::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Rubric_Make::TABLE_NAME;
        $this->objectName = 'materialrubricmake';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/admin/shopmaterialrubricmake/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/make/list/index',
            )
        );
        $this->_requestShopMaterialRubrics();

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Rubric_Make', $this->_sitePageData->shopMainID,
            "_shop/material/rubric/make/list/index", "_shop/material/rubric/make/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/material/rubric/make/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/admin/shopmaterialrubricmake/list';

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->response->body(View_View::find(
            'DB_Ab1_Shop_Material_Rubric_Make', $this->_sitePageData->shopMainID,
            "_shop/material/rubric/make/list/list", "_shop/material/rubric/make/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50))
        );
        $this->_sitePageData->previousShopShablonPath();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ab1-admin/shopmaterialrubricmake/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/make/one/new',
            )
        );

        $this->_requestShopMaterialRubrics();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/material/rubric/make/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Rubric_Make(),
            '_shop/material/rubric/make/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/rubric/make/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/shopmaterialrubricmake/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/make/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Rubric_Make();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Rubric material make not is found!');
        }

        $this->_requestShopMaterialRubrics();

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne(
            'DB_Ab1_Shop_Material_Rubric_Make', $this->_sitePageData->shopMainID,
            "_shop/material/rubric/make/one/edit",
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/material/rubric/make/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/shopmaterialrubricmake/save';

        $result = Api_Ab1_Shop_Material_Rubric_Make::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
