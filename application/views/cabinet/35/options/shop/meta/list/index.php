<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopmeta/save" method="get">
    <div class="modal-footer">
        <a href="javascript:actionAddTRRedirect('box-metas', 'box-meta', true)" class="btn btn-warning pull-left">
            <i class="fa fa-fw fa-plus"></i>
            Добавить
        </a>
        <a href="javascript:actionAddTRRedirect('box-metas', 'box-meta-yandex', true)" class="btn btn-info pull-left">
            <i class="fa fa-fw fa-plus"></i>
            Подтверждение прав Яндекс/Google
        </a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
    <table class="table table-hover table-db">
        <tr>
            <th>
                Название (<b>name</b>)
            </th>
            <th>
                Контент (<b>content</b>)
            </th>
            <th>
                Атрибут (<b>itemprop</b>)
            </th>
            <th>
                Атрибут (<b>property</b>)
            </th>
            <th>
                Дополнительные атрибуты
            </th>
            <th>
                Ссылка (<b>URL</b>)
            </th>
            <th class="tr-header-buttom"></th>
        </tr>
        <tbody id="box-metas" data-index="<?php echo count($data['view::options/shop/meta/one/index']->childs) + 1;?>">
        <?php
        foreach ($data['view::options/shop/meta/one/index']->childs as $value) {
            echo $value->str;
        }
        ?>
        </tbody>
    </table>
    <div class="modal-footer">
        <a href="javascript:actionAddTRRedirect('box-metas', 'box-meta', false)" class="btn btn-warning pull-left">
            <i class="fa fa-fw fa-plus"></i>
            Добавить
        </a>
        <a href="javascript:actionAddTRRedirect('box-metas', 'box-meta-yandex', false)" class="btn btn-info pull-left">
            <i class="fa fa-fw fa-plus"></i>
            Подтверждение прав Яндекс/Google
        </a>
        <div hidden>
            <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
            <?php if($siteData->branchID > 0){ ?>
                <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
            <?php } ?>
            <?php if($siteData->superUserID > 0){ ?>
                <input name="shop_id" value="<?php echo $siteData->shopID; ?>">
            <?php } ?>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>

<div id="box-meta" hidden>
    <!--
    <tr>
        <td><input class="form-control" name="metas[#index#][name]" value="" placeholder="Название (name)"></td>
        <td><input class="form-control" name="metas[#index#][content]" value="" placeholder="Контент (content)"></td>
        <td><input class="form-control" name="metas[#index#][itemprop]" value="" placeholder="Атрибут (temprop)"></td>
        <td><input class="form-control" name="metas[#index#][property]" value="" placeholder="Атрибут (property)"></td>
        <td><input class="form-control" name="metas[#index#][addition]" value="" placeholder="Дополнительные атрибуты"></td>
        <td><input class="form-control" name="metas[#index#][url]" value="" placeholder="Ссылка (URL)"></td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="" class="link-red text-sm" data-action="tr-delete"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>
<div id="box-meta-yandex" hidden>
    <!--
    <tr>
        <td><input class="form-control" name="metas[#index#][name]" value="" placeholder="Название (name)"></td>
        <td><input class="form-control" name="metas[#index#][content]" value="" placeholder="Контент (content)"></td>
        <td></td>
        <td></td>
        <td></td>
        <td><input class="form-control" name="metas[#index#][url]" value="" placeholder="Ссылка (URL)"></td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="" class="link-red text-sm" data-action="tr-delete"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>