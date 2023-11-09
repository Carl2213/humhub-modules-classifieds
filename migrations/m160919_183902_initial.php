<?php

class m160919_183902_initial extends yii\db\Migration
{

    public function up()
    {
        $this->createTable('classifieds_object', array(
            'id' => 'pk',
            'name' => 'text DEFAULT NULL',
            'description' => 'text DEFAULT NULL',
            'user' => 'int(11) DEFAULT NULL',
            'category' =>'int(11) DEFAULT NULL',
            'module' => 'int(11) DEFAULT NULL',
            'location'=> 'text DEFAULT NULL',
            'contact'=> 'text DEFAULT NULL',
			'price'=> 'text DEFAULT NULL'
        ), '');

        $this->createTable('classifieds_category', array(
            'id' => 'pk',
            'name' => 'text DEFAULT NULL'
        ), '');
		

    }

    public function down()
    {
        echo "m140708_155237_initial does not support migration down.\n";
        return false;
    }

    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
