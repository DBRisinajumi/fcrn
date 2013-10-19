<?php
$this->breadcrumbs[Yii::t('FcrnModule.crud','Fcrn Currencies')] = array('admin');
$this->breadcrumbs[] = Yii::t('FcrnModule.crud_static', 'Create');
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('FcrnModule.crud','Fcrn Currency')?> <small><?php echo Yii::t('FcrnModule.crud_static','Create')?></h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
<?php
$this->renderPartial('_form', array(
'model' => $model,
'buttons' => 'create'));

?>

