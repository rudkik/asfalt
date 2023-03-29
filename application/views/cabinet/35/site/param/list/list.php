<table class="table table-hover table-db table-tr-line" style="max-width: 500px;">
    <tbody><tr>
        <th class="tr-header-public">
            <span>
                <input data-action="set-boolean" type="checkbox" class="minimal">
            </span>
        </th>
        <th class="tr-header-rubric">Название</th>
        <th class="tr-header-rubric">Значение</th>
        <th class="tr-header-rubric">Название</th>
    </tr>
    <?php
    foreach ($data['view::site/param/one/list']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>