<?php
namespace humhub\modules\classifieds\widgets;


class WallCreateForm extends \humhub\modules\content\widgets\WallCreateContentForm
{

    /**
     * @inheritdoc
     */
    public $submitUrl = '/classifieds/classifieds/add-object'; //to do: check the values here, not sure about moduleID
    

    /**
     * @inheritdoc
     */
    public function renderForm()
    {
        return $this->render('_form', array());
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->contentContainer instanceof \humhub\modules\space\models\Space) {
            
            if (!$this->contentContainer->permissionManager->can(new \humhub\modules\classifieds\permissions\CreateObject())) {
                return;
            }
        }

        return parent::run();
    }

}

?>