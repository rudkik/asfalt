<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopReport extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
    }

    /**
     * сортировка по имени
     * @param $x
     * @param $y
     * @return int
     */
    function mySortMethod($x, $y) {
        return strcasecmp($x['name'], $y['name']);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shopreport/index';

        $this->_requestShopPaidTypes();

        $this->_putInMain('/main/_shop/report/index');
    }
}
