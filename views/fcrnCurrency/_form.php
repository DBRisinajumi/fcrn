<div class="">
    <p class="alert">
        <?php echo Yii::t('dbrisinajumi.fcrn','Fields with <span class="required">*</span> are required.');?> 
    </p>


    <?php
    $this->widget('echosen.EChosen',
        array('target'=>'select')
    );
    ?>
    <?php
    $form=$this->beginWidget('CActiveForm', array(
    'id'=>'fcrn-currency-form',
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    ));

    echo $form->errorSummary($model);

    ?>
 <div class="row">
     <div class="span8"> <!-- main inputs -->

    
    <div class="row-fluid input-block-level-container">
        <div class="span12">
            <?php echo $form->labelEx($model,'fcrn_code'); ?>

            <?php echo $form->textField($model,'fcrn_code',array('size'=>3,'maxlength'=>3)); ?>
            <?php echo $form->error($model,'fcrn_code'); ?>
            <?php if('help.fcrn_code' != $help = Yii::t('dbrisinajumi.fcrn', 'help.fcrn_code')) { 
                echo "<span class='help-block'>{$help}</span>";            
} ?>
        </div>
    </div>


    <div class="row-fluid input-block-level-container">
        <div class="span12">
            <?php echo $form->labelEx($model,'fcrn_hide'); ?>
            <?php echo $form->textField($model,'fcrn_hide'); ?>
            <?php echo $form->error($model,'fcrn_hide'); ?>
            <?php if('help.fcrn_hide' != $help = Yii::t('dbrisinajumi.fcrn', 'help.fcrn_hide')) { 
                echo "<span class='help-block'>{$help}</span>";            
} ?>
        </div>
    </div>

    </div> <!-- main inputs -->


    <div class="span4"> <!-- sub inputs -->

    </div> <!-- sub inputs -->
</div>


    <div class="form-actions">
        
    <?php
        echo CHtml::Button(Yii::t('dbrisinajumi.fcrn', 'Cancel'), array(
			'submit' => (isset($_GET['returnUrl']))?$_GET['returnUrl']:array('fcrncurrency/admin'),
			'class' => 'btn'
			));
        echo ' '.CHtml::submitButton(Yii::t('dbrisinajumi.fcrn', 'Save'), array(
            'class' => 'btn btn-primary'
            ));
    ?>
</div>

<?php $this->endWidget() ?>
</div> <!-- form -->