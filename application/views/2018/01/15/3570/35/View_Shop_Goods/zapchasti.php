<div class="row">
<?php
$n = 3;
$i = 1;
foreach ($data['view::View_Shop_Good\zapchasti']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="row">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>
<div class="box-pagination">
    <ul class="pagination">
		<?php 
		if($siteData->pages > 0) {
			if(empty($urlData)) {
				$urlParams = $_GET;
				$urlParams['page'] = '';
				$url = str_replace('page=', 'page=$page$', $siteData->urlBasic . $siteData->url . URL::query($urlParams, TRUE));
			}else{
				$url = $urlData;
			}

			if(empty($urlAction)){
				$urlAction = 'href';
			}

			// $page$ - в место него будет вставлен номер страницы
			// $url$ - в место ссылки

			// предыдущая страница
			$previous_active = '<li class="paginate_button"><a href="$url$"><img src="'.$siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/img/previous.png"></a></li>';
			$previous_not_active = '';

			// следующая страница
			$next_active = '<li class="paginate_button"><a href="$url$"><img src="'.$siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/img/next.png"></a></li>';
			$next_not_active = '';

			// текушая страница
			$current_active = '<li class="paginate_button active"><a href="$url$">$page$</a></li>';
			$current_not_active = '<li class="paginate_button"><a href="$url$">$page$</a></li>';

			// пропуск страниц
			$shift = '<li class="paginate_button"><span>...</span></li>';

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
		}
		?>
	</ul>
</div>