<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopMeta extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopmeta';
        $this->objectName = 'meta';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cabinet/shopmeta/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::options/shop/meta/list/index',
            )
        );

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Site template not found.');
        }

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'metas' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . '.php';
        if (file_exists($file)) {
            $metas = include($file);
        } else {
            $metas = array();
        }

        $data = new MyArray();
        $i = 0;
        foreach ($metas as $value) {
            $obj = $data->addChild($i);
            $obj->values = array(
                'name' => Arr::path($value, 'name', ''),
                'content' => Arr::path($value, 'content', ''),
                'addition' => Arr::path($value, 'addition', ''),
                'itemprop' => Arr::path($value, 'itemprop', ''),
                'property' => Arr::path($value, 'property', ''),
                'url' => Arr::path($value, 'url', ''),
            );
            $obj->values['id'] = $i;
            $obj->isFindDB = TRUE;
            $i++;
        }

        $datas = Helpers_View::getViewObjects($data, new Model_Basic_LanguageObject(array(), '', 0),
            "options/shop/meta/list/index", "options/shop/meta/one/index", $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID);
        $this->_sitePageData->replaceDatas['view::options/shop/meta/list/index'] = $datas;

        $this->_putInMain('/main/options/shop/meta/index');
    }


    /**
     * изменение статьи
     */
    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopmeta/save';

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Site template not found.');
        }

        $metas = array();
        $arr = Request_RequestParams::getParamArray('metas');
        if ($arr !== NULL) {

            foreach ($arr as $value) {
                $metas[] =  array(
                    'name' => trim(Arr::path($value, 'name', '')),
                    'content' => trim(Arr::path($value, 'content', '')),
                    'addition' => trim(Arr::path($value, 'addition', '')),
                    'itemprop' => trim(Arr::path($value, 'itemprop', '')),
                    'property' => trim(Arr::path($value, 'property', '')),
                    'url' => trim(Arr::path($value, 'url', '')),
                );
            }

            $metas = '<?php defined(\'SYSPATH\') or die(\'No direct script access.\');'."\r\n".'return ' . Helpers_Array::arrayToStrPHP($metas).';';

            $filePath = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'metas' . DIRECTORY_SEPARATOR;
            if (Helpers_Path::createPath($filePath)) {
                $filePath = $filePath . $this->_sitePageData->dataLanguageID . '.php';

                $file = fopen($filePath, 'w');
                fwrite($file, $metas);
                fclose($file);
                chmod($filePath, 0777);
            }
        }

        $branchID = '';
        if ($this->_sitePageData->branchID > 0) {
            $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
        }
        $this->redirect('/cabinet/shopmeta/index?' . $branchID);
    }
}
