<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopCourierRouteItem extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Courier_Route_Item';
        $this->controllerName = 'shopcourierrouteitem';
        $this->tableID = Model_AutoPart_Shop_Courier_Route_Item::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Courier_Route_Item::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_start(){
        $this->_sitePageData->url = '/market/shopcourierroute/start';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Courier_Route_Item();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $modelRoute = new Model_AutoPart_Shop_Courier_Route();
        if (! $this->getDBObject($modelRoute, $model->getShopCourierRouteID())) {
            throw new HTTP_Exception_404('Route not is found!');
        }

        $model->setFromAt(Helpers_DateTime::getCurrentDateTimePHP());
        $model->setShopCourierRouteItemIdFrom($modelRoute->getShopCourierRouteItemIDCurrent());
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $modelRoute->setShopCourierRouteItemIDCurrent($model->id);
        Helpers_DB::saveDBObject($modelRoute, $this->_sitePageData);

        self::redirect('/market/shopcourierroute/show' . URL::query(['id' => $modelRoute->id], false));
    }

    public function action_finish(){
        $this->_sitePageData->url = '/market/shopcourierroute/finish';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Courier_Route_Item();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $model->setToAt(Helpers_DateTime::getCurrentDateTimePHP());
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        self::redirect('/market/shopcourierroute/my_route');
    }
}
