<?php

class uninstall extends \humhub\components\Migration
{

    public function up()
    {

        $this->dropTable('classifieds_object');
        $this->dropTable('classifieds_category');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }

}
