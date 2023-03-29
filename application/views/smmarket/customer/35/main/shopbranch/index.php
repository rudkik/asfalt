<div class="header-menu">
    <div class="container">
        <nav class="navbar navbar-default navbar-static" role="navigation" id="menu-top">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#menu-top .bs-example-js-navbar-collapse">
                    <span class="sr-only">Переключить навигацию</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse bs-example-js-navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav">
                    <?php echo trim($data['view::shopgoodcatalogs/menu']); ?>
                </ul>
            </div>
        </nav>
    </div>
</div>
<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<div class="body-partners-shop">
	<div class="container">
		<h1>Поставщики</h1>
		<?php echo trim($data['view::shopbranches/index']); ?>
	</div>
</div>