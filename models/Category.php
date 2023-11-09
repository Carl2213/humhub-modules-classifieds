<?php

namespace humhub\modules\classifieds\models;

use Yii;

/**
 * This is the model class for table "classifieds_object".
 *
 * @package humhub.modules.classifieds.models
 * The followings are the available columns in table 'classifieds_category':
 * @property integer $id
 * @property string $name
 *test commit
 */

class Category extends \humhub\modules\content\components\ContentActiveRecord implements \humhub\modules\search\interfaces\Searchable
{
    /**
     * @inheritdoc
     */
    public function getSearchAttributes()
    {
        return array(
            'name' => $this->name
        );
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'classifieds_category';
    }
	
	 public function rules()
    {
        return [
            [['name'], 'required'],
           
            [['name'], 'string', 'max' => 25],
        ];
    }
	
	 public function attributeLabels()
    {
        return [
            'name' => Yii::t('ClassifiedsModule.models_SharedObject', 'Name'),
            
        ];
    }

    public static function getAll($contCont){
        return Category::find()->contentContainer($contCont)->orderBy(['name' => SORT_ASC])->all();
    }
}
