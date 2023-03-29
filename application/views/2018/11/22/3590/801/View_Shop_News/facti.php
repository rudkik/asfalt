<?php if (count($data['view::View_Shop_New\facti']->childs) > 0) {?>
    <div class="background-2"></div>
    <div class="container">
        <div class="header-history history-center">
            <h2 class="objectTitle2">Facts</h2>
            <div class="line-red"></div>
            <div id="facti" class="row">
                <?php
                $i = 1;
                foreach ($data['view::View_Shop_New\facti']->childs as $value){
                    if($i == 2){
                        $value->str = str_replace('<div class="col-md-3">', '<div class="col-md-3 pull-right">', $value->str);
                        $i = 0;
                    }
                    $i++;
                    echo $value->str;
                }
                ?>
            </div>
        </div>
    </div>
<?php }?>