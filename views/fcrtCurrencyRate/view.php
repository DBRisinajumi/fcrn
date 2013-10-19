<?php
$this->breadcrumbs[Yii::t('FcrnModule.crud','Fcrt Currency Rates')] = array('admin');
$this->breadcrumbs[] = $model->fcrt_id;
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('FcrnModule.crud','Fcrt Currency Rate')?> <small><?php echo Yii::t('FcrnModule.crud_static','View')?> #<?php echo $model->fcrt_id ?></small></h1>



<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>

<h2>
    <?php echo Yii::t('FcrnModule.crud_static','Data')?></h2>

<p>
    <?php
    $this->widget('TbDetailView', array(
    'data'=>$model,
    'attributes'=>array(
            'fcrt_id',
        array(
            'name'=>'fcrt_fcrn_id',
            'value'=>($model->fcrtFcrn !== null)?'<span class=label>CBelongsToRelation</span><br/>'.CHtml::link($model->fcrtFcrn->fcrn_code, array('fcrnCurrency/view','fcrn_id'=>$model->fcrtFcrn->fcrn_id), array('class'=>'btn')):'n/a',
            'type'=>'html',
        ),
        'fcrt_date',
        'fcrt_rate',
),
        )); ?></p>


<h2>
    <?php echo Yii::t('FcrnModule.crud_static','Relations')?></h2>

