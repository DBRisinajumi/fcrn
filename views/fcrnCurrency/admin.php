<?php
$this->breadcrumbs[] = Yii::t('FcrnModule.crud','Fcrn Currencies');


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('fcrn-currency-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<?php $this->widget("TbBreadcrumbs", array("links"=>$this->breadcrumbs)) ?>
<h1>
    <?php echo Yii::t('FcrnModule.crud', 'Fcrn Currencies'); ?> <small><?php echo Yii::t('FcrnModule.crud_static', 'Manage'); ?></small>
</h1>

<?php $this->renderPartial("_toolbar", array("model"=>$model)); ?>
<?php $this->widget('TbGridView',
    array(
        'id'=>'fcrn-currency-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'pager' => array(
        'class' => 'TbPager',
        'displayFirstAndLast' => true,
    ),
    'columns'=>array(
		'fcrn_id',
		'fcrn_code',
		'fcrn_hide',
        array(
            'class'=>'TbButtonColumn',
            'viewButtonUrl' => "Yii::app()->controller->createUrl('view', array('fcrn_id' => \$data->fcrn_id))",
            'updateButtonUrl' => "Yii::app()->controller->createUrl('update', array('fcrn_id' => \$data->fcrn_id))",
            'deleteButtonUrl' => "Yii::app()->controller->createUrl('delete', array('fcrn_id' => \$data->fcrn_id))",
        ),
    ),
)); ?>
