<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Finance_ShopReport extends Controller_Finance_All {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'admin';
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
     * сортировка по полям order и name
     * @param $x
     * @param $y
     * @return int
     */
    function mySortOrderMethod($x, $y) {
        if($x['order'] == $y['order']){
            return strcasecmp($x['name'], $y['name']);
        }

        if($x['order'] > $y['order']){
            return 1;
        }

        return -1;
    }


    public function action_need_buy_bill_items() {
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/need_buy_bill_items';

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_bill_item_status_id' => [0, Model_AutoPart_Shop_Bill_Item_Status::STATUS_NEW],
                    'shop_source_id' => Request_RequestParams::getParamInt('shop_source_id'),
                    'sort_by' => [
                        'shop_company_id.name' => 'asc'
                    ],
                ]
            ),
            0, true,
            array(
                'shop_product_id' => array('name', 'article'),
                'shop_product_id.shop_supplier_id' => array('name'),
                'shop_company_id' => array('name'),
                'shop_bill_id' => array('old_id', 'approve_source_at', 'delivery_address', 'delivery_plan_at', 'buyer'),
                'shop_bill_id.shop_bill_buyer_id' => array('phone'),
            )
        );

        $dataBillItems = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $dataBillItems['data'][] = array(
                'shop_product_id' => $child->values['shop_product_id'],

                'bill' => $child->getElementValue('shop_bill_id', 'old_id'),
                'date' => $child->getElementValue('shop_bill_id', 'approve_source_at'),
                'article' => $child->getElementValue('shop_product_id', 'article'),
                'product' => $child->getElementValue('shop_product_id'),
                'rubric' => '',
                'address' => $child->getElementValue('shop_bill_id', 'delivery_address'),
                'phone' => $child->getElementValue('shop_bill_buyer_id', 'phone'),
                'price' => $child->values['price'],
                'quantity' => $child->values['quantity'],
                'amount' => $child->values['amount'],
                'supplier' => $child->getElementValue('shop_supplier_id'),
                'company' => $child->getElementValue('shop_company_id'),
                'buyer' => $child->getElementValue('shop_bill_id', 'buyer'),
                'delivery_plan' => $child->getElementValue('shop_bill_id', 'delivery_plan_at'),
            );
        }


        // находим список детворы ввиде замен
        foreach ($dataBillItems['data'] as $key => $child){
            $product = $child['shop_product_id'];
            $ids = Request_Request::find(
                DB_AutoPart_Shop_Product::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'root_shop_product_id' => $product,
                        'is_public_ignore' => true,
                    ]
                ),
                0, true,
                array(
                    'shop_supplier_id' => array('name')
                )
            );

            $list = [$child['supplier']];
            foreach ($ids->childs as $item){
                $list[] = $item->getElementValue('shop_supplier_id');
            }

            $dataBillItems['data'][$key]['supplier'] = implode(', ', $list);
        }


        $viewObject = 'smg/_report/'.$this->_sitePageData->languageID.'/bill/item';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->billItems = $dataBillItems;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Товары заказов на '.Helpers_DateTime::getDateFormatRus(Helpers_DateTime::getCurrentDatePHP()).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

}
