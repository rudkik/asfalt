<li role="presentation" class="dropdown noclose <?php if((strpos($data->values['name'], '<br>') === FALSE) && (strpos($data->values['name'], '<br/>') === FALSE)){ echo 'one-line';} ?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <?php echo $data->values['name']; ?>
    </a>
    <?php echo $data->additionDatas['view::View_Shop_Goods\group\basic\menyu']; ?>
</li>