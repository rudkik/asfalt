<div class="row">
    <div class="col-md-4">
        <?php
        $n = count($data['view::View_Shop_New/-portfolio-portfolio']->childs);
        $arr = array(
            1 => array(),
            2 => array(),
            3 => array(),
        );
        $i = 1;
        foreach ($data['view::View_Shop_New/-portfolio-portfolio']->childs as $value){
            switch ($n){
                case 1:
                case 2:
                case 3:
                    $arr[$i][] = $value->str;
                    break;
                case 4:
                    if($i < 3){
                        $arr[1][] = $value->str;
                    }else{
                        $arr[$i - 1][] = $value->str;
                    }
                    break;
                case 5:
                    if($i < 3){
                        $arr[1][] = $value->str;
                    }elseif($i < 4){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 6:
                    if($i < 3){
                        $arr[1][] = $value->str;
                    }elseif($i < 5){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 7:
                case 8:
                    if($i < 4){
                        $arr[1][] = $value->str;
                    }elseif($i < 6){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 9:
                case 10:
                    if($i < 5){
                        $arr[1][] = $value->str;
                    }elseif($i < 7){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 11:
                    if($i < 5){
                        $arr[1][] = $value->str;
                    }elseif($i < 8){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 12:
                case 13:
                    if($i < 6){
                        $arr[1][] = $value->str;
                    }elseif($i < 9){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 14:
                    if($i < 6){
                        $arr[1][] = $value->str;
                    }elseif($i < 10){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
                case 15:
                case 16:
                    if($i < 7){
                        $arr[1][] = $value->str;
                    }elseif($i < 11){
                        $arr[2][] = $value->str;
                    }else{
                        $arr[3][] = $value->str;
                    }
                    break;
            }
            $i++;
        }

        foreach ($arr as $col){
            foreach ($col as $value) {
                echo $value;
            }
            echo '</div><div class="col-md-4">';
        }
        ?>
    </div>
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