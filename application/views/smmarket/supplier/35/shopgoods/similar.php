<table id="panel-goods" data-id="<?php echo count($data['view::shopgood/similar']->childs); ?>" class="table table-hover table-db margin-bottom-5px">
    <tr>
        <th class="tr-header-photo">Фото</th>
        <th>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </th>
        <th class="tr-header-price">Цена</th>
        <th class="tr-header-buttom-delete"></th>
    </tr>

    <?php
    foreach ($data['view::shopgood/similar']->childs as $value){
        echo $value->str;
    }
    ?>
</table>
<?php if (count($data['view::shopgood/similar']->childs) == 0){ ?>
    <div id="div-not-options-similar-goods" class="contacts-list-msg text-center margin-bottom-5px">Значения не заданы</div>
<?php }?>
<div class="text-right" data-toggle="modal" data-target="#find-similar">
    <button type="button" class="btn btn-warning" onclick="actionAddTR('body_panel_catalog', 'tr_panel_catalog', 'div-not-options-similar-goods')"><i class="fa fa-fw fa-plus"></i> Добавить товар / услугу</button>
</div>