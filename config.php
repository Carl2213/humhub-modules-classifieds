<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\space\widgets\MenuMobile;
use humhub\modules\user\widgets\ProfileMenu;
use humhub\modules\user\widgets\ProfileSidebar;
use humhub\modules\space\widgets\Sidebar;

return [
    'id' => 'classifieds',
    'class' => 'humhub\modules\classifieds\Module',
    'namespace' => 'humhub\modules\classifieds',
    'events' => [
        array('class' => Menu::className(), 'event' => Menu::EVENT_INIT, 'callback' => array('humhub\modules\classifieds\Module', 'onSpaceMenuInit')),
		    ],
];
?>
