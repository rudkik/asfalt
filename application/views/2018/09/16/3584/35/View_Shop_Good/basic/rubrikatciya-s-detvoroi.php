<?php $children = trim($data->additionDatas['view::View_Shop_Goods\group\basic\rubrikatciya-s-detvoroi']); ?>
<?php if (empty($children)){ ?>
    <li class="highlight menu-item animate-dropdown">
        <a title="<?php echo $data->values['name']; ?>" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
    </li>
<?php }else{ ?>
    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
        <a title="<?php echo $data->values['name']; ?>" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#"><?php echo $data->values['name']; ?> <span class="caret"></span></a>
        <ul role="menu" class=" dropdown-menu">
            <li class="menu-item menu-item-object-static_block animate-dropdown">
                <div class="yamm-content">
                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                        <div class="kc-col-container">
                            <div class="kc_single_image">
                                <img src="<?php echo $data->values['image_path']; ?>" class="" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row yamm-content-row">
                        <?php echo $children; ?>
                    </div>
                </div>
            </li>
        </ul>
    </li>
<?php } ?>