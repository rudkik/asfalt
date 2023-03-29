<?php
if(!key_exists('id', $_GET)) {
    $_GET['id'] = $data->values['id'];
}
?>
<span class="about__switch__company">
    <label for="company-<?php echo $data->values['id']; ?>" class="about__switch__company__title">
        <a href="<?php echo $siteData->urlBasic; ?>/about?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a>
    </label>
</span>