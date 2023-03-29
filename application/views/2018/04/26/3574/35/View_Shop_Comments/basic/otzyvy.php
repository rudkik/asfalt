<?php if(count($data['view::View_Shop_Comment\basic\otzyvy']->childs) > 0){ ?>
    <div class="box-partners border-t-grey">
        <div class="box-title">
            <div class="pull-left">
                <h2>ОТЗЫВЫ ОТ КЛИЕНТОВ</h2>
            </div>
            <div class="pull-right">
                <a class="b-left" href="#carousel-message" role="button" data-slide="prev">
                </a>
                <a class="b-right" href="#carousel-message" role="button" data-slide="next">
                </a>
            </div>
        </div>
        <div id="carousel" class="carousel slide">
            <div class="carousel-inner">
                <?php
                $i = 1;
                foreach ($data['view::View_Shop_Comment\basic\otzyvy']->childs as $value){
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