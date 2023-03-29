<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopBallastCrusher extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Crusher';
        $this->controllerName = 'shopballastcrusher';
        $this->tableID = Model_Ab1_Shop_Ballast_Crusher::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Crusher::TABLE_NAME;
        $this->objectName = 'ballastcrusher';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopballastcrusher/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/crusher/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Ballast_Crusher', $this->_sitePageData->shopID,
            "_shop/ballast/crusher/list/index", "_shop/ballast/crusher/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_ballast_driver_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'shop_heap_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/ballast/crusher/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopballastcrusher/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/crusher/one/new',
            )
        );

        $this->_requestShopSubdivisions(null, 0, '');
        $this->_requestShopHeaps(null, 0, '');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/crusher/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Crusher(),
            '_shop/ballast/crusher/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/ballast/crusher/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopballastcrusher/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/crusher/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Crusher();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, -1, FALSE)) {
            throw new HTTP_Exception_404('Crusher not is found!');
        }

        $this->_requestShopSubdivisions($model->getShopSubdivisionID(), 0, '');
        $this->_requestShopHeaps($model->getShopHeapID(), 0, '');

        // получаем данные
        View_View::findOne(
            'DB_Ab1_Shop_Ballast_Crusher', $this->_sitePageData->shopID,
            "_shop/ballast/crusher/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID)
        );

        $this->_putInMain('/main/_shop/ballast/crusher/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopballastcrusher/save';

        $result = Api_Ab1_Shop_Ballast_Crusher::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}
