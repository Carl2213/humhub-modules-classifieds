<?php
use yii\helpers\Html;
use humhub\modules\space\models\Space;
use humhub\modules\classifieds\models\forms\SearchForm;
use humhub\modules\user\models\User;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\file\widgets\ShowFiles;
use humhub\modules\comment\models\Comment;
use humhub\modules\content\widgets\WallEntryAddons;
//use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentActiveRecord;

humhub\modules\classifieds\Assets::register($this);

$isAdmin = $contentContainer->permissionManager->can(new \humhub\modules\classifieds\permissions\CreateCategory());

/*it was a search, before
if ($searchCategory >= 0) {

    //Parameters of the search
    $searchForm = new SearchForm();
    $searchForm->category = $searchCategory;
    if (isset($searchTerms) && $searchTerms != null) {
        $searchForm->terms = $searchTerms;
    }
    $paramBack = ['SearchForm' => $searchForm];
    $backUrl = '/classifieds/classifieds/index';
} else {*/ //otherwise it was displaying users object
    $backUrl = '/classifieds/classifieds/';
    $paramBack = ['userId' => Yii::$app->user->id];
//}

//var_dump($paramsBack)

?>

<!--//this will be the content of the stream
//e.g.:
//echo "description: ".[WallEntry object]->description."<br/>";
//of course, you will need to customize the data view to arrange the layout you need
//below fields are auto generated based on th tables available into the system, but data are really rough -->
<!-- Edit and delete Button -->
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<div style="display:flow-root;margin-bottom:10px">
					<?php if ($object->user == Yii::$app->user->id || $isAdmin): ?>
					<div style="float:right;padding: 5px">
						<a class="btn btn-default btn-sm pull-right" data-ui-loader href="<?= $contentContainer->createUrl('/classifieds/classifieds/delete-object', ['object_id' => $object->id]) ?> ">
							<i class="fas fa-trash"></i> <?= Yii::t('ClassifiedsModule.base', 'Delete') ?>
						</a>
					</div>
					<div style="float:right;padding: 5px">
						<a class="btn btn-default btn-sm pull-right" data-ui-loader href="<?= $contentContainer->createUrl('/classifieds/classifieds/add-object', ['object_id' => $object->id]) ?> ">
							<i class="fas fa-edit"></i> <?= Yii::t('ClassifiedsModule.base', 'Edit') ?>
						</a>
						</a>
					</div>
					<?php endif ?>
				<!-- Back Button
					<div style="float:right;padding: 5px">
						<a class="btn btn-default btn-sm pull-right" data-ui-loader href="<?php echo $contentContainer->createUrl($backUrl) ?>">
							<i class="fas fa-arrow-left"></i> <?= Yii::t('ClassifiedsModule.base', 'Back') ?>
						</a>
					</div>-->
				</div>
			<div style="margin-top: -40px">
				 <a href="<?php echo $contentContainer->createUrl('/classifieds/classifieds/index') ?>">
                                Categories</a>
                                /<a href="<?php echo $contentContainer->createUrl('/classifieds/classifieds/index', ['SearchForm' => ['category' => $category->id]]) ?>">
					<?php echo $category->name ?>
				</a>
				<strong><h3><?php echo $object->name ?></strong>
			</div>
			<div style="margin-top:-40px" class="price"><?php Yii::$app->formatter->locale = 'en-US';
			echo Yii::$app->formatter->asCurrency($object->price, 'USD');?>
			</div>
			<div class="panel-body">
				<div class="markdown-render">
				<?php echo \humhub\widgets\MarkdownView::widget(['markdown' => $object->description]); ?>
				</div>
				<div class="social-controls">
				<?= WallEntryAddons::widget(['object' => $object]); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-md-4">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="header-contacto-classifieds">
				<p>
					<b>
					<?= Yii::t('ClassifiedsModule.base', 'Posted by') ?>
					</b>
				</p>
			</div>
			<div class="panel-body">
				<center>
					<a href="<?= $user->getUrl(); ?>">
					<?= \humhub\modules\user\widgets\Image::widget(['user' => $user, 'width' => 140]); ?>
				</center>
				<br>
				<strong><?= Yii::t('ClassifiedsModule.base', 'Name') ?> </strong>: <a href="<?= $user->getUrl(); ?>"> <?php echo "".$profile->firstname.""; ?> <?php echo "".$profile->lastname."";?>
				<br>
				<strong>?= Yii::t('ClassifiedsModule.base', 'Contact Info') ?> </strong>: <p><?php echo "".$object->contact.""; ?>
					<br></p>
				<div style="padding-top: 5px">
				<?php if (trim($object->location) != "") { ?>
				<strong>
					<?= Yii::t('ClassifiedsModule.base', 'Location') ?></strong>:&nbsp;
				<p id="map_location">
				<?= $object->location ?>
				</p>
<!--				<div id="map_canvas" style="margin:auto;width:100%; height:300px">
				</div>-->
				<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

