
<li class="dropdown">
    <a id="drop1" href="<?php echo $siteData->urlBasic; ?>/trade/catalog/index?id=<?php echo $data->values['id']; ?>" role="button" class="dropdown-toggle" aria-expanded="false" data-qaid="block-title"><?php echo $data->values['name']; ?></a>
    <?php if (!empty($data->child)){ ?>
    <div class="dropdown-menu" role="menu" aria-labelledby="drop1">
        <ul class="popup-menu-list">
            <?php foreach ($data->child as $child){ ?>
            <li role="presentation">
                <a role="menuitem" tabindex="-1" href="<?php echo $siteData->urlBasic; ?>/trade/catalog/index?id=<?php echo $child['id']; ?>" data-qaid="block-title">
                    <?php echo $child['name']; ?>
                </a>
            </li>
            <?php }?>
        </ul>
    </div>
    <?php }?>
</li>
