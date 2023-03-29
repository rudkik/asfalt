<div class="btn-group">
    <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><?php echo $siteData->dataLanguage->getName(); ?> <span class="fa fa-caret-down" style="margin-left: 10px;"></span></button>
        <ul class="dropdown-menu">
            <?php
            foreach ($data['view::language/one/translate']->childs as $value){
                echo $value->str;
            }
            ?>
        </ul>
    </div>
</div>
