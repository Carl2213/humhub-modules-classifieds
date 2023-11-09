<?php
humhub\modules\classifieds\Assets::register($this);
use humhub\modules\user\models\User;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\user\models\Profile;

humhub\modules\classifieds\Assets::register($this);

use \yii\helpers\Html;

/**
 * @param Profile $profil
 */

$noUserTd=false;

//This indicate that's it's not a search but the user's objects
$categoryId=-1;
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<!-- Buttons -->
		<div style='text-align:end;display:inline-block'>
		
	<a href="<?= $contentContainer->createUrl('/classifieds/classifieds/add-object') ?>" id="new-listing-btn"  class="btn btn-default btn-sm">
		<i class="fas fa-plus"></i>&nbsp;New Listing
	</a>
	</div>
	<div style="float:right;padding: 5px;margin-right:5px">
		<a class="btn btn-default btn-sm pull-right" data-ui-loader href="<?= $this->context->contentContainer->createUrl('/classifieds/classifieds/index') ?>">
			<i class="fas fa-arrow-left" style="margin-right:10px"></i> <?= Yii::t('ClassifiedsModule.base', 'Back') ?>
		</a>
	</div></div>
	<div class="panel-heading">
		<strong><?php echo $profil->firstname ?></strong>'s <?= Yii::t('ClassifiedsModule.base', 'listings') ?>
	</div>
	<div class="panel-body">
	<?php if (isset($objects)) {
              if (count($objects) > 0) {
                 require(__DIR__ . '/objectsList.php');
              } else {
                 echo "There are no published listings";
              }
		} ?>
	</div>
</div>
