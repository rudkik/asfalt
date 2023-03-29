<tr class="total">
    <td class="text-right" colspan="8">
        Итого:
    </td>
    <?php foreach ($data->additionDatas['works'] as $child) { ?>
        <td class="text-right">
            <?php echo Arr::path($data->additionDatas['work_quantities'], $child->id, ''); ?>
        </td>
    <?php } ?>
</tr>