<?php
//yiic message ../vendor/dbrisinajumi/fcrn/translation.php

return array(
    'sourcePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR ,  //root dir of all source
    //'sourcePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',  //root dir of all source
    'messagePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR .'messages',  //module of message translations
    'languages'  => array('lv',),  //array of lang codes to translate to, e.g. es_mx
    'fileTypes' => array('php',), //array of extensions no dot all others excluded
    //'exclude' => array('.svn',),  //list of paths or files to exclude
    'translator' => 'Yii::t',  //this is the default but lets be complete
);

?>
