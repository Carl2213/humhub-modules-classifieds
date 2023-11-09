<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\classifieds\permissions;

use humhub\modules\space\models\Space;

/**
 * CreateTask Permission
 */
class CreateCategory extends \humhub\libs\BasePermission
{

    /**
     * @inheritdoc
     */
    public $defaultAllowedGroups = [
        Space::USERGROUP_OWNER,
        Space::USERGROUP_MODERATOR,
        Space::USERGROUP_ADMIN
    ];
    
    /**
     * @inheritdoc
     */
    protected $fixedGroups = [
     
    ];

    /**
     * @inheritdoc
     */
    protected $title = "Create Category";

    /**
     * @inheritdoc
     */
    protected $description = "Allows the user to create new category";

    /**
     * @inheritdoc
     */
    protected $moduleId = 'classifieds';

}
