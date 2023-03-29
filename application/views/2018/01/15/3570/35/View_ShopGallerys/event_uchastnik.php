<?php if(count($data['view::View_ShopGallery\event_uchastnik']->childs) > 0){ ?>
    <section class="tz-speakers">
    <div class="row">
        <div class="col-md-9" style="float: none; margin: 0 auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <h3 class="tz-speaker-title">
                        Спикеры
                    </h3>
                </div>
            </div>
			<div class="row">
                <?php
                $n = 4;
                $i = 1;
                foreach ($data['view::View_ShopGallery\event_uchastnik']->childs as $value){
                    if($i == $n + 1){
                        echo "</div><div class=\"row\">";
                        $i = 1;
                    }
                    $i++;

                    echo $value->str;
                }
                ?>
			</div>
        </div>
    </div>
<?php } ?>