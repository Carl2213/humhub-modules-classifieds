<?php

namespace humhub\modules\classifieds\widgets;

use Yii;

/**
 * PollWallEntryWidget is used to display a poll inside the stream.
 *
 * This Widget will used by the Poll Model in Method getWallOut().
 *
 * @package humhub.modules.polls.widgets
 * @since 0.5
 * @author Luke
 */
class WallEntry extends \humhub\modules\content\widgets\WallEntry
{

  //  public $editRoute = "/classifieds/classifieds/edit";
    
    public function run()
    {
        //Hint: insert here a check in case you do not wish to edit a specific post, setting then $this->editRoute = '';  

        return $this->render('entry', array('classifieds' => $this->contentObject,
                    'user' => $this->contentObject->content->createdBy,
                    'contentContainer' => $this->contentObject->content->container));
    }
}
