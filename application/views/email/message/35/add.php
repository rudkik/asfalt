<table cellspacing="0" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td colspan="1">
            Сообщение от <b><?php echo $data['name']; ?></b>
        </td>
    </tr>
    <?php
    $options = Arr::path($data, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_message',
        Arr::path($data, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_message_chat', array()));

    foreach($options as $option){
        ?>
        <?php if($option['type'] == Model_Basic_Options::OPTIONS_TYPE_FILE || ! Func::_empty(Arr::path($data, 'options.'.$option['field'].'.file', ''))){?>
            <?php if(! Func::_empty(Arr::path($data, 'options.'.$option['field'].'.file', ''))){?>
                <tr>
                    <td>
                        <?php echo $option['title']; ?>
                    </td>
                    <td>
                        <?php echo Arr::path($data, 'options.'.$option['field'].'.file', ''); ?>
                    </td>
                </tr>
            <?php }?>
        <?php }else{?>
            <?php if(! Func::_empty(Arr::path($data, 'options.'.$option['field'], ''))){?>
                <tr>
                    <td>
                        <?php echo $option['title']; ?>
                    </td>
                    <td>
                        <?php echo Arr::path($data, 'options.'.$option['field'], ''); ?>
                    </td>
                </tr>
            <?php }?>
        <?php }?>
    <?php }?>
    <tr>
        <td>
            Сообщение
        </td>
        <td>
            <?php echo $data['text']; ?>
        </td>
    </tr>
    </tbody>
</table>