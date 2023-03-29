<?php $openPHP = '<?php';
$closePHP = '?>';
?>
<?php echo $openPHP; ?> $siteData->titleTop = '<?php echo $title; ?>'; <?php echo $closePHP; ?>

<form class="form-horizontal" action="<?php echo $openPHP; ?> echo Func::getFullURL($siteData, '/<?php echo $pathViewStr; ?>/save'); <?php echo $closePHP; ?>" method="post" style="padding-right: 5px;">
    <?php echo $openPHP; ?> echo trim($data['view::<?php echo $pathView; ?>/one/new']); <?php echo $closePHP; ?>

</form>
