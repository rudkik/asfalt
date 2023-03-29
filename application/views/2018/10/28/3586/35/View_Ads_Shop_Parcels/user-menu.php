<?php
$statuses = array();
foreach ($data['view::View_Ads_Shop_Parcel\user-menu']->childs as $value){
    $arr = json_decode($value->str, TRUE);
    $statuses[$arr['parcel_status_id']] = $arr['count'];
}
?>
<li class="nav__item">
    <a href="<?php echo $siteData->urlBasic;?>/account" class="nav__link<?php if ($siteData->url == '/account'){echo ' current';}?>">Мой аккаунт</a>
</li>
<li class="nav__item">
    <a href="<?php echo $siteData->urlBasic;?>/account/expect" class="nav__link<?php if ($siteData->url == '/account/expect'){echo ' current';}?>">Ожидаемые (<?php echo Arr::path($statuses, 1, 0); ?>)</a>
</li>
<li class="nav__item">
    <a href="<?php echo $siteData->urlBasic;?>/account/stock" class="nav__link<?php if ($siteData->url == '/account/stock'){echo ' current';}?>">На складе (<?php echo Arr::path($statuses, 2, 0); ?>)</a>
</li>
<li class="nav__item">
    <a href="<?php echo $siteData->urlBasic;?>/account/sent" class="nav__link<?php if ($siteData->url == '/account/sent'){echo ' current';}?>">Отправлено (<?php echo Arr::path($statuses, 3, 0); ?>)</a>
</li>
<li class="nav__item">
    <a href="<?php echo $siteData->urlBasic;?>/account/delivered" class="nav__link<?php if ($siteData->url == '/account/delivered'){echo ' current';}?>">Доставлено (<?php echo Arr::path($statuses, 5, 0); ?>)</a>
</li>
<?php if($siteData->userID > 0){ ?>
    <li class="nav__item">
        <a href="<?php echo $siteData->urlBasic;?>/user/unlogin" class="nav__link"> Выход</a>
    </li>
<?php } ?>