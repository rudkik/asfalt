<?php if(count($data['view::View_Shop_Gallery\-slaider-na-glavnoi']->childs) > 0){ ?>
    <div class="box-carousels">
        <div id="carousel-main" class="carousel slide" data-ride="carousel" data-interval="15000">
            <div class="carousel-inner">
                <?php
                $i = 1;
                foreach ($data['view::View_Shop_Gallery\-slaider-na-glavnoi']->childs as $value){
                    if ($i == 1){
                        $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
                        $i++;
                    }
                    echo $value->str;
                }
                ?>
            </div>
            <a class="left carousel-control" href="#carousel-main" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Предыдущий</span>
            </a>
            <a class="right carousel-control" href="#carousel-main" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Следующий</span>
            </a>
        </div>
    </div>
<?php } ?>