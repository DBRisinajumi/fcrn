<div class="crud-form">

    <?php
    $this->widget('echosen.EChosen', array('target' => 'select')
    );
    ?>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'fcrt-currency-rate-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
    ));
    ?>
    <div class="row">
        <div class="span8"> <!-- main inputs -->
            <div class="form-horizontal">
                <div class="control-group">
                    <div class='control-label'>
                    </div>
                    <div class="controls">
                        <?php echo $form->errorSummary($model); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class='control-label'>
                        <?php echo $form->labelEx($model, 'fcrt_date'); ?>
                    </div>
                    <div class="controls">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'fcrt_date',
                            'language' => substr(Yii::app()->language, 0, strpos(Yii::app()->language, '_')),
                            'htmlOptions' => array('size' => 10),
                            'options' => array(
                                'showButtonPanel' => true,
                                'changeYear' => true,
                                'changeYear' => true,
                                'dateFormat' => 'yy-mm-dd',
                            ),
                                )
                        );
                        ;
                        ?>
                        <?php echo $form->error($model, 'fcrt_date'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <div class='control-label'>
                        <?php echo Yii::t('FcrnModule.crud', 'fcrtFcsr'); ?>
                    </div>
                    <div class="controls">
                        <?php
                        $this->widget(
                                '\GtcRelation', array(
                            'model' => $model,
                            'relation' => 'fcrtFcsr',
                            'fields' => 'fcsr_name',
                            'allowEmpty' => false,
                            'style' => 'dropdownlist',
                                )
                        )
                        ?>
                    </div>
                </div>




            </div>
        </div>



    </div> <!-- main inputs -->

    <?php $this->endWidget() ?>
</div>
