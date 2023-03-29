<?php
/**
 * @param $name - название значение (shop_table_param)
 * @param $params - массив дополнительных параметров кроме type, чтобы получить правильный список данных
 */
$nameURL = str_replace('_', '', $name);
// базовые параметры запроса
if (empty($params)){
    $params = array(
        'type' => 'type',
    );
}else{
    $params = array_merge(
        array(
            'type' => 'type',
        ),
        $params
    );
}
// порядковый номер для параметров
if (empty($index)){
    $index = '';
}
// Сортировка
if (empty($isSort)){
    $isSort = TRUE;
}
// Массовое изменение
if (empty($isIndexEdit)){
    $isIndexEdit = TRUE;
}
// Удаленные
if (empty($isDelete)){
    $isDelete = TRUE;
}
// Неопубликованные
if (empty($isNotPublic)){
    $isNotPublic = TRUE;
}
// Опубликованные
if (empty($isPublic)){
    $isPublic = TRUE;
}
// Приход на склад
if (empty($isIndexStock)){
    $isIndexStock = FALSE;
}
// Подтверждение изменений
if (empty($isVersion)){
    $isVersion = FALSE;
}
$isActive = FALSE;

// Скачать данные
if (empty($isDownload)){
    $isDownload = FALSE;
}
if (empty($tableID)){
    $tableID = 0;
}
if (empty($buttonAdd)) {
    $buttonAdd = SitePageData::setPathReplace('type.form_data.' . $name . $index . '.fields_title.button_add', SitePageData::CASE_FIRST_LETTER_UPPER);
}
?>

<div class="nav-tabs-custom" style="margin-bottom: 0px;">
    <ul id="tab-status" class="nav nav-tabs pull-right ui-sortable-handle">
        <?php if($isSort){ ?>
            <li<?php
            if($siteData->url == '/'.$siteData->actionURLName.'/'.$nameURL.'/sort'){
                echo '  class="active"';
                $isActive = TRUE;
            }
            ?>>
                <a data-toggle="tab" data-id="is_public_ignore" data-value="1"
                   href="<?php
                   echo Func::getFullURL(
                       $siteData,
                       '/'.$nameURL.'/sort',
                       $params,
                       array(
                           'is_public_ignore' => 1
                       )
                   );
                   ?>">
                    Сортировка
                </a>
            </li>
        <?php } ?>
        <?php if($isIndexEdit){ ?>
            <li<?php
            if($siteData->url == '/'.$siteData->actionURLName.'/'.$nameURL.'/index_edit'){
                echo '  class="active"';
                $isActive = TRUE;
            }
            ?>>
                <a data-toggle="tab" data-id="is_public_ignore" data-value="1"
                   href="<?php
                   echo Func::getFullURL(
                       $siteData,
                       '/'.$nameURL.'/index_edit',
                       $params,
                       array(
                           'is_public_ignore' => 1
                       )
                   );
                   ?>">
                    Массовое изменение
                </a>
            </li>
        <?php } ?>
        <?php if($isIndexStock){ ?>
            <li<?php
            if($siteData->url == '/'.$siteData->actionURLName.'/'.$nameURL.'/index_stock'){
                echo '  class="active"';
                $isActive = TRUE;
            }
            ?>>
                <a data-toggle="tab" data-id="is_public_ignore" data-value="1"
                   href="<?php
                   echo Func::getFullURL(
                       $siteData,
                       '/'.$nameURL.'/index_stock',
                       $params,
                       array(
                           'is_public_ignore' => 1
                       )
                   );
                   ?>">
                    Приход на склад
                </a>
            </li>
        <?php } ?>
        <?php if($isDelete){ ?>
            <li<?php
            if(($siteData->url == '/'.$siteData->actionURLName.'/'.$nameURL.'/index')
                && (Request_RequestParams::getParamBoolean('is_delete'))){
                echo '  class="active"';
                $isActive = TRUE;
            }?>>
                <a data-toggle="tab" data-id="is_delete" data-value="1"
                   href="<?php
                   echo Func::getFullURL(
                       $siteData,
                       '/'.$nameURL.'/index',
                       $params,
                       array(
                           'is_delete' => 1
                       )
                   );
                   ?>">
                    Удаленные
                </a>
            </li>
        <?php } ?>
        <?php if($isNotPublic){ ?>
            <li<?php
            if(($siteData->url == '/'.$siteData->actionURLName.'/'.$nameURL.'/index')
                && (Request_RequestParams::getParamBoolean('is_not_public'))){
                echo '  class="active"';
                $isActive = TRUE;
            }?>>
                <a data-toggle="tab"  data-id="is_not_public" data-value="1"
                   href="<?php
                   echo Func::getFullURL(
                       $siteData,
                       '/'.$nameURL.'/index',
                       $params,
                       array(
                           'is_not_public' => 1
                       )
                   );
                   ?>">
                    Неактивные
                </a>
            </li>
        <?php } ?>
        <?php if($isPublic){ ?>
            <li<?php
            if(($siteData->url == '/'.$siteData->actionURLName.'/'.$nameURL.'/index')
                && (Request_RequestParams::getParamBoolean('is_public'))){
                echo '  class="active"';
                $isActive = TRUE;
            }?>>
                <a data-toggle="tab"  data-id="is_public" data-value="1"
                   href="<?php
                   echo Func::getFullURL(
                       $siteData,
                       '/'.$nameURL.'/index',
                       $params,
                       array(
                           'is_public' => 1
                       )
                   );
                   ?>">
                    Активные
                </a>
            </li>
        <?php } ?>
        <li<?php
        if(!$isActive){
            echo ' class="active"';
        }?>>
            <a data-toggle="tab" data-id="is_public_ignore" data-value="1"
                href="<?php
                echo Func::getFullURL(
                    $siteData,
                    '/'.$nameURL.'/index',
                    $params,
                    array(
                        'is_public_ignore' => 1
                    )
                );
                ?>">
                Все <i class="fa fa-fw fa-info text-blue"></i>
            </a>
        </li>
        <li class="pull-left header">
            <?php if($tableID == Model_Shop_Good::TABLE_ID){ ?>
                <div class="btn-group">
                    <a href="<?php
                    echo Func::getFullURL(
                        $siteData,
                        '/'.$nameURL.'/new',
                        $params,
                        array()
                    );
                    ?>" type="button" class="btn btn-warning">Добавить</a>
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="<?php echo Func::getFullURL($siteData, '/shoploaddata/index', array('type' => 'type'), array('table_id' => Model_Shop_Good::TABLE_ID));?>">
                                Загрузка файла данных
                            </a>
                        </li>
                        <li>
                            <a data-modal="#parse-site-good" data-action="parse-site" href="#" data-href="<?php echo Func::getFullURL($siteData, '/'.$nameURL.'/modal_parse_site_by_article', array('type' => 'type', 'is_group' => 'is_group'), array(), array(), TRUE);?>">
                                Загрузить данные с другого сайта (поиск по артиклу)
                            </a>
                        </li>
                        <li>
                            <a data-modal="#parse-site-good-by-url" data-action="parse-site" href="#" data-href="<?php echo Func::getFullURL($siteData, '/'.$nameURL.'/modal_parse_site_by_url', array('type' => 'type', 'is_group' => 'is_group'), array(), array(), TRUE);?>">
                                Загрузить данные с другого сайта (загрузка ссылок)
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Func::getFullURL($siteData, '/shopgood/save_xls', array('type' => 'type', 'is_group' => 'is_group'), array('file' => 'avotor.xls'));?>">
                                Сохранить в XLS
                            </a>
                        </li>
                    </ul>
                </div>
            <?php }else{ ?>
                <span>
                    <a href="<?php
                    echo Func::getFullURL(
                        $siteData,
                        '/'.$nameURL.'/new',
                        $params,
                        array()
                    );
                    ?>" class="btn btn-warning">
                        <i class="fa fa-fw fa-plus"></i>
                        <?php echo $buttonAdd; ?>
                    </a>
                </span>
            <?php } ?>
            <?php if($isDownload){ ?>
                <span>
                    <a href="<?php
                    echo Func::getFullURL(
                        $siteData,
                        '/shoploaddata/index',
                        $params,
                        array(
                            'table_id' => $tableID
                        )
                    );?>" class="btn btn-warning">
                        <i class="fa fa-fw fa-plus"></i>
                        Скачать файл с данными
                    </a>
                </span>
            <?php } ?>
        </li>
    </ul>
</div>