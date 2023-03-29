<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopMaterialRubric extends Controller_Ab1_Abc_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Rubric';
        $this->controllerName = 'shopmaterialrubric';
        $this->tableID = Model_Ab1_Shop_Material_Rubric::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Rubric::TABLE_NAME;
        $this->objectName = 'materialrubric';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/abc/shopmaterialrubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/list/index',
            )
        );
        //$this->_requestShopMaterialRubrics();
        $this->_requestListDB('DB_Ab1_Shop_Material_Rubric');
        // получаем список
        View_View::find('DB_Ab1_Shop_Material_Rubric', $this->_sitePageData->shopMainID, "_shop/material/rubric/list/index", "_shop/material/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000,'limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/material/rubric/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/abc/shopmaterialrubric/list';

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->response->body(View_View::find('DB_Ab1_Shop_Material_Rubric', $this->_sitePageData->shopMainID,
            "_shop/material/rubric/list/list", "_shop/material/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50),array('root_id' => array('name'))));
        $this->_sitePageData->previousShopShablonPath();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/abc/shopmaterialrubric/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/one/new',
            )
        );

        $this->_requestListDB('DB_Ab1_Shop_Material_Rubric');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/material/rubric/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Material_Rubric(),
            '_shop/material/rubric/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/material/rubric/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopmaterialrubric/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/rubric/one/edit',
            )
        );

        // id записи
        $shopMaterialRubricID = Request_RequestParams::getParamInt('id');
        if ($shopMaterialRubricID === NULL) {
            throw new HTTP_Exception_404('Rubric material not is found!');
        } else {
            $model = new Model_Ab1_Shop_Material_Rubric();
            if (!$this->dublicateObjectLanguage($model, $shopMaterialRubricID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Rubric material not is found!');
            }
        }

        $this->_requestListDB('DB_Ab1_Shop_Material_Rubric', $model->getRootID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Material_Rubric', $this->_sitePageData->shopMainID, "_shop/material/rubric/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/material/rubric/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopmaterialrubric/save';

        $result = Api_Ab1_Shop_Material_Rubric::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/abc/shopmaterialrubric/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/abc/shopmaterialrubric/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }
}
