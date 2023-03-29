<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopPDF extends Controller_Hotel_BasicHotel {

    const PATH_OPTIONS_PDF = APPPATH . 'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR;

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoppdf';
        $this->objectName = 'pdf';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shoppdf/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pdf/list/index',
            )
        );

        $data = new MyArray();
        $this->_sitePageData->replaceDatas['view::_shop/pdf/list/index'] =
            Helpers_View::getViewObjects($data, new Model_Shop(), '_shop/pdf/list/index', '_shop/pdf/one/index',
                $this->_sitePageData, $this->_driverDB, -1, TRUE, array(), TRUE);

        $this->_putInMain('/main/_shop/pdf/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/hotel/shoppdf/json';

        $result = require self::PATH_OPTIONS_PDF. 'pdf.php';

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(json_encode(array('total' => count($result), 'rows' => $result)));
        }else{
            $this->response->body(json_encode($result));
        }
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shoppdf/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pdf/one/edit',
            )
        );

        $result = require self::PATH_OPTIONS_PDF. 'pdf.php';

        $id = Request_RequestParams::getParamInt('id');
        if (! key_exists($id, $result)) {
            throw new HTTP_Exception_404('PDF options not is found!');
        }

        $path = self::PATH_OPTIONS_PDF . $result[$id]['language']. DIRECTORY_SEPARATOR . $result[$id]['directory']. DIRECTORY_SEPARATOR;
        $bill = require $path. 'bill.php';
        $bill['body'] = file_get_contents($path. 'bill-body.php');

        $data = new MyArray();
        $data->id = 0;
        $data->isFindDB = TRUE;
        $data->values = array_merge($result[$id], $bill);

        $data = $this->_sitePageData->replaceDatas['view::_shop/pdf/one/edit'] =
            Helpers_View::getViewObject($data, new Model_Shop(), '_shop/pdf/one/edit', $this->_sitePageData, $this->_driverDB);


        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shoppdf/save';

        $result = require self::PATH_OPTIONS_PDF. 'pdf.php';

        $id = Request_RequestParams::getParamInt('id');
        if (! key_exists($id, $result)) {
            throw new HTTP_Exception_404('PDF options not is found!');
        }

        $path = self::PATH_OPTIONS_PDF . $result[$id]['language']. DIRECTORY_SEPARATOR. $result[$id]['directory']. DIRECTORY_SEPARATOR;

        $bill = require $path. 'bill.php';
        $bill['header'] = Request_RequestParams::getParamStr('header');
        $bill['footer'] = Request_RequestParams::getParamStr('footer');

        try {
            file_put_contents($path. 'bill.php', '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($bill) . ';');
        } catch (Exception $e) {
        }

        try {
            file_put_contents($path. 'bill-body.php', Request_RequestParams::getParamStr('body'));
        } catch (Exception $e) {
        }

        $this->_redirectSaveResult(
            array(
                'result' => array(
                    'values' => $result[$id],
                    'error' => FALSE,
                ),
                'id' => $id,
            )
        );
    }
}
