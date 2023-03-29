<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_ShopReport extends Controller_Nur_BasicList {

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
     * Порядковый номер для диапозона времени АСУ
     * @param array $list
     * @param $from
     * @param $to
     * @return int
     */
    private function _getIndexPeriodWorkTimeASU(array &$list, $from, $to) {
        $fromD = strtotime($from);
        $toD = strtotime($to);

        $index = count($list) - 1;
        if($index < 0){
            return 0;
        }

        if((((($list[$index]['from_d'] <= $fromD)
                && ($list[$index]['to_d'] >= $fromD))
            || (($list[$index]['from_d'] <= $toD)
                && ($list[$index]['to_d'] >= $toD))
            || (($list[$index]['from_d'] <= $fromD)
                && ($list[$index]['to_d'] >= $toD))))){
            return $index;
        }

        return $index + 1;
    }

    /**
     * Расширяем диапозон времени в массиве у заданного ключа для диапозона времени АСУ
     * @param array $list
     * @param $key
     * @param $from
     * @param $to
     * @param array $values
     */
    private function _editPeriodWorkTimeASU(array &$list, $key, $from, $to, array $values = array()) {
        $fromD = strtotime($from);
        $toD = strtotime($to);

        if(!key_exists($key, $list)){
            $list[$key] = array_merge(
                $values,
                array(
                    'from' => $from,
                    'from_d' => $fromD,
                    'to' => $to,
                    'to_d' => $toD,
                    'data' => array(),
                )
            );
        }else{
            if($list[$key]['to_d'] < $toD){
                $list[$key]['to'] = $to;
                $list[$key]['to_d'] = $toD;
            }

            if($list[$key]['from_d'] > $fromD){
                $list[$key]['from'] = $from;
                $list[$key]['from_d'] = $fromD;
            }
        }
    }


    /**
     * Накладная для малого СБЫТа
     */
    public function action_invoice_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/invoice_one';

        $shopInvoiceID = Request_RequestParams::getParamInt('id');

        $model = new Model_Nur_Shop_Invoice();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopInvoiceID, $this->_sitePageData)){
            throw new HTTP_Exception_500('Invoice not found.');
        }

        // накладная
        $invoice = array(
            'number' => $model->getNumber(),
            'created_at' => $model->getCreatedAt(),
            'client' => $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID)->getName(),
            'created_at' => $model->getCreatedAt(),
        );

        // доверенность
        $modelAttorney = $model->getElement('shop_client_attorney_id', TRUE);
        if($modelAttorney !== NULL) {
            $attorney = array(
                'number' => $modelAttorney->getNumber(),
                'client_name' => $modelAttorney->getClientName(),
                'from_at' => $modelAttorney->getFromAt(),
            );
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $shopInvoiceID,
            )
        );
        $shopCarItemIDs = Request_Nur_Shop_Car_Item::find(
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name_1c', 'unit', 'old_id'))
        );
        $shopPieceItemIDs = Request_Nur_Shop_Piece_Item::find(
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_product_id' => array('name_1c', 'unit', 'old_id'))
        );

        $dataInvoiceItems = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );

        foreach ($shopCarItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $shopProductID = $child->values['shop_product_id'].'_'.$child->values['price'];

            if(!key_exists($shopProductID, $dataInvoiceItems['data'])){
                $dataInvoiceItems['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_product_id', 'name_1c'),
                    'old_id' => $child->getElementValue('shop_product_id', 'old_id') ,
                    'unit' => $child->getElementValue('shop_product_id', 'unit') ,
                    'quantity' => $quantity,
                    'price' => $child->values['price'],
                    'amount' => $amount,
                );
            }else{
                $dataInvoiceItems['data'][$shopProductID]['amount']  += $amount;
                $dataInvoiceItems['data'][$shopProductID]['quantity'] += $quantity;
            }

            $dataInvoiceItems['amount'] += $amount;
            $dataInvoiceItems['quantity'] += $quantity;
        }

        foreach ($shopPieceItemIDs->childs as $child){
            $amount = $child->values['amount'];
            $quantity = $child->values['quantity'];
            $shopProductID = $child->values['shop_product_id'].'_'.$child->values['price'];

            if(!key_exists($shopProductID, $dataInvoiceItems['data'])){
                $dataInvoiceItems['data'][$shopProductID] = array(
                    'name' => $child->getElementValue('shop_product_id', 'name_1c'),
                    'old_id' => $child->getElementValue('shop_product_id', 'old_id') ,
                    'unit' => $child->getElementValue('shop_product_id', 'unit') ,
                    'quantity' => $quantity,
                    'price' => $child->values['price'],
                    'amount' => $amount,
                );
            }else{
                $dataInvoiceItems['data'][$shopProductID]['amount']  += $amount;
                $dataInvoiceItems['data'][$shopProductID]['quantity'] += $quantity;
            }

            $dataInvoiceItems['amount'] += $amount;
            $dataInvoiceItems['quantity'] += $quantity;
        }

        // Сортировка
        uasort($dataInvoiceItems['data'], array($this, 'mySortMethod'));

        $viewObject = 'nur/_report/'.$this->_sitePageData->languageID.'/invoice/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->invoiceItems = $dataInvoiceItems;
        $view->invoice = $invoice;
        $view->attorney = $attorney;
        $view->currency = $this->_sitePageData->currency;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Накладная №'.$invoice['number'].'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }
    /*
     * Заявка (план на один день)
     */
    public function action_plan_day() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/plan_day';

        $shopProductIDs = NULL;
        $date = Request_RequestParams::getParamDateTime('date');


        $params = Request_RequestParams::setParams(
            array(
                'date' => $date,
                'shop_product_id' => $shopProductIDs,
            )
        );
        $shopIDs = Request_Shop::getBranchShopIDs($this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB)->getChildArrayID();
        $shopIDs[] = $this->_sitePageData->shopMainID;

        $ids = Request_Nur_Shop_Plan_Item::findBranch(
            $shopIDs, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_id' => array('name'),
                'shop_client_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_plan_id' => array('car_count', 'facility', 'date_from', 'date_to'),
            )
        );

        $products = array();
        foreach ($ids->childs as $child){
            $product = $child->values['shop_product_id'];
            if (! key_exists($product, $products)){
                $products[$product] = array(
                    'quantity' => 0,
                    'car_count' => 0,
                    'data' => array(),
                    'name' => $child->getElementValue('shop_product_id'),
                );
            }
        }
        uasort($products, array($this, 'mySortMethod'));

        $dataProducts = $products;
        $dataClients = array(
            'data' => array(),
            'quantity' => 0,
            'car_count' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $carCount =intval($child->getElementValue('shop_plan_id', 'car_count'));

            $shopID = $child->values['shop_id'];
            if (! key_exists($shopID, $dataClients['data'])){
                $dataClients['data'][$shopID] = array(
                    'data' => array(),
                    'name' => $child->getElementValue('shop_id'),
                    'quantity' => 0,
                    'car_count' => 0,
                    'products' => $products,
                );
            }

            $product = $child->values['shop_product_id'];
            $dataProducts[$product]['quantity'] += $quantity;
            $dataProducts[$product]['car_count'] += $carCount;

            $client = $child->values['shop_client_id'];
            $facility = $child->getElementValue('shop_plan_id', 'facility');

            $key = $client.'_'.$facility;
            if (! key_exists($key, $dataClients['data'][$shopID]['data'])){
                $dataClients['data'][$shopID]['data'][$key] = array(
                    'data' => $products,
                    'name' => $child->getElementValue('shop_client_id'),
                    'facility' => $facility,
                    'quantity' => 0,
                    'car_count' => 0,
                    'time_from' => Helpers_DateTime::getTimeByDate($child->getElementValue('shop_plan_id', 'date_from')),
                    'time_to' => Helpers_DateTime::getTimeByDate($child->getElementValue('shop_plan_id', 'date_to')),
                );
            }


            $dataClients['data'][$shopID]['products'][$product]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['products'][$product]['car_count'] += $carCount;

            $dataClients['data'][$shopID]['data'][$key]['data'][$product]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['data'][$key]['data'][$product]['car_count'] += $carCount;

            $dataClients['data'][$shopID]['data'][$key]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['data'][$key]['car_count'] += $carCount;

            $dataClients['data'][$shopID]['quantity'] += $quantity;
            $dataClients['data'][$shopID]['car_count'] += $carCount;

            $dataClients['quantity'] += $quantity;
            $dataClients['car_count'] += $carCount;
        }
        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $viewObject = 'nur/_report/'.$this->_sitePageData->languageID.'/plan/day';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->clients = $dataClients;
        $view->date = $date;
        $view->operation = $this->_sitePageData->operation->getValues();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Заявка на '.Helpers_DateTime::getDateFormatRus($date).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

}
