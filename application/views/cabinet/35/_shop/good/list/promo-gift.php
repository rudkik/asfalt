<table id="panel-goods-gift" data-id="<?php echo count($data['view::_shop/good/one/promo-gift']->childs); ?>" class="table table-hover table-db margin-b-5">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Товар / услуга
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-price">Цена</th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::_shop/good/one/promo-gift']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::_shop/good/one/promo-gift']->childs) == 0){ ?>
    <div id="div-not-options-gift" class="contacts-list-msg text-center margin-b-5">Товары / услуги не заданы</div>
<?php }?>
<div class="text-right" data-toggle="modal" data-target="#find-promo-gift">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_catalog', 'tr_panel_catalog', 'div-not-options-gift')"><i class="fa fa-fw fa-plus"></i> Добавить товар / услуги</button>
</div>

