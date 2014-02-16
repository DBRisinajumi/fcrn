<div class="">
    <p class="alert">
        <?php echo Yii::t('FcrnModule.crud_static','Fields with <span class="required">*</span> are required.');?> 
    </p>


    <?php
    $this->widget('echosen.EChosen',
        array('target'=>'select')
    );
    ?>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
    'id'=>'fcrt-currency-rate-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    ));

    echo $form->errorSummary($model);

    ?>
 <div class="row">
     <div class="span8"> <!-- main inputs -->

    
    <div class="row-fluid input-block-level-container">
        <div class="span12">
            <?php echo $form->labelEx($model,'fcrt_date'); ?>

            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>$model,
								 'attribute'=>'fcrt_date',
								 'language'=> substr(Yii::app()->language,0,strpos(Yii::app()->language,'_')),
								 'htmlOptions'=>array('size'=>10),
								 'options'=>array(
									 'showButtonPanel'=>true,
									 'changeYear'=>true,
									 'changeYear'=>true,
									 'dateFormat'=>'yy-mm-dd',
									 ),
								 )
							 );
					; ?>
            <?php echo $form->error($model,'fcrt_date'); ?>
            <?php if('help.fcrt_date' != $help = Yii::t('FcrnModule.crud', 'help.fcrt_date')) { 
                echo "<span class='help-block'>{$help}</span>";            
} ?>
        </div>
    </div>


    <div class="row-fluid input-block-level-container">
        <div class="span12">
            <?php echo $form->labelEx($model,'fcrt_rate'); ?>
            <?php echo $form->textField($model,'fcrt_rate'); ?>
            <?php echo $form->error($model,'fcrt_rate'); ?>
            <?php if('help.fcrt_rate' != $help = Yii::t('FcrnModule.crud', 'help.fcrt_rate')) { 
                echo "<span class='help-block'>{$help}</span>";            
} ?>
        </div>
    </div>

    <div class="row-fluid input-block-level-container">
        <div class="span12">
        <label for="fcrtBaseFcrn"><?php echo Yii::t('FcrnModule.crud', 'fcrtBaseFcrn'); ?></label>
                <?php
                $this->widget(
					'\GtcRelation',
					array(
							'model' => $model,
							'relation' => 'fcrtBaseFcrn',
							'fields' => 'fcrn_code',
							'allowEmpty' => false,
							'style' => 'dropdownlist',
							'htmlOptions' => array(
								'checkAll' => 'all'),
							)
						)
              ?>
        </div>
    </div>

    </div> <!-- main inputs -->


    <div class="span4"> <!-- sub inputs -->

    </div> <!-- sub inputs -->
</div>


    <div class="form-actions">
        
    <?php
        echo CHtml::Button(Yii::t('FcrnModule.crud_static', 'Cancel'), array(
			'submit' => (isset($_GET['returnUrl']))?$_GET['returnUrl']:array('fcrtcurrencyrate/admin'),
			'class' => 'btn'
			));
        echo ' '.CHtml::submitButton(Yii::t('FcrnModule.crud_static', 'Save'), array(
            'class' => 'btn btn-primary'
            ));
    ?>
</div>

<?php $this->endWidget() ?>
</div> <!-- form -->