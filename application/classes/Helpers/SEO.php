<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_SEO {
    /**
     * Задаем базовые СЕО данные
     * @param $url
     * @param array $urlOptions
     * @param SitePageData $sitePageData
     * @return string
     */
    public static function setBasicSEOHeads($url, array $urlOptions, SitePageData $sitePageData){
        $headsFile = APPPATH . 'views' . DIRECTORY_SEPARATOR . $sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'heads.php';
        if (!file_exists($headsFile)) {
            $sitePageData->siteTitle = Arr::path($urlOptions, 'site_title.'.$sitePageData->dataLanguageID, '');
            $sitePageData->siteKeywords = Arr::path($urlOptions, 'site_keywords.'.$sitePageData->dataLanguageID, '');
            $sitePageData->siteDescription = Arr::path($urlOptions, 'site_description.'.$sitePageData->dataLanguageID, '');
        }else {
            $heads = include $headsFile;
            if (empty($url)){
                $url = '/';
            }

            $sitePageData->siteTitle = Arr::path($heads, $sitePageData->shopID.'.'.$url.'.'.$sitePageData->dataLanguageID.'.site_title',
                Arr::path($urlOptions, 'site_title.'.$sitePageData->dataLanguageID, ''));
            $sitePageData->siteKeywords = Arr::path($heads, $sitePageData->shopID.'.'.$url.'.'.$sitePageData->dataLanguageID.'.site_keywords',
                Arr::path($urlOptions, 'site_title.'.$sitePageData->dataLanguageID, ''));
            $sitePageData->siteDescription = Arr::path($heads, $sitePageData->shopID.'.'.$url.'.'.$sitePageData->dataLanguageID.'.site_description.',
                Arr::path($urlOptions, 'site_title.'.$sitePageData->dataLanguageID, ''));
        }
        $sitePageData->siteImage = $sitePageData->shop->getImagePath();
    }

    /**
     * Получаем список атрибутов для SEO настройки в виде массива
     * @param $tableName
     * @param $languageID
     * @param $isBranch
     * @return array
     */
    public static function getSEOAttrsArray($tableName, $languageID, $isBranch){
        $result = array();
        switch($languageID){
            case Model_Language::LANGUAGE_RUSSIAN:
                $result = array(
                    array('title' => '[Название компании]', 'field' => 'company_name'),
                    array('title' => '[Страна]', 'field' => 'land'),
                    array('title' => '[Стране]', 'field' => 'land', 'case' => 2/*NCL::$DATELN*/),
                    array('title' => '[Город]', 'field' => 'city'),
                    array('title' => '[Городе]', 'field' => 'city', 'case' => 5 /*NCL::$PREDLOGN*/),
                );
                switch($tableName){
                    case Model_Shop_Table_Rubric::TABLE_NAME:
                        $result[] = array('title' => '[Название рубрики]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        break;
                    case Model_Shop_New::TABLE_NAME:
                        $result[] = array('title' => '[Название статьи]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        $result[] = array('title' => '[Название рубрики]', 'field' => Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_new_rubric.name');
                        break;
                    case Model_Shop_Table_Child::TABLE_NAME:
                        $result[] = array('title' => '[Название подстатьи]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        break;
                    case Model_Shop_Good::TABLE_NAME:
                        $result[] = array('title' => '[Название товара/услуги]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        $result[] = array('title' => '[Цена]', 'field' => 'price');
                        $result[] = array('title' => '[Название рубрики]', 'field' => Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_catalog.name');
                        break;
                }

                if($isBranch === TRUE) {
                    $result[] =  array('title' => '[Название филиала]', 'field' => Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name');
                }
                break;
            case Model_Language::LANGUAGE_ENGLISH:
                $result = array(
                    array('title' => '[Название компании]', 'field' => 'company_name'),
                    array('title' => '[Страна]', 'field' => 'land'),
                    array('title' => '[Стране]', 'field' => 'land', 'case' => 2/*NCL::$DATELN*/),
                    array('title' => '[Город]', 'field' => 'city'),
                    array('title' => '[Городе]', 'field' => 'city', 'case' => 5 /*NCL::$PREDLOGN*/),
                );
                switch($tableName){
                    case Model_Shop_Table_Rubric::TABLE_NAME:
                        $result[] = array('title' => '[Название рубрики]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        break;
                    case Model_Shop_New::TABLE_NAME:
                        $result[] = array('title' => '[Название статьи]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        $result[] = array('title' => '[Название рубрики]', 'field' => Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_new_rubric.name');
                        break;
                    case Model_Shop_Table_Child::TABLE_NAME:
                        $result[] = array('title' => '[Название подстатьи]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        break;
                    case Model_Shop_Good::TABLE_NAME:
                        $result[] = array('title' => '[Название товара/услуги]', 'field' => 'name');
                        $result[] = array('title' => '[Описание]', 'field' => 'text');
                        $result[] = array('title' => '[Цена]', 'field' => 'price');
                        $result[] = array('title' => '[Название рубрики]', 'field' => Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_catalog.name');
                        break;
                }

                if($isBranch === TRUE) {
                    $result[] =  array('title' => '[Название филиала]', 'field' => Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name');
                }
                break;
        }

        return $result;
    }

    /**
     * Получаем список атрибутов для SEO настройки
     * @param $tableName
     * @param $languageID
     * @param $isBranch
     * @return string
     */
    public static function getSEOAttrs($tableName, $languageID, $isBranch){
        $arr = self::getSEOAttrsArray($tableName, $languageID, $isBranch);

        $result = '';
        foreach($arr as $value){
            $result = $result. $value['title'].' ';
        }
        return trim($result);
    }


    /**
     * Получаем настройки SEO
     * @param $rootSEOName
     * @param $name
     * @param $prefixName
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @return mixed
     */
    public static function getSEOOptions($rootSEOName, $name, $prefixName, MyArray $data, SitePageData $sitePageData){
        $key = $sitePageData->dataLanguageID.'.'.$prefixName.$name;
        $result = Arr::path($data->values, 'seo.'.$key, '');

        if(empty($result)) {
            $key = Model_Basic_BasicObject::FIELD_ELEMENTS.'.'.$rootSEOName.'.'.$key;
            $result = Arr::path($data->values, 'seo.'.$key, '');
            if (empty($result)) {
                $seo = $sitePageData->shop->getSEOArray();
                $result = Arr::path($seo, $key, '');
            }
        }
        return $result;
    }

    /**
     * Получаем настройки по умолчанию
     * @param $tableName
     * @param $rootSEOName
     * @param $name
     * @param $prefixName
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @param bool $isBranch
     * @return mixed|string
     */
    public static function getSEOOptionsDefault($tableName, $rootSEOName, $name, $prefixName, MyArray $data, SitePageData $sitePageData, $isBranch = FALSE){
        if($isBranch === TRUE) {
            $branch = ' [Название филиала]';
        }else {
            $branch = '';
        }

        $result = self::getSEOOptions($rootSEOName, $name, $prefixName, $data, $sitePageData);
        if(empty($result)) {
            switch ($sitePageData->dataLanguageID) {
                case Model_Language::LANGUAGE_RUSSIAN:
                    switch ($tableName) {
                        case Model_Shop_New::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название статьи]'.$branch.' - [Название компании]';
                                    break;
                                case 'keywords':
                                    return '';
                                    break;
                                case 'description':
                                    return '[Описание]';
                                    break;
                            }
                            break;
                        case Model_Shop_Table_Child::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название подстатьи]'.$branch.' - [Название компании]';
                                    break;
                                case 'keywords':
                                    return '';
                                    break;
                                case 'description':
                                    return '[Описание]';
                                    break;
                            }
                            break;
                        case Model_Shop_Table_Rubric::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название рубрики] купить в [Городе]. [Название рубрики] заказать по выгодной цене - [Название компании]. Фото, описания, характеристики, отзывы. Доставка по [Стране].';
                                    break;
                                case 'keywords':
                                    return '[Название рубрики] купить, [Название рубрики] в [Городе], заказать, продажа, цены, стоимость, фото, отзывы, описания, характеристики, каталог, доставка.';
                                    break;
                                case 'description':
                                    return '[Название рубрики] купить в [Городе]. [Название рубрики] по низким ценам с гарантией. Фото, характеристики, отзывы, доставка — [Название компании], [Стране].';
                                    break;
                            }
                            break;
                        case Model_Shop_Good::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название товара/услуги] купить в [Городе]. Заказать [Название товара/услуги] за [Цена]. Описания, цена, фото, характеристики, доставка'.$branch.' - [Название компании]';
                                    break;
                                case 'keywords':
                                    return '[Название товара/услуги] купить, [Название товара/услуги] в [Городе], заказать, продажа, цены, стоимость, фото, отзывы, описания, характеристики, каталог, доставка.';
                                    break;
                                case 'description':
                                    return '[Название товара/услуги] купить в [Городе]. Доставка, гарантия, сервис! [Название товара/услуги] от [Цена]: фото, отзывы, описания.';
                                    break;
                            }
                            break;
                    }
                    break;
                case Model_Language::LANGUAGE_ENGLISH:
                    switch ($tableName) {
                        case Model_Shop_New::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название статьи]'.$branch.' - [Название компании]';
                                    break;
                                case 'keywords':
                                    return '';
                                    break;
                                case 'description':
                                    return '[Описание]';
                                    break;
                            }
                            break;
                        case Model_Shop_Table_Child::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название подстатьи]'.$branch.' - [Название компании]';
                                    break;
                                case 'keywords':
                                    return '';
                                    break;
                                case 'description':
                                    return '[Описание]';
                                    break;
                            }
                            break;
                        case Model_Shop_Table_Rubric::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название рубрики] купить в [Городе]. [Название рубрики] заказать по выгодной цене - [Название компании]. Фото, описания, характеристики, отзывы. Доставка по [Стране].';
                                    break;
                                case 'keywords':
                                    return '[Название рубрики] купить, [Название рубрики] в [Городе], заказать, продажа, цены, стоимость, фото, отзывы, описания, характеристики, каталог, доставка.';
                                    break;
                                case 'description':
                                    return '[Название рубрики] купить в [Городе]. [Название рубрики] по низким ценам с гарантией. Фото, характеристики, отзывы, доставка — [Название компании], [Страна].';
                                    break;
                            }
                            break;
                        case Model_Shop_Good::TABLE_NAME:
                            switch ($name) {
                                case 'title':
                                    return '[Название товара/услуги] купить в [Городе]. Заказать [Название товара/услуги] за [Цена]. Описания, цена, фото, характеристики, доставка'.$branch.' - [Название компании]';
                                    break;
                                case 'keywords':
                                    return '[Название товара/услуги] купить, [Название товара/услуги] в [Городе], заказать, продажа, цены, стоимость, фото, отзывы, описания, характеристики, каталог, доставка.';
                                    break;
                                case 'description':
                                    return '[Название товара/услуги] купить в [Городе]. Доставка, гарантия, сервис! [Название товара/услуги] от [Цена]: фото, отзывы, описания.';
                                    break;
                            }
                            break;
                    }
                    break;
            }
        }
        return $result;
    }

    /**
     * Получаем значение атрибута для заголовков страницы
     * @param $field
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @return mixed|string
     */
    public static function getSEOHeaderAttr($field, MyArray $data, SitePageData $sitePageData)
    {
        $result = '';
        switch ($field) {
            case 'company_name':
                $result = $sitePageData->shop->getName();
                break;
            case 'land':
                $result = $sitePageData->land->getName();
                break;
            case 'city':
                $result = $sitePageData->city->getName();
                break;
            case 'price':
                if(floatval(Arr::path($data->values, 'price', 0)) > 0) {
                    $result = Func::getPriceStr($sitePageData->currency, $data->values['price']);
                }else {
                    switch ($sitePageData->dataLanguageID) {
                        case Model_Language::LANGUAGE_RUSSIAN:
                            $result = 'лучшую цену';
                            break;
                    }
                }
                break;
            default:
                $result = Arr::path($data->values, $field, '');
        }

        return Func::trimTextNew($result, 300);
    }

    /**
     * Устанавливаем SEO теги для заголовков страницы
     * @param $tableName
     * @param MyArray $data
     * @param SitePageData $sitePageData
     * @param $isBranch
     */
    public static function setSEOHeader($tableName, MyArray $data, SitePageData $sitePageData, $isBranch = FALSE)
    {
        $title = '';
        $keywords = '';
        $description = '';
        switch ($sitePageData->dataLanguageID) {
            case Model_Language::LANGUAGE_RUSSIAN:
                switch ($tableName) {
                    case Model_Shop_Table_Rubric::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_new_catalog.seo.shop_new_rubric', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_new_catalog.seo.shop_new_rubric', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_new_catalog.seo.shop_new_rubric', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                    case Model_Shop_New::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_new_catalog_id.seo.shop_new', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_new_catalog_id.seo.shop_new', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_new_catalog_id.seo.shop_new', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                    case Model_Shop_Table_Child::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_new_child_catalog.seo.shop_new_child', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_new_child_catalog.seo.shop_new_child', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_new_child_catalog.seo.shop_new_child', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                    case Model_Shop_Good::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_good_type.seo.shop_good', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_good_type.seo.shop_good', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_good_type.seo.shop_good', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                }
                break;
            case Model_Language::LANGUAGE_ENGLISH:
                switch ($tableName) {
                    case Model_Shop_Table_Rubric::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_new_catalog.seo.shop_new_rubric', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_new_catalog.seo.shop_new_rubric', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_new_catalog.seo.shop_new_rubric', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                    case Model_Shop_New::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_new_catalog_id.seo.shop_new', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_new_catalog_id.seo.shop_new', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_new_catalog_id.seo.shop_new', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                    case Model_Shop_Table_Child::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_new_child_catalog.seo.shop_new_child', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_new_child_catalog.seo.shop_new_child', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_new_child_catalog.seo.shop_new_child', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                    case Model_Shop_Good::TABLE_NAME:
                        $title = self::getSEOOptionsDefault($tableName, 'shop_good_type.seo.shop_good', 'title', '', $data, $sitePageData, $isBranch);
                        $keywords = self::getSEOOptionsDefault($tableName, 'shop_good_type.seo.shop_good', 'keywords', '', $data, $sitePageData, $isBranch);
                        $description = self::getSEOOptionsDefault($tableName, 'shop_good_type.seo.shop_good', 'description', '', $data, $sitePageData, $isBranch);
                        break;
                }
                break;
        }

        $attrs = self::getSEOAttrsArray($tableName, $sitePageData->dataLanguageID, $isBranch);
        foreach($attrs as $attr){
            $s = self::getSEOHeaderAttr($attr['field'], $data, $sitePageData);
            if (key_exists('case', $attr)){
                $s = Func::getStringCaseRus($s, $attr['case']);
            }

            $title = str_replace($attr['title'], $s, $title);
            $keywords = str_replace($attr['title'], $s, $keywords);
            $description = str_replace($attr['title'], $s, $description);
        }

        if(!empty($title)) {
            $sitePageData->siteTitle = $title;
        }

        if(!empty($keywords)) {
            $sitePageData->siteKeywords = $keywords;
        }

        if(!empty($description)) {
            $sitePageData->siteDescription = $description;
        }

    }
}