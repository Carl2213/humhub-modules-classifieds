<?php
use humhub\modules\classifieds\models\category;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\file\widgets\FilePreview;
use humhub\modules\file\widgets\UploadButton;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\widgets\Button;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
<div class="panel-heading">
		<!-- Buttons -->
        <div style='text-align:center'>
            <?php echo
//Back Button
	" <a class='btn btn-default btn-sm pull-right' style='float:right;padding: 5px' data-ui-loader href='" .
        $contentContainer->createUrl('/classifieds/classifieds/') .
        "'><i class='fas fa-arrow-left'></i>&nbsp;&nbsp;Back</a>"; ?>
            
        </div></div>
    <!-- Header-->
    <?php if ($object->isNewRecord) : ?>
        <div class="panel-heading"><strong>New</strong> Listing</div>
        <?php $backUrl = $contentContainer->createUrl('/classifieds/classifieds/object-page', ['object_id' => $object->id, 'searchCategory' => -1]); ?>
    <?php else: ?>
        <div class="panel-heading"><strong>Edit</strong> Listing</div>
        <?php $backUrl = $contentContainer->createUrl('/classifieds/classifieds/object-page', ['object_id' => $object->id, 'searchCategory' => -1]); ?>
    <?php endif; ?>

    <!-- Body -->
    <div class="panel-body">

		
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($object, 'name') ?>
	  <?php
            //Formatting the categories into a simple array (id=>name) for the dropdown
            $catDropArray = array();
            foreach ($categories as $cat) {
                $catDropArray[$cat->id] = $cat->name;
            }

            //Category choice dropd own
            echo $form->field($object, 'category')->dropDownList($catDropArray)->label('Category');?>
    <?php echo $form->field($object, 'description')->textArea(['rows' => 3])->hint('Physical state, model number, year. The more details the better'); ?>
	<?php echo $form->field($object, 'location')->textArea(['rows' => 3])->hint('Pick up location'); ?>
	<?php echo $form->field($object, 'contact')->textArea(['rows' => 1])->hint('How to best reach you'); ?>
	<?php echo $form->field($object, 'price')->textInput(['type' => 'number', 'value' => '0.00'], ['rows' => 1])->hint('Set to 0 for free items or trades'); ?>


        

      
		
		 <div class="comment-buttons-classifieds">
        <?= UploadButton::widget([
            'id' => 'object_upload_' . $object->id,
            'model' => $object,
            'dropZone' => '#object_' . $object->id,
            'preview' => '#object_upload_preview_' . $object->id,
            'progress' => '#object_upload_progress_' . $object->id,
            'max' => Yii::$app->getModule('content')->maxAttachedFiles
        ]);
        ?>

      <?php echo Html::submitButton('Save', array('class' => 'btn btn-primary')); ?>
    </div>

    <div id="object_upload_progress_<?= $object->id ?>" style="display:none; margin:10px 0;"></div>

    <?= FilePreview::widget([
        'id' => 'object_upload_preview_' . $object->id,
        'options' => ['style' => 'margin-top:10px'],
        'model' => $object,
        'edit' => true
    ]);
    ?>
		
		
        <?php ActiveForm::end();

        ?>
    </div>
	
	
	
	</div>
</div>
