<?php

humhub\modules\classifieds\Assets::register($this);
use humhub\modules\classifieds\models\category;
use humhub\compat\CActiveForm;
use yii\helpers\Html;

/**
 * View to add or edit a category
 * @var Category $category;
 */
?>


<div class="panel panel-default">
    <?php if ($category->isNewRecord) : ?>
        <div class="panel-heading"><strong><?= Yii::t('ClassifiedsModule.base', 'Add') ?></strong> <?= Yii::t('ClassifiedsModule.base', 'Category') ?></div>
    <?php else: ?>
        <div class="panel-heading"><strong><?= Yii::t('ClassifiedsModule.base', 'Edit') ?></strong> <?= Yii::t('ClassifiedsModule.base', 'Category') ?></div>
    <?php endif; ?>

    <div class="panel-body">

        <?php
        $form = CActiveForm::begin();
        $form->errorSummary($category);
        ?>

        <div class="form-group">
            <?php
            //Field with the category's name
            echo $form->labelEx($category, 'Name');
            echo $form->textField($category, 'name', array('class' => 'form-control'));
            echo $form->error($category, 'name'); ?>
        </div>


       <div><?php echo Html::submitButton('Save', array('class' => 'btn btn-primary')); ?>
	
        <?php CActiveForm::end();

        ?>
		<button class="btn btn-primary" onclick="goBack()"><?= Yii::t('ClassifiedsModule.base', 'Back') ?></button></div>
	



<script>
function goBack() {
    window.history.back();
}
</script>
		
    </div>
</div>