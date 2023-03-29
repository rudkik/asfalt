<div class="row">
    <?php
    $n = 2;
    $i = 1;
    $count = 0;
    foreach ($data['view::View_Shop_New/-articles-stati']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="row">';
            if($count != 6) {
                $i = 1;
            }
        }
        $i++;
        $count++;
        echo $value->str;
    }
    ?>
</div>
<?php if($siteData->pages > 1){  ?>
    <ul class="box-pagination">
        <?php
        $urlParams = $_GET;
        $urlParams['page'] = '';
        $url = str_replace('page=', 'page=$page$', $siteData->urlBasic . $siteData->url . URL::query($urlParams, FALSE));

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