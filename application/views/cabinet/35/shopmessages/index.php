<table class="table table-hover table-db table-tr-line">
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="is_public" type="checkbox" class="minimal" checked disabled>
            </span>
        </th>
        <th class="tr-header-id">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-black">ID</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'id'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.id', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-rubric">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-black">ФИО пользователя</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'name'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.name', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-rubric">
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-black">E-mail</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'email'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-alpha-<?php if (Arr::path($siteData->urlParams, 'sort_by.email', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-black">Примечание</a>
            <a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmessage/index<?php echo Func::getAddURLSortBy($siteData->urlParams, 'text'); ?>" class="link-blue">
                <i class="fa fa-fw fa-sort-numeric-<?php if (Arr::path($siteData->urlParams, 'sort_by.text', '') === 'asc'){echo 'desc';}else{echo 'asc';}?>"></i>
            </a>
        </th>
        <th class="tr-header-buttom">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Действия <span class="fa fa-caret-down"></span></button>
                <ul class="dropdown-menu">
                    <li><a data-id="save-file-select" href="<?php echo Func::getURL($siteData, '/'.$siteData->actionURLName.'/shopmessage/savefile', array('file-type' => 'xls', 'page' => 1), TRUE); ?>" target="_blank" download>Сохранить выделенное в файл-xls <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li><a href="<?php echo Func::getURL($siteData, '/'.$siteData->actionURLName.'/shopmessage/savefile', array('file-type' => 'xls', 'page' => 1), TRUE); ?>" target="_blank" download>Сохранить все в файл-xls <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="divider"></li>
                    <li><a data-id="save-file-select"href="<?php echo Func::getURL($siteData, '/'.$siteData->actionURLName.'/shopmessage/savefile', array('file-type' => 'txt', 'page' => 1), TRUE); ?>" target="_blank" download>Сохранить выделенное в файл-txt <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li><a href="<?php echo Func::getURL($siteData, '/'.$siteData->actionURLName.'/shopmessage/savefile', array('file-type' => 'txt', 'page' => 1), TRUE); ?>" target="_blank" download>Сохранить все в файл-txt <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li class="divider"></li>
                    <li><a data-id="save-file-select"href="<?php echo Func::getURL($siteData, '/'.$siteData->actionURLName.'/shopmessage/savefile', array('file-type' => 'xml', 'page' => 1), TRUE); ?>" target="_blank" download>Сохранить выделенное в файл-xml <i class="fa fa-fw fa-info text-blue"></i></a></li>
                    <li><a href="<?php echo Func::getURL($siteData, '/'.$siteData->actionURLName.'/shopmessage/savefile', array('file-type' => 'xml', 'page' => 1), TRUE); ?>" target="_blank" download>Сохранить все в файл-xml <i class="fa fa-fw fa-info text-blue"></i></a></li>
                </ul>
            </div

        </th>
    </tr>
    <?php
    foreach ($data['view::shopmessage/index']->childs as $value) {
        echo $value->str;
    }
    ?>

</table>
<div class="col-md-12 padding-t-5">
    <?php
    $view = View::factory('cabinet/35/paginator');
    $view->siteData = $siteData;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
