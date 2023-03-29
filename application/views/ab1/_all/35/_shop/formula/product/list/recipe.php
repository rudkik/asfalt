<table class="table table-hover table-db table-tr-line" >
    <thead>
    <tr>
        <th class="tr-header-public">
            <span>
                <input name="set-is-public-all" type="checkbox" class="minimal" checked  href="<?php echo Func::getFullURL($siteData, '/shopformulaproduct/save');?>">
            </span>
        </th>
        <th class="width-120">Дата создания</th>
        <th class="width-130">Срок действия от</th>
        <th class="width-130">Срок действия до</th>
        <th class="width-120">№ приказа</th>
        <th class="width-120">Дата приказа</th>
        <th>Вид рецепта</th>
        <th>Примечание</th>
        <th style="width: 310px;"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['view::_shop/formula/product/one/recipe']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>

