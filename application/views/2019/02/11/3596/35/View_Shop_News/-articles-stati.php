<div class="row">
<?php
$i = 1;
foreach ($data['view::View_Shop_New\-articles-stati']->childs as $child){
    ?>
    <?php if ($i == 1){?>
    </div>
    <div class="row">
    <?php }?>
    <?php if ($i != 2){?>
        <div class="col-md-6">
    <?php }?>
    <div class="box-article article<?php echo $i; ?>">
        <?php if ($i != 2){?>
            <div class="media-left">
                <div class="box-img">
                    <a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $child->values['name_url']; ?>">
                        <?php if ($i == 1){?>
                            <img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($child->values['files'], 307, 222, $child->values['image_path']), 307, 222); ?>" alt="<?php echo htmlspecialchars($child->values['name'], ENT_QUOTES);?>">
                        <?php }else{?>
                            <img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($child->values['files'], 620, 322, $child->values['image_path']), 620, 322); ?>" alt="<?php echo htmlspecialchars($child->values['name'], ENT_QUOTES);?>">
                        <?php }?>
                    </a>
                    <?php if ($child->values['shop_table_rubric_id'] > 0){?>
                        <div class="tag">
                            <?php echo $child->getElementValue('shop_table_rubric_id', 'name'); ?>
                            <div class="corner-yellow-right"></div>
                        </div>
                    <?php }?>
                </div>
            </div>
        <?php }?>
            <div class="media-body">
                <div class="box-data">
                    <h3><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $child->values['name_url']; ?>"><?php echo $child->values['name']; ?></a></h3>
                    <div class="info">
                        <div class="date"><?php echo Helpers_DateTime::getDateFormatRus($child->values['created_at']); ?></div>
                    </div>
                </div>
            </div>
        <?php if ($i == 3){?>
        </div>
        <?php }?>
        <?php if ($i == 2){?>
                <div class="media-right">
                    <div class="box-img">
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/articles<?php echo $child->values['name_url']; ?>">
                            <img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($child->values['files'], 307, 222, $child->values['image_path']), 307, 222); ?>" alt="<?php echo htmlspecialchars($child->values['name'], ENT_QUOTES);?>">
                        </a>
                        <div class="tag">
                            <?php echo $child->getElementValue('shop_table_rubric_id', 'name'); ?>
                            <div class="corner-yellow-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
<?php
    $i++;
    if($i > 3){
        $i = 1;
    }
}
?>
<?php if (count($data['view::View_Shop_New\-articles-stati']->childs) % 3 == 1){?>
</div>
<?php }?>
</div>
<?php if($siteData->pages > 1) { ?>
    <ul class="box-pagination">
        <?php
        $arr = $_GET;
        unset($arr['rubric']);
        $arr['page'] = '';
        $url = str_replace('page=', 'page=$page$', $siteData->urlBasic . $siteData->url . $siteData->urlSEO . URL::query($arr, FALSE));

        // $page$ - в место него будет вставлен номер страницы
        // $url$ - в место ссылки

        // предыдущая страница
        $previous_active = '<li class="next"><a href="$url$"><img src="'.$siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/img/left.png"></a></li>';
        $previous_not_active = '';

        // следующая страница
        $next_active = '<li class="next"><a href="$url$"><img src="'.$siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/img/right.png"></a></li>';
        $next_not_active = '';

        // текушая страница
        $current_active = '<li class="active"><a href="$url$">$page$</a></li>';
        $current_not_active = '<li><a href="$url$">$page$</a></li>';

        // пропуск страниц
        $shift = '<li><span>...</span></li>';


        $page = $siteData->page;
        $pages = $siteData->pages;
        $limit = $siteData->limitPage;

        // вывод данных

        // вставляем предыдущую страницу
        if ($page > 1) {
            echo str_replace('$page$', $page - 1, str_replace('$url$', $url, $previous_active));
        } else {
            echo str_replace('$page$', '1', str_replace('$url$', $url, $previous_not_active));
        }

        // вставляем первую страницу
        if ($page == 1) {
            echo str_replace('$page$', '1', str_replace('$url$', $url, $current_active));
        } else {
            echo str_replace('$page$', '1', str_replace('$url$', $url, $current_not_active));
        }

        if ($pages < 10) {
            for ($i = 2; $i < $pages; $i++) {
                if ($i == $page) {
                    echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                } else {
                    echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                }
            }
        } else {
            if ($page > 4) {
                echo $shift;
            }

            if ($page < 5) {
                for ($i = 2; $i < 8; $i++) {
                    if ($i == $page) {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                    } else {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                    }
                }
            } elseif ($pages - $page < 4) {
                for ($i = $pages - 6; $i < $pages; $i++) {
                    if ($i == $page) {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                    } else {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                    }
                }
            } else {
                for ($i = $page - 2; $i <= $page + 2; $i++) {
                    if ($i == $page) {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_active));
                    } else {
                        echo str_replace('$page$', $i, str_replace('$url$', $url, $current_not_active));
                    }
                }
            }

            if ($pages - $page > 3) {
                echo $shift;
            }
        }

        // вставляем последнюю страницу
        if (($page <= $pages) &&($pages > 1))  {
            if ($page == $pages) {
                echo str_replace('$page$', $pages, str_replace('$url$', $url, $current_active));
            } else {
                echo str_replace('$page$', $pages, str_replace('$url$', $url, $current_not_active));
            }
        }

        // вставляем следующую страницу
        if ($page < $pages) {
            echo str_replace('$page$', $page + 1, str_replace('$url$', $url, $next_active));
        } else {
            echo str_replace('$page$', $pages, str_replace('$url$', $url, $next_not_active));
        }
        ?>
    </ul>
<?php } ?>
