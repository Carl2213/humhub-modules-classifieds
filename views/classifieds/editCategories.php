<?php

use yii\helpers\Html;
use yii\helpers\Url;
use humhub\modules\classifieds\models\Category;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Profile;

/**
 * Category List for editing
 *
 * @uses $accesslevel the access level of the user currently logged in.
 *
 * @var Category[] $categories
 * @var ContentContainer $contentContainer
 * @var User $user
 */

humhub\modules\classifieds\Assets::register($this);

if ($this->context->canCreateCategory()) {
?>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="panel-heading">
	<!-- Buttons -->
        		<div style='text-align:end;display:flow-root'>
			<?php echo

                		//Add a category Button
                		"<a href='" .
                    		$contentContainer->createUrl('/classifieds/classifieds/add-category') .
                    		"'><button class='btn btn-danger' style='float:left'><strong><i class='fa fa-plus-circle' aria-hidden='true'></i> Add New Category</strong></button>
                    		</a>" .
				//Back Button
				" <a class='btn btn-default btn-sm pull-right' style='float:right;padding: 5px' data-ui-loader href='" .
				$contentContainer->createUrl('/classifieds/classifieds/') .
				"'><i class='fas fa-arrow-left'></i>&nbsp;&nbsp;Back</a>"; ?>
			</div>
		</div>
		<div class="panel-heading">
			<strong><?= Yii::t('ClassifiedsModule.base', 'Manage') ?>
				</strong> <?= Yii::t('ClassifiedsModule.base', 'Categories') ?></div>
		</div>
            <div class="media">
                <table class="table table-hover">
                    <?php
                    //Show All categories
                    foreach ($categories as $cat) {
                        //Name of the category
                        echo "<tr><td>" . $cat->name . "</td>" .

                            //EDIT Button
                            "<td><a href='" . $contentContainer->createUrl('/classifieds/classifieds/add-category', ['category_id' => $cat->id]) . "'>
                       <button class='btn btn-warning'>Edit</button></a></td>" .

                            //DELETE Button
                            "<td><a href='" . $contentContainer->createUrl('/classifieds/classifieds/delete-category', ['category_id' => $cat->id]) . "'>
                       <button class='btn btn-danger'>Delete</button></a></td>
                       </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

<?php }
