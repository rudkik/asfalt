<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pyramid_ShopComing extends Controller_Pyramid_BasicPyramid {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopcoming';
        $this->tableID = Model_Pyramid_Shop_Coming::TABLE_ID;
        $this->tableName = Model_Pyramid_Shop_Coming::TABLE_NAME;
        $this->objectName = 'coming';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/pyramid/shopcoming/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/coming/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Pyramid_Shop_Coming', $this->_sitePageData->shopID, "_shop/coming/list/index",
            "_shop/coming/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/coming/index');
    }

    public function action_json() {
        $this->_actionJSON(
            'Request_Pyramid_Shop_Coming',
            'findShopComingIDs',
            array(
                'currency_id' => array('symbol'),
                'from_shop_client_id' => array('name'),
            ),
            array(
                'to_shop_client_id' => $this->_sitePageData->operationID,
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pyramid/shopcoming/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/coming/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/coming/one/new'] = Helpers_View::getViewObject($dataID, new Model_Pyramid_Shop_Coming(),
            '_shop/coming/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pyramid/shopcoming/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/coming/one/edit',
            )
        );

        // id записи
        $shopComingID = Request_RequestParams::getParamInt('id');
        if ($shopComingID === NULL) {
            throw new HTTP_Exception_404('Coming order not is found!');
        }else {
            $model = new Model_Pyramid_Shop_Coming();
            if (! $this->dublicateObjectLanguage($model, $shopComingID)) {
                throw new HTTP_Exception_404('Coming order not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Pyramid_Shop_Coming', $this->_sitePageData->shopID, "_shop/coming/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopComingID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pyramid/shopcoming/save';

        $result = Api_Pyramid_Shop_Coming::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'update_user_name' => array(
                    'id' => 'update_user_id',
                    'model' => new Model_User(),
                ),
            )
        );
    }
}
