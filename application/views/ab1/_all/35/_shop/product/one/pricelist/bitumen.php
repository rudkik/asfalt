<tr>
    <td class="text-right">#index#</td>
    <td><?php echo $data->values['name']; ?></td>
    <td class="text-right">
        <?php echo $data->values['price']; ?>
    </td>
    <td class="text-center">
        <?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']); ?>
    </td>
</tr>