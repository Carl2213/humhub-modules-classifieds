<?php


use humhub\modules\classifieds\models\Category;
use humhub\modules\classifieds\models\SharedObject;
use yii\bootstrap\ActiveForm;
use humhub\widgets\RichtextField;
use humhub\modules\file\widgets\FilePreview;
use humhub\modules\file\widgets\UploadButton;
use humhub\modules\file\widgets\ShowFiles;
use yii\helpers\Html;


/**
 * View to add or modify an object
 *
 * @var Category[] $categories
 * @var SharedObject $object
 * @var \humhub\modules\content\models\ContentContainer $contentContainer
 */

humhub\modules\classifieds\Assets::register($this);
?>


<div class="panel panel-default">

   

    <!-- Body -->
    <div class="panel-body">

		 <?php
                      //"title" should be replaced with the required field name:
                       //to do: check if it is possible to chose one specific table instead of title
                     echo Html::textInput("name", "",
                     array('name' => 'contentForm_name', 'class' => 'form-control autosize contentForm', 'rows' => '1', "placeholder" => "Name")); ?>
					 
					  <?php
                      //"title" should be replaced with the required field name:
                       //to do: check if it is possible to chose one specific table instead of title
                     echo Html::textInput("description", "",
                     array('description' => 'contentForm_description', 'class' => 'form-control autosize contentForm', 'rows' => '3', "placeholder" => "Description")); ?>
    
    </div>
</div>