<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_ShopReport extends Controller_Calendar_BasicList {

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

    /**
     * Расходно-кассовый ордер
     */
    public function action_tasks() {
        $this->_sitePageData->url = '/calendar/shopreport/tasks';

        $ids = Request_Calendar_Shop_Task::find(
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, array(), 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_partner_id' => array('name'),
                'shop_rubric_id' => array('name'),
                'shop_result_id' => array('name'),
            )
        );

        $viewObject = 'calendar/_report/'.$this->_sitePageData->languageID.'/tasks';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->tasks = $ids->childs;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Source KTC.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }
}
