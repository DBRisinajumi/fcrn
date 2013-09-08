<?php
$this->breadcrumbs[Yii::t('dbrisinajumi.fcrn','Fcrn Currencies')] = array('admin');
$this->breadcrumbs[] = $model->fcrn_id;
?>
<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('dbrisinajumi.fcrn','Fcrn Currency')?> <small><?php echo Yii::t('dbrisinajumi.fcrn','View')?> #<?php echo $model->fcrn_id ?></small></h1>



<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>

<h2>
    <?php echo Yii::t('dbrisinajumi.fcrn','Data')?></h2>

<p>
    <?php
    $this->widget('TbDetailView', array(
    'data'=>$model,
    'attributes'=>array(
            'fcrn_id',
        'fcrn_code',
        'fcrn_hide',
),
        )); ?></p>


<h2>
    <?php echo Yii::t('dbrisinajumi.fcrn','Relations')?></h2>

<div class='well'>
    <div class='row'>
<div class='span3'><?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>'fcrtCurrencyRates', 'icon'=>'icon-list-alt', 'url'=> array('fcrtCurrencyRate/admin')),
                array('icon'=>'icon-plus', 'url'=>array('fcrtCurrencyRate/create', 'FcrtCurrencyRate' => array('fcrt_fcrn_id'=>$model->{$model->tableSchema->primaryKey}))),
        ),
    )); ?></div><div class='span8'>
<?php
    echo '<span class=label>CHasManyRelation</span>';
    if (is_array($model->fcrtCurrencyRates)) {

        echo CHtml::openTag('ul');
            foreach($model->fcrtCurrencyRates as $relatedModel) {

                echo '<li>';
                echo CHtml::link($relatedModel->fcrt_date, array('fcrtCurrencyRate/view','fcrt_id'=>$relatedModel->fcrt_id), array('class'=>''));

                echo '</li>';
            }
        echo CHtml::closeTag('ul');
    }
?></div>
     </div> <!-- row -->
</div> <!-- well -->
