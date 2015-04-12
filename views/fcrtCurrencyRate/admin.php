<?php
$this->setPageTitle(Yii::t('FcrnModule.crud', 'Fcrt Currency Rates'));
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t("FcrnModule.crud_static","Load"),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             //'visible'=>(Yii::app()->user->checkAccess('Company.*') 
             //        || Yii::app()->user->checkAccess('D2company.CcmpCompany.Create'))
        )); 
        ?>
        </div>
        <div class="btn-group">
            <h1>
                <i class="icon-dollar"></i>
                <i class="icon-eur"></i>
                <?php echo Yii::t('FcrnModule.crud', 'Fcrt Currency Rates'); ?>           
            </h1>
        </div>
        <div class="btn-group">
        <?php 
//        $this->widget("bootstrap.widgets.TbButton", array(
//            "label" => Yii::t("D2companyModule.crud_static", "Export"),
//            "url" => array("admin","export" => " xls"),
//            'size'=>'large',
//            'type'=>'success',
//            "visible" => Yii::app()->user->checkAccess("Company.*"),
//            //"htmlOptions"=>array("class"=>"export-button")
//         ));
        ?>
        </div>        
    </div>
</div>
<?php
$this->widget('TbGridView', array(
    'id' => 'fcrt-currency-rate-grid',
    'dataProvider' => $model->search(),
    'template' => '{items}{pager}{summary}',
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
//        array(
//            'class' => 'TbButtonColumn',
//            'viewButtonUrl' => "Yii::app()->controller->createUrl('view', array('fcrt_id' => \$data->fcrt_id))",
//            'updateButtonUrl' => "Yii::app()->controller->createUrl('update', array('fcrt_id' => \$data->fcrt_id))",
//            'deleteButtonUrl' => "Yii::app()->controller->createUrl('delete', array('fcrt_id' => \$data->fcrt_id))",
//        ),
    ),
));

