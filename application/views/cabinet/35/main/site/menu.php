<li <?php if($siteData->url != '/site/css'){echo 'class="menu-left"';} ?>>
    <a href="<?php echo Func::getFullURL($siteData, '/site/css', array('id' => 'id')); ?>"><i class="fa fa-files-o text-red"></i>
        <span>Файлы CSS</span>
    </a>
</li>
<li <?php if($siteData->url != '/site/urls'){echo 'class="menu-left"';} ?>>
    <a href="<?php echo Func::getFullURL($siteData, '/site/urls', array('id' => 'id')); ?>"><i class="fa fa-reorder text-red"></i>
        <span>Ссылки</span>
    </a>
</li>
<li <?php if($siteData->url != '/site/languages'){echo 'class="menu-left"';} ?>>
    <a href="<?php echo Func::getFullURL($siteData, '/site/languages', array('id' => 'id')); ?>"><i class="fa fa-language text-red"></i>
        <span>Языки</span>
    </a>
</li>
<?php echo trim($siteData->globalDatas['view::site/language/list/menu']); ?>