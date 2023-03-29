<?php
if (empty($seoPrefix)) {
    $seoPrefixArr = '';
    $seoPrefix = '';
}else{
    $seoPrefixArr = $seoPrefix.'.';
    $seoPrefix = '['.$seoPrefix.']';
}
?>
<div class="row margin-b-10">
    <div class="col-md-12">
        <span>
            SEO-ссылка
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
        </span>
        <input type="text" name="name_url" class="form-control" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_url', ''), ENT_QUOTES); ?>" readonly>
    </div>
</div>
<div class="row margin-b-10">
    <div class="col-md-12">
        <span>
            Заголовок (title)
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            <div class="pull-right div-checkbox">
                <span class="span-checkbox">
                    <input data-name="is_title" name="seo<?php echo $seoPrefix; ?>[is_title]" <?php if (Arr::path($data->values, 'seo.'.$siteData->dataLanguageID.'.'.$seoPrefixArr.'is_title', '1') != 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                     Использовать автоматически созданное значение
                </span>
            </div>
        </span>
        <input type="text" name="seo<?php echo $seoPrefix; ?>[title]" class="form-control" <?php if (Arr::path($data->values, 'seo.'.$siteData->dataLanguageID.'.'.$seoPrefixArr.'is_title', '1') != 0) { echo 'disabled';} ?> value="<?php echo Helpers_SEO::getSEOOptionsDefault($tableName, $rootSEOName, 'title', $seoPrefixArr, $data, $siteData); ?>">
        <p style="margin-top: 2px;">
            <?php echo Helpers_SEO::getSEOAttrs($tableName, $siteData->languageID, $siteData->branchID > 0); ?>
        </p>
    </div>
</div>
<div class="row margin-b-10">
    <div class="col-md-12">
        <span>
            Ключевые слова (keywords)
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            <div class="pull-right div-checkbox">
                <span class="span-checkbox">
                    <input data-name="is_keywords" name="seo<?php echo $seoPrefix; ?>[is_keywords]" <?php if (Arr::path($data->values, 'seo.'.$siteData->dataLanguageID.'.'.$seoPrefixArr.'is_keywords', '1') != 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                     Использовать автоматически созданное значение
                </span>
            </div>
        </span>
        <input type="text" name="seo<?php echo $seoPrefix; ?>[keywords]" class="form-control" <?php if (Arr::path($data->values, 'seo.'.$siteData->dataLanguageID.'.'.$seoPrefixArr.'is_keywords', '1') != 0) { echo 'disabled';} ?> value="<?php echo Helpers_SEO::getSEOOptionsDefault($tableName, $rootSEOName, 'keywords', $seoPrefixArr, $data, $siteData); ?>">
        <p style="margin-top: 2px;">
            <?php echo Helpers_SEO::getSEOAttrs($tableName, $siteData->languageID, $siteData->branchID > 0); ?>
        </p>
    </div>
</div>
<div class="row margin-b-10">
    <div class="col-md-12">
        <span>
            Краткое описание (description)
            <a href="#"><i class="fa fa-fw fa-info text-blue"></i></a>
            <div class="pull-right div-checkbox">
                <span class="span-checkbox">
                    <input data-name="is_description" name="seo<?php echo $seoPrefix; ?>[is_description]" <?php if (Arr::path($data->values, 'seo.'.$siteData->dataLanguageID.'.'.$seoPrefixArr.'is_description', '1') != 0) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> type="checkbox" class="minimal">
                     Использовать автоматически созданное значение
                </span>
            </div>
        </span>
        <textarea name="seo<?php echo $seoPrefix; ?>[description]" rows="2" class="form-control" <?php if (Arr::path($data->values, 'seo.'.$siteData->dataLanguageID.'.'.$seoPrefixArr.'is_description', '1') != 0) { echo 'disabled';} ?>><?php echo Helpers_SEO::getSEOOptionsDefault($tableName, $rootSEOName, 'description', $seoPrefixArr, $data, $siteData); ?></textarea>
        <p style="margin-top: 2px;">
            <?php echo Helpers_SEO::getSEOAttrs($tableName, $siteData->languageID, $siteData->branchID > 0); ?>
        </p>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('input[data-name="is_title"], input[data-name="is_keywords"], input[data-name="is_description"]').on('ifChecked', function (event) {
            $(this).parent().parent().parent().parent().parent().children('input, textarea').attr('disabled', '');
        }).on('ifUnchecked', function (event) {
            $(this).parent().parent().parent().parent().parent().children('input, textarea').removeAttr('disabled');
        });
    });
</script>