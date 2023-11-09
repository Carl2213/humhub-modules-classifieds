<?php
namespace humhub\modules\classifieds\widgets;


class WallEditForm extends \humhub\modules\content\widgets\WallCreateContentForm
{

    /**
     * @inheritdoc
     */
    public $submitUrl = '/classifieds/classifieds/edit'; //to do: check the values here, not sure about moduleID
    

    /**
     * @inheritdoc
     */
    public function renderForm()
    {
        return $this->render('form', array());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->contentContainer instanceof \humhub\modules\space\models\Space) {
            
            if (!$this->contentContainer->permissionManager->can(new \humhub\modules\fallos\permissions\CratePost())) {
                return;
            }
        }

        return parent::run();
    }

}

?>