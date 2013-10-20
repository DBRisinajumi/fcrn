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
//            'fcrt_id',
        array(
            'name'=>'fcrt_base_fcrn_id',
            'value'=>$model->fcrtFcrn->fcrn_code,
        ),
        array(
            'name'=>'fcrt_fcrn_id',
            'value'=>$model->fcrtToFcrn->fcrn_code,
        ),
        'fcrt_fcsr_id',
        'fcrt_date',
        'fcrt_rate',
),
        )); ?></p>
<?
$r = Yii::app()->currency->getCurrencyRate(6,'2013-09-20');
if(!$r){
    echo Yii::app()->currency->sError;
}else{
    echo $r;
}