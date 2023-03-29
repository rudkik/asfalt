<select class="form-control select2" style="width: 100%;" name="data_language_id">
    <?php
    foreach ($data['view::language/one/data']->childs as $value){
        echo $value->str;
    }
    ?>
</select>
