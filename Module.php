<?php

namespace humhub\modules\classifieds;

use Yii;
use yii\helpers\Url;
use humhub\modules\classifieds\models\Link;
use humhub\modules\classifieds\models\Category;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\components\ContentContainerModule;

class Module extends ContentContainerModule
{

 public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            User::className(),
            Space::className(),
        ];
    }

    /**
     * @inheritdoc
     */
   

    /**
     * @inheritdoc
     */
    public function disable()
    {
		
		foreach (SharedObject::find()->all() as $object) {

            $object->delete();

        }
		
		foreach (Category::find()->all() as $category) {

            $category->delete();

        }
		
		
        parent::disable();
    }


    /**
     * On build of a Space Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event        	
     */
    public static function onSpaceMenuInit($event)
    {

        $space = $event->sender->space;
        if ($space->isModuleEnabled('classifieds') && $space->isMember()) {
            $event->sender->addItem(array(
                'label' => Yii::t('ClassifiedsModule.base', 'Classifieds'),
                'url' => $space->createUrl('/classifieds/classifieds'),
                'icon' => '<i class="glyphicon glyphicon-grain" aria-hidden="true"></i> ',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'classifieds')
            ));
        }
    }
	
	
	   /**

     * @inheritdoc

     */

   
    /**

     * @inheritdoc

     */
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        parent::disableContentContainer($container);
        foreach (SharedObject::find()->contentContainer($container)->all() as $object) {
            $object->delete();
        }
    }



    /**

     * @inheritdoc

     */

    /**
     * To know if the user is allowed to do things
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        if ($contentContainer instanceof \humhub\modules\space\models\Space) {
            return [
                new permissions\CreateCategory(),
				new permissions\CreateObject(),
            ];
        }

        return [];
    }


}
