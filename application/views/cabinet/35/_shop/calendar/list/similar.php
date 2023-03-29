<input hidden="hidden" name="shop_table_similars[]" value="0">
<table id="panel-goods" data-id="<?php echo count($data['view::_shop/calendar/one/similar']->childs); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <?php if ((Func::isShopMenu('shopcalendar/image?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
            <th class="tr-header-photo">Фото</th>
        <?php }?>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            <?php echo SitePageData::setPathReplace('type.form_data.shop_calendar.fields_title.name', SitePageData::CASE_FIRST_LETTER_UPPER); ?>
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::_shop/calendar/one/similar']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::_shop/calendar/one/similar']->childs) == 0){ ?>
    <div id="div-not-options-similar-goods" class="contacts-list-msg text-center margin-b-5">Значения не заданы</div>
<?php }?>
<div class="text-right" data-toggle="modal" data-target="#find-similar">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_catalog', 'tr_panel_catalog', 'div-not-options-similar-goods')"><i class="fa fa-fw fa-plus"></i> Добавить</button>
</div>