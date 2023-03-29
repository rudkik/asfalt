<section class="section--1" style="background-image: url('<?php echo Func::addSiteNameInFilePath($data->values['image_path'], $siteData); ?>');">
    <div class="container">
        <div class="row no-gutters">
            <div class="scrollme">
                <div class="scrollme__inner">
                    <span>Крути вниз</span>
                    <span class="scrollme__line"></span>
                </div>
            </div>
            <div class="col-12 col-md-11 offset-md-1 section--1__rel">
                <div class="section--1__abs--top">
                    <div class="section-number">
                        01
                    </div>
                </div>
                <h2 class="title d-none d-md-block">
                  <span class="title__row title__row--minp">
                    <?php echo Arr::path($data->values['options'], 'title_one', ''); ?>
                  </span>
                  <span class="title__row title__row--minp">
                     <?php echo Arr::path($data->values['options'], 'title_two', ''); ?>
                  </span>
                </h2>

                <h2 class="title d-md-none">
                  <span class="title__row title__row--minp">
                    <?php echo Arr::path($data->values['options'], 'title_one', ''); ?>

<!--
                    <?php 
                    $explodedString1 = explode(" " ,Arr::path($data->values['options'], 'title_one', ''));
                    for ($i=0; $i < count($explodedString1) - 1; $i++) { 
                        echo ($i !== count($explodedString1) - 2) ? "$explodedString1[$i] " : $explodedString1[$i];
                    } ?>
-->
                  </span>
                  <span class="title__row title__row--minp title__row__nowhitespace">
                     <?php echo Arr::path($data->values['options'], 'title_two', ''); ?>
<!--
                    <?php
                    echo $explodedString1[count($explodedString1) - 1]." ";
                    $explodedString2 = explode(" " ,Arr::path($data->values['options'], 'title_two', ''));
                    for ($i=0; $i < count($explodedString2) - 1; $i++) { 
                        echo ($i !== count($explodedString2) - 2) ? "$explodedString2[$i] " : $explodedString2[$i];
                    } ?>
-->
                  </span>
<!--
                  <span class="title__row title__row--minp">
                    <?php echo $explodedString2[count($explodedString2) - 1]; ?>
                  </span>
-->
                </h2>
                <style> 
	                .title__row__nowhitespace {
		                white-space: normal !important;
	                }
                </style>
                <div class="section--1__abs--bottom">
                    <a href="#form_new_address" class="btn btn--p-medium">
                        <?php echo Arr::path($data->values['options'], 'button', ''); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>