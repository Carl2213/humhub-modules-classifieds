<?php

namespace humhub\modules\classifieds;

use Yii;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;


/**
 * Description of humhub\modules\fallos\Module Events
 *
 * @author redlaguna@gmail.com */

class Events extends \yii\base\BasObject
{

    /**
     * On build of a Space Navigation, check if this module is enabled.
     * When enabled add a menu item
     *
     * @param type $event
     */
    public static function onSpaceMenuInit($event)
    {
        $space = $event->sender->space;

        // Is Module enabled on this workspace?
        if ($space->isModuleEnabled('classifieds')) {
            $event->sender->addItem(array(
                'label' => 'Classifieds',
                'group' => 'modules',
                'url' => $space->createUrl('/classifieds/classifieds/index'),
                'icon' => '<i class="fas fa-exclamation-triangle"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'classifieds'),
            ));
        }
    }
    
    public static function onWallEntryControlsInit($event)
    {
        $object = $event->sender->object;
        
        if(!$object instanceof ShareObject) {           
            return;
        }
        

    }
}