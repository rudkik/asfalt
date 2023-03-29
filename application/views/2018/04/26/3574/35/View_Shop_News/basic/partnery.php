<?php if(count($data['view::View_Shop_New\basic\partnery']->childs) > 0){ ?>
    <div class="box-partners">
        <div class="box-title">
            <div class="pull-left">
                <h2>Партнеры</h2>
            </div>
            <div class="pull-right">
                <a class="b-left" href="#carousel" role="button" data-slide="prev">
                </a>
                <a class="b-right" href="#carousel" role="button" data-slide="next">
                </a>
            </div>
        </div>
        <div id="carousel" class="carousel slide">
            <div class="carousel-inner">
                <?php
                $i = 1;
                foreach ($data['view::View_Shop_New\basic\partnery']->childs as $value){
                    if ($i == 1){
                        $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
                        $i++;
                    }
                    echo $value->str;
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>