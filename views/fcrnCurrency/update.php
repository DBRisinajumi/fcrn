<?php
$this->breadcrumbs[Yii::t('FcrnModule.crud','Fcrn Currencies')] = array('admin');
$this->breadcrumbs[$model->{$model->tableSchema->primaryKey}] = array('view','id'=>$model->{$model->tableSchema->primaryKey});
$this->breadcrumbs[] = Yii::t('FcrnModule.crud_static', 'Update');
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('FcrnModule.crud','Fcrn Currency')?> <small><?php echo Yii::t('FcrnModule.crud_static','Update')?> #<?php echo $model->fcrn_id ?></small></h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
<?php
$this->renderPartial('_form', array(
'model'=>$model));
?>
