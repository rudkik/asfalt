<?php if(count($data['view::View_Shop_Good\tovary']->childs) > 0){ ?>
<?php $isList = Request_RequestParams::getParamBoolean('is_list'); ?>
<div class="shop-control-bar">
    <div class="handheld-sidebar-toggle">
        <button type="button" class="btn sidebar-toggler">
            <i class="fa fa-sliders"></i>
            <span>Фильтр</span>
        </button>
    </div>
    <h2 class="woocommerce-products-header__title page-title">Товары</h2>
    <ul role="tablist" class="shop-view-switcher nav nav-tabs">
        <li class="nav-item">
            <a href="<?php echo $siteData->urlBasic.$siteData->url.URL::query(); ?>" title="Плитка" class="nav-link <?php if(!$isList){echo 'active';} ?>">
                <i class="tm tm-grid-small"></i>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $siteData->urlBasic.$siteData->url.URL::query(array('is_list' => TRUE)); ?>" title="Список" class="nav-link <?php if($isList){echo 'active';} ?>">
                <i class="tm tm-listing-large"></i>
            </a>
        </li>
    </ul>
    <?php if($siteData->pages > 20){ ?>
        <form class="form-techmarket-wc-ppp" method="get" action="<?php echo $siteData->urlBasic; ?>/catalogs">
            <div class="form-techmarket-wc-ppp">
                <select class="techmarket-wc-wppp-select c-select" onchange="this.form.submit()" name="limit_page">
                    <option value="20" <?php if($siteData->limitPage == 20){echo 'selected';} ?>>По 20 товаров</option>
                    <?php if($siteData->pages > 20){ ?>
                        <option value="40" <?php if($siteData->limitPage == 40){echo 'selected';} ?>>По 40 товаров</option>
                        <?php if($siteData->pages > 40){ ?>
                            <option value="100" <?php if($siteData->limitPage == 100){echo 'selected';} ?>>По 100 товаров</option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <input type="hidden" value="5" name="shop_columns">
                <input type="hidden" value="15" name="shop_per_page">
                <input type="hidden" value="right-sidebar" name="shop_layout">
            </div>
        </form>
    <?php } ?>
    <form class="woocommerce-ordering" method="get" action="<?php echo $siteData->urlBasic; ?>/catalogs">
        <div class="woocommerce-ordering">
            <select class="orderby" name="sort_by[]">
                <option value="name_asc">По названию</option>
                <option selected="selected" value="id_desc">По дате</option>
                <option value="price_asc">По цене: по возрастанию</option>
                <option value="price_desc">По цене: по убыванию</option>
            </select>
        </div>
    </form>
    <?php
    $urlParams = $_GET;
    $urlParams['page'] = '';
    $page = intval(Request_RequestParams::getParamInt('page'));
    if ($page < 1){
        $page = 1;
    }
    if($siteData->pages > $page){
        $url = str_replace('page=', 'page='.($page + 1), $siteData->urlBasic . $siteData->url . URL::query($urlParams, TRUE));
        ?>
    <nav class="techmarket-advanced-pagination">
        <a href="<?php echo $url; ?>" class="next page-numbers">→</a>
    </nav>
    <?php } ?>
</div>
<div class="tab-content">
    <div id="grid" class="tab-pane active" role="tabpanel">
        <div class="woocommerce <?php if(Request_RequestParams::getParamBoolean('is_list')){ ?>columns-1<?php }else{?>columns-5<?php }?>">
            <div class="products">
				<?php
                if(Request_RequestParams::getParamBoolean('is_load')) {
                    $n = count($data['view::View_Shop_Good\tovary']->childs);
                }else{
                    $n = 4;
                }
				$i = 1;
				foreach ($data['view::View_Shop_Good\tovary']->childs as $value){
				    if($i == 1){
                        $s = 'first';
                    }elseif ($i == $n){
                        $s = 'last';
                    }else{
                        $s = '';
                    }
					$i++;
					echo str_replace('#class#', $s, $value->str);
				}
				?>
            </div>
        </div>
    </div>
</div>
<div class="shop-control-bar-bottom">
    <?php if($siteData->pages > 20){ ?>
        <form class="form-techmarket-wc-ppp" method="get" action="<?php echo $siteData->urlBasic; ?>/catalogs">
            <select class="techmarket-wc-wppp-select c-select" onchange="this.form.submit()" name="limit_page">
                <option value="20" <?php if($siteData->limitPage == 20){echo 'selected';} ?>>По 20 товаров</option>
                <?php if($siteData->pages > 20){ ?>
                    <option value="40" <?php if($siteData->limitPage == 40){echo 'selected';} ?>>По 40 товаров</option>
                    <?php if($siteData->pages > 40){ ?>
                        <option value="100" <?php if($siteData->limitPage == 100){echo 'selected';} ?>>По 100 товаров</option>
                    <?php } ?>
                <?php } ?>
            </select>
            <input type="hidden" value="5" name="shop_columns">
            <input type="hidden" value="15" name="shop_per_page">
            <input type="hidden" value="right-sidebar" name="shop_layout">
        </form>
    <?php } ?>
    <?php if($siteData->pages > 1) { ?>
    <nav class="woocommerce-pagination">
        <ul class="page-numbers">
            <?php
            $urlParams = $_GET;
            $urlParams['page'] = '';
            $url = str_replace('page=', 'page=$page$', $siteData->urlBasic . $siteData->url . URL::query($urlParams, TRUE));

            // $page$ - в место него будет вставлен номер страницы
            // $url$ - в место ссылки

            // предыдущая страница
            $previous_active = '<li><a href="$url$" class="next page-numbers">←</a></li>';
            $previous_not_active = '';

            // следующая страница
            $next_active = '<li><a href="$url$" class="next page-numbers">→</a></li>';
            $next_not_active = '';

            // текушая страница
            $current_active = '<li><span class="page-numbers current">$page$</span></li>';
            $current_not_active = '<li><a href="$url$" class="page-numbers">$page$</a></li>';

            // пропуск страниц
            $shift = '<li><span class="page-numbers current">...</span></li>';

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
    </nav>
    <?php } ?>
</div>
<?php }else{ ?>
    <div class="shop-control-bar">
        <h2 class="woocommerce-products-header__title page-title">Поиск не дал результатов</h2>
    </div>
<?php } ?>