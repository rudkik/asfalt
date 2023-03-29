<header class="header-about">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2><?php echo $data->values['name']; ?></h2>
            </div>
            <div class="col-md-4 box-a">
                <a class="a-green" href="<?php echo $siteData->urlBasic;?>/about">Перейти в раздел</a>
            </div>
        </div>

        <div><?php echo Arr::path($data->values['options'], 'info', ''); ?></div>
        <div id="carousel-2" class="carousel slide" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="row">
                        <?php
                        $files = Arr::path($data->values, 'files', array());
                        $rows = 3;
                        $i = 0;
                        foreach($files as $index => $file) {
                            if((! is_array($file)) || (!key_exists('type', $file))){
                                continue;
                            }
                            $tуpe = intval(Arr::path($file, 'type', 0));
                            if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
                                $i++;
                                if($i == $rows + 1){
                                    echo '</div></div><div class="item"><div class="row">';
                                    $i = 1;
                                }
                                ?>
                                <div class="col-md-4">
                                    <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath(Arr::path($file, 'file', ''), 440, 0);?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#carousel-2" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Предыдущий</span>
            </a>
            <a class="right carousel-control" href="#carousel-2" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Следующий</span>
            </a>
        </div>
    </div>
</header>