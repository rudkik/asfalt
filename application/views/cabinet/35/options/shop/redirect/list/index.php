<form action="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopredirect/save" method="get">
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
    <table class="table table-hover table-db">
        <tr>
            <th>
                Старая ссылка
            </th>
            <th>
                Новая ссылка
            </th>
            <th class="tr-header-buttom"></th>
        </tr>
        <tbody id="box-redirects" data-index="<?php echo count($data['view::options/shop/redirect/one/index']->childs) + 1;?>">
        <?php
        foreach ($data['view::options/shop/redirect/one/index']->childs as $value) {
            echo $value->str;
        }
        ?>
        </tbody>
    </table>
    <div class="modal-footer">
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

<div id="box-redirect" hidden>
    <!--
    <tr>
        <td><input class="form-control" name="redirects[#index#][old]" value=""></td>
        <td><input class="form-control" name="redirects[#index#][new]" value=""></td>
        <td>
            <ul class="list-inline tr-button delete">
                <li><a href="" class="link-red text-sm" data-action="tr-delete"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            </ul>
        </td>
    </tr>
    -->
</div>