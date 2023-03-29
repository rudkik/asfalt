<?php
$languageIDs = Arr::path($siteData->operation->getAccessArray(), 'language_ids', NULL);
if (!is_array($languageIDs) || (empty($languageIDs))) {
    $languageIDs = $siteData->shop->getLanguageIDsArray();
}
if(count($languageIDs) > 1){?>
    <td>
        <ul class="list-inline tr-button delete">
            <?php
            $languages = trim($siteData->replaceDatas['view::language/list/tr-translate']);
            foreach ($languageIDs as $language) {
                if ((Arr::path($data->values['is_translates'], $language, 0) == 1)){
                    $languages = str_replace('#class#'.$language, 'link-blue',
                        str_replace('#status#'.$language, 'есть', $languages));
                }else{
                    $languages = str_replace('#class#'.$language, 'link-red',
                        str_replace('#status#'.$language, 'нет', $languages));
                }
            }
            echo $languages = str_replace('_id_', $data->id, $languages);
            ?>
        </ul>
    </td>
<?php } ?>