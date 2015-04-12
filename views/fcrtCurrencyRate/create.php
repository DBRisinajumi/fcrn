<?php
$this->setPageTitle(Yii::t('FcrnModule.crud', 'Load rate'));
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php
            $this->widget("bootstrap.widgets.TbButton", array(
                "icon" => "chevron-left",
                "size" => "large",
                "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
                "htmlOptions" => array(
                    "class" => "search-button",
                    "data-toggle" => "tooltip",
                    "title" => Yii::t("FcrnModule.crud_static", "Back"),
                )
            ));
            ?></div>
        <div class="btn-group">
            <h1>
                <i class="icon-dollar"></i>
                <i class="icon-eur"></i>
                <?php echo Yii::t('FcrnModule.crud', 'Load rate'); ?>
            </h1>
        </div>
    </div>
</div>

<?php
$this->renderPartial('_form', array(
    'model' => $model,
    'buttons' => 'create'));
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php 
            $this->widget("bootstrap.widgets.TbButton", array(
                "icon" => "chevron-left",
                "size" => "large",
                "url" => (isset($_GET["returnUrl"])) ? $_GET["returnUrl"] : array("{$this->id}/admin"),
                "htmlOptions" => array(
                    "class" => "search-button",
                    "data-toggle" => "tooltip",
                    "title" => Yii::t("FcrnModule.crud_static", "Back"),
                )
            ));
        
        ?></div>
        <div class="btn-group">

                <?php
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>Yii::t("FcrnModule.crud_static","Load"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('.crud-form form').submit();",
                       ),
                    ));
                    ?>
        </div>
    </div>
</div>
