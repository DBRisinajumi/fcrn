<?php
$this->breadcrumbs[Yii::t('FcrnModule.crud','Fcrt Currency Rates')] = array('admin');
$this->breadcrumbs[] = Yii::t('FcrnModule.crud_static', 'Create');
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('FcrnModule.crud','Fcrt Currency Rate')?> <small><?php echo Yii::t('FcrnModule.crud_static','Create')?></h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
<?php
$this->renderPartial('_form', array(
'model' => $model,
'buttons' => 'create'));

?>

