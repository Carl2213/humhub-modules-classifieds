<?php

use yii\widgets\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\classifieds\models\forms\SearchForm;
use humhub\modules\classifieds\models\Category;

/**
 *
 * @uses $accesslevel the access level of the user currently logged in.
 *
 * @var Object[] $objects
 * @var Category[] $categories
 * @var ContentContainer $contentContainer
 * @var User $user
 */

humhub\modules\classifieds\Assets::register($this);
?>

<style>
.btnx {
    border: none;
    outline: none;
    padding: 8px 8px;
    background-color: #f1f1f1;
    cursor: pointer;
    font-size: 15px;
	display:block;
	float:left;
	margin:5px;
	
}

/* Style the active class, and buttons on mouse-over */
.btnx:hover {
    background-color: #666;
    color: white;
}

.btnx a:active {
    background-color: #ff9900;
    color: white;
}

span.quantity{
	width: 25px;
    height: 25px;
    background: black;
    -moz-border-radius: 50px;
    -webkit-border-radius: 50px;
	border-radius: 50px;
    color: #fff;
    font-size: 15px;
    display: block;
    float: right;
    font-weight: bolder;
    margin-left: 5px;
}

</style>

<div class="panel panel-default">
    <div class="panel-heading">
		<!-- Buttons -->
        <div style='text-align:end'>
            <?php
            echo
                //Button add an Object
                " <a href='" .$contentContainer->createUrl('/classifieds/classifieds/add-object') .
                "'>" .
                Html::button('New Listing', array('class' => 'btn btn-success', 'id' => 'new-listing-btn')) .

                //Button your objects
                " <a href='" .
                $contentContainer->createUrl('/classifieds/classifieds/objects-of-user', ['userId' => Yii::$app->user->id]) .
                "'>" .
                "<button class='btn active' style='background:#33a82f;color:#fff'><i class='fas fa-user'></i>My Listings</button>" .
                "</a><br>";

            //Button modify categories, only for admins
            if ($this->context->canCreateCategory()) {
                echo "<a href='" . $contentContainer->createUrl('/classifieds/classifieds/edit-categories') . "'>" .
                    Html::button('Manage Categories', array('class' => 'btn btn-danger', 'id' => 'edit-cat-btn')) .
                    "</a><br>";
            }
            ?>
        </div></div>
    <div class="panel-body"><div class="listing-posts" style="padding-top:0">
        <i><?= Yii::t('ClassifiedsModule.base', 'Categories') ?></i><hr>
        <?php   $form = ActiveForm::begin();

        //Formatting the categories into a simple array (id=>name) for the dropdown
        foreach ($categories as $cat) {
			    echo "<a href='" .$contentContainer->createUrl('/classifieds/classifieds/index', ['SearchForm' => ['category' => $cat->id]]) ."'>".
				"<button class='btnx pull-left form-group' style='background:#33a82f;margin-bottom: 25px;margin-top: -10px'>".$cat->name."<span class='quantity'>";
				 echo $countCat = \humhub\modules\classifieds\models\SharedObject::find()->where(['category' => $cat['id']])->count();
				 echo "</span></button></a>";
        } ?>
		<br><br><hr>
		 <?php ActiveForm::end();?>
		 <?php

        //Show the list of objects if necessary
        if (isset($objects)) {
            require(__DIR__ . '/objectsList.php');
        } ?>
		</div>
	</div>
</div>
