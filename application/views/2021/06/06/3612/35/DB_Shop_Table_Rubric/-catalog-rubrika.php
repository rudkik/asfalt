<section class="text__header row">
	<?php if ($data->id > 0){ ?>
		<div class="title">
			<h1><?php echo $data->values['name']; ?></h1>
			<h4><?php echo Arr::path($data->values['options'], 'subject', ''); ?></h4>
		</div>
		<div class="text__block">
			<div class="mainText i">
				<?php echo $data->values['text']; ?>
			</div>
		</div>
	<?php }else{ ?>
		<div class="title">
			<h1>Поиск</h1>
			<h4><?php echo Request_RequestParams::getParamStr('name_lexicon'); ?></h4>
		</div>
	<?php } ?>

</section>
<?php echo trim($siteData->globalDatas['view::DB_Shop_Table_Rubrics\child']); ?>