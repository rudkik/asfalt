<p>
	<a class="url" href="<?php echo $siteData->urlBasicLanguage; ?>/<?php
    switch ($data->values['shop_table_catalog_id']){
        case 3924:
            echo 'departments';
            break;
        case 3923:
            echo 'about';
            break;
        case 3921:
            echo 'videos';
            break;
        case 3920:
            echo 'doctors';
            break;
        case 3919:
            echo 'recommendations';
        case 3918:
            echo 'articles';
            break;
        case 3917:
            echo 'sales';
            break;
        case 3914:
            echo 'services';
            break;
        case 3912:
            echo 'directions';
            break;
    }
    echo $data->values['name_url'];
    ?>"><?php echo $data->values['name']; ?></a>
</p>