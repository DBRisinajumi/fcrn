<?php
$this->breadcrumbs[Yii::t('dbrisinajumi.fcrn','Fcrn Currencies')] = array('admin');
$this->breadcrumbs[] = Yii::t('dbrisinajumi.fcrn', 'Create');
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('dbrisinajumi.fcrn','Fcrn Currency')?> <small><?php echo Yii::t('dbrisinajumi.fcrn','Create')?></h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
<?php
$this->renderPartial('_form', array(
'model' => $model,
'buttons' => 'create'));

?>

