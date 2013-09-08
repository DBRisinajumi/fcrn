<?php
$this->breadcrumbs[Yii::t('dbrisinajumi.fcrn','Fcrt Currency Rates')] = array('admin');
$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id'=>$model->{$model->tableSchema->primaryKey});
$this->breadcrumbs[] = Yii::t('dbrisinajumi.fcrn', 'Update');
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('dbrisinajumi.fcrn','Fcrt Currency Rate')?> <small><?php echo Yii::t('dbrisinajumi.fcrn','Update')?> #<?php echo $model->fcrt_id ?></small></h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
<?php
$this->renderPartial('_form', array(
'model'=>$model));
?>
