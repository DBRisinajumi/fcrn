<?php
$this->breadcrumbs[] = Yii::t('FcrnModule.crud', 'Fcrt Currency Rates');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('fcrt-currency-rate-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $this->widget("TbBreadcrumbs", array("links" => $this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('FcrnModule.crud', 'Fcrt Currency Rates'); ?> <small><?php echo Yii::t('FcrnModule.crud_static', 'Manage'); ?></small>
</h1>

<?php $this->renderPartial("_toolbar", array("model" => $model)); ?>
<?php
$this->widget('TbGridView', array(
    'id' => 'fcrt-currency-rate-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'pager' => array(
        'class' => 'TbPager',
        'displayFirstAndLast' => true,
    ),
    'columns' => array(
        //'fcrt_id',
        array(
            'name' => 'fcrt_fcsr_id',
            'value' => 'CHtml::value($data,\'fcrtFcsr.fcsr_name\')',
            'filter' => CHtml::listData(FcsrCourrencySource::model()->findAll(), 'fcsr_id', 'fcsr_name'),
        ),
        array(
            'name' => 'fcrt_base_fcrn_id',
            'value' => 'CHtml::value($data,\'fcrtBaseFcrn.fcrn_code\')',
            'filter' => CHtml::listData(FcrnCurrency::model()->findAll(), 'fcrn_id', 'fcrn_code'),
        ),
        array(
            'name' => 'fcrt_fcrn_id',
            'value' => 'CHtml::value($data,\'fcrtFcrn.fcrn_code\')',
            'filter' => CHtml::listData(FcrnCurrency::model()->findAll(), 'fcrn_id', 'fcrn_code'),
        ),
        'fcrt_date',
        'fcrt_rate',
        array(
            'class' => 'TbButtonColumn',
            'viewButtonUrl' => "Yii::app()->controller->createUrl('view', array('fcrt_id' => \$data->fcrt_id))",
            'updateButtonUrl' => "Yii::app()->controller->createUrl('update', array('fcrt_id' => \$data->fcrt_id))",
            'deleteButtonUrl' => "Yii::app()->controller->createUrl('delete', array('fcrt_id' => \$data->fcrt_id))",
        ),
    ),
));
?>
