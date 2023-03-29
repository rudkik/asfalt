<table cellspacing="0" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td colspan="1">
            Отклик клиента <b><?php echo $client['name']; ?></b>
        </td>
    </tr>
    <?php foreach($client['options'] as $key => $value){?>
        <tr>
            <td>
                <?php echo $key; ?>
            </td>
            <td>
                <?php echo $value; ?>
            </td>
        </tr>
    <?php }?>
    <?php foreach($contacts as $contact){?>
    <tr>
        <td>
            <?php echo $contact['type']; ?>
        </td>
        <td>
            <?php echo $contact['name']; ?>
        </td>
    </tr>
    <?php }?>
    </tbody>
</table>