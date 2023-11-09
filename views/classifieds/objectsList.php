<?php
use humhub\modules\content\widgets\WallEntryAddons;
use humhub\modules\content\widgets\WallEntryLinks;
use humhub\modules\user\controllers\ImageController;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Profile;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\file\widgets\ShowFiles;
use humhub\modules\classifieds\models\forms\SearchForm;
use humhub\widgets\Button;
use humhub\modules\comment\models\Comment;
use humhub\modules\comment\widgets\CommentLink;
use humhub\modules\like\widgets\LikeLink;
use humhub\modules\bookmark\widgets\BookmarkLink;
use humhub\libs\Html;
use yii\helpers\Url;
use humhub\modules\user\widgets\Image;

humhub\modules\classifieds\Assets::register($this);

/**
 * @var Object[] $objects
 * @var \humhub\modules\content\models\ContentContainer $contentContainer
 *
 * Used to display a list of object
 */

//parameters of the search
isset($terms)?$searchTerms=$terms:$searchTerms=null;
isset($categoryId)?$searchCategory=$categoryId:$searchCategory=null;

//Do we show users names ?
$showUsers = !(isset($noUserTd) && $noUserTd);

if (count($objects) > 0) {
?>

<div class="container-listing">
	<?php $isAdmin = $contentContainer->permissionManager->can(new \humhub\modules\classifieds\permissions\CreateCategory());
		foreach ($objects as $obj) :?>
	<div class="col-xs-12 col-sm-6 col-xl-5 px-2 post-listing" style="height:377px;margin-top:-25px;padding-top:10px;width:49%;margin-right:7px;margin-bottom:35px;">
		<?php  $user = User::find()->where(['id' => $obj->user])->one();
			 if ($user->profileImage->hasImage()) : ?>
	<div class="header-post-listing">
		<a href="<?= $user->getUrl(); ?>">
			<img class="img-rounded profile-user-photo" id="user-profile-image"
			src="<?php echo $user->getProfileImage()->getUrl(); ?>"
			data-src="holder.js/140x140" alt="140x140" style="width: 35px; height: 35px; float:left; margin-right:10px;" />
		</a>
		<?php else : ?>
		<img class="img-rounded profile-user-photo" id="user-profile-image"
		src="<?php echo $user->getProfileImage()->getUrl(); ?>"
		data-src="holder.js/140x140" alt="140x140" style="width: 35px; height: 35px; float:left; margin-right:10px;"/>
		<?php endif; ?>
		<?php $objUrl=$contentContainer->createUrl('/classifieds/classifieds/object-page',
		['object_id' => $obj->id ,'searchTerms'=>$searchTerms,'searchCategory'=>$searchCategory]) ;

//Owner's name if we need to show it
		if ($showUsers) {

//We obtain the user and its profile (the profile contains the first name and last namme) (TODO :  put it  in the controller)
		$user = User::find()->where(['id' => $obj->user])->one();
		$profil = Profile::find()->where(['user_id' => $obj->user])->one();
		echo "<div class='nombre-vendedor' style='display:grid'>";
                if ($user != null && $profil != null) {
                echo "<a href='" .$user->getUrl() . "'>" . "{$profil->firstname} {$profil->lastname}" . "</a>";
                }
                echo \humhub\widgets\TimeAgo::widget(['timestamp' => $obj->content->created_at]);
//                if ($obj->content->created_at !== $obj->content->updated_at && $obj->content->updated_at != ''):
//                echo Yii::t('ContentModule.views_wallLayout', 'Updated :timeago', array(':timeago' => \humhub\widgets\TimeAgo::widget(['timestamp' => $obj->content->updated_at])));
//                endif;
		echo "</div>";
        }
        
//Object name with link to the object page
		echo "<div class='price-listing'>";
		Yii::$app->formatter->locale = 'en_US';
		echo Yii::$app->formatter->asCurrency($obj->price, 'USD');
		echo "</div>
	</div><br><br><hr>";
	echo "<div class='title-listing-classified'><a href='" .$objUrl. "'>
	<p><b>$obj->name</b></p></a>
	</div>";
/*	echo "<div class='description-listing-classified'><a href='" .$objUrl. "'>
	<p>$obj->description</p></a>
	</div>";*/ ?>
	<?php echo "<button class='btn btn-alert pull-right' style='background-color:#33a82f;margin-top:-50px'><a href='" .$objUrl. "'>Details</a></button><hr>"; ?>
	<div class="fotos-classifieds"><?= ShowFiles::widget(['object' => $obj]); ?>
	</div>
	    <div class="file-controls pull-left">
                <span class="botones"><?= LikeLink::widget(['object' => $obj]); ?></span>&nbsp;
		<span class="botones"><?= BookmarkLink::widget(['object' => $obj]); ?></span>&nbsp;
                <span class="botones"><?= CommentLink::widget(['object' => $obj, 'mode' => CommentLink::MODE_POPUP]); ?></span>
        </div>
<!--</div>
 <div class="stream-entry-addons clearfix">
                    <?php WallEntryAddons::widget(['object' => $obj]);?>
        </div>        </div>-->
</div>
<?php
endforeach;
} else { ?>
    <div style ='text-align:end'><b style='color:darkred'><br><br><br><br><br><?= Yii::t('ClassifiedsModule.base', 'There are no published listings') ?></b></div>
<?php
} ?>

