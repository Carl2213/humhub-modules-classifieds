<?php

namespace humhub\modules\classifieds\models;


use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\tasks\widgets\WallEntry;
use Yii;

/**
 * This is the model class for table "classifieds_object".
 *
 * @package humhub.modules.classifieds.models
 * The followings are the available columns in table 'classifieds_object':
 * @property integer $id
 * @property integer $user
 * @property string $name
 * @property string $description
 * @property integer $category
 * @property string $location
 * @property string $contact
 */
class SharedObject extends \humhub\modules\content\components\ContentActiveRecord implements \humhub\modules\search\interfaces\Searchable
{

    static $wordInTitleWeight=2;
    static $wordInDescriptionWeight=1;
    static $sentenceInTitleWeight=4;
    static $sentenceInDescriptionWeight=2;
	public $imageFile;
    public $autoAddToWall = true;
    public $wallEntryClass = 'humhub\modules\classifieds\widgets\WallEntry';




    /**
     * @inheritdoc
     */
    public function getSearchAttributes()
    {
        return array(
            'name' => $this->name,
            'user' => $this->user,
            'description' => $this->description,
            'category' => $this->category,
			'price' => $this->price,
        );
    }

	
	
    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'classifieds_object';
    }
	
	 public function rules()
    {
        return [
            [['name', 'description', 'price', 'category'], 'required'],
            [['description'], 'string'],
			[['location'], 'string'],
			[['contact'], 'string'],
            [['user'], 'integer'],
            [['category'], 'integer'],
            [['price'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ClassifiedsModule.models_SharedObject', 'ID'),
            'name' => Yii::t('ClassifiedsModule.models_SharedObject', 'Title'),
            'description' => Yii::t('ClassifiedsModule.models_SharedObject', 'Description'),
            'user' => Yii::t('ClassifiedsModule.models_SharedObject', 'User'),
            'category' => Yii::t('ClassifiedsModule.models_SharedObject', 'Category'),
            'contact'=> Yii::t('ClassifiedsModule.models_SharedObject', 'Contact Info'),
			'price'=> Yii::t('ClassifiedsModule.models_SharedObject', 'Price'),
            'location'=> Yii::t('ClassifiedsModule.models_SharedObject', 'Location'),
        ];
    }
	
	public function getContentName()
    {
        return "";
    }
    public function getIcon()
    {
        return 'fa-ad';
    }

    /**
     * @param ContentContainer $contentContainer
     * @param int $category
     * @param string $terms
     * @return Object[]
     */

    public static function search($contentContainer,$category, $terms){
        if($category==0 || $category=="0") {
            $objects = SharedObject::getAll($contentContainer);
        }
        else{
            $objects=SharedObject::fromCategory($contentContainer,$category);
        }

        //triming space and splitting the search terms
        $terms=strtolower(trim($terms));

        if($terms!="") {
            $termArr = explode(" ", $terms);
            foreach ($termArr as $k => $term) {
                $termArr[$k] = trim($term);
            }

            $objectsSearched = array();
            global $g_classifiedsObjweights;
            $g_classifiedsObjweights = array();

            foreach ($objects as $obj) {
                /**   @param Object $obj */

                $lowDescr = strtolower($obj->description);
                $lowName = strtolower($obj->name);


                //Calculating weight of the objects depending of the occurence of terms in its name and description
                $weight = 0;
                $weight += substr_count($lowName, $terms) * SharedObject::$sentenceInTitleWeight;
                $weight += substr_count($lowDescr, $terms) * SharedObject::$sentenceInDescriptionWeight;
                foreach ($termArr as $term) {
                    $weight += substr_count($lowName, $term) * SharedObject::$wordInTitleWeight;
                    $weight += substr_count($lowDescr, $term) * SharedObject::$wordInDescriptionWeight;
                }

                if ($weight > 0) {
                    $g_classifiedsObjweights[$obj->id] = $weight;
                    array_push($objectsSearched, $obj);
                }
            }

            usort($objectsSearched, function ($a, $b) {
                global $g_classifiedsObjweights;
                return $g_classifiedsObjweights[$a->id] > $g_classifiedsObjweights[$b->id];
            });

            return $objectsSearched;
        }
        else{
            return SharedObject::fromCategory($contentContainer,$category);
        }
    }

    public static function fromCategory($contCont, $category)
    {
        if($category==0||$category=='0'){
            return SharedObject::getAll($contCont);
        }
        return SharedObject::find()->contentContainer($contCont)->where(array('classifieds_object.category' => $category))->orderBy(['name' => SORT_ASC])->all();
    }

    public static function fromUser($contCont, $userId){
        return SharedObject::find()->contentContainer($contCont)->where(array('classifieds_object.user' => $userId))->orderBy(['name' => SORT_ASC])->all();
    }

    public static function getAll($contCont){
        return SharedObject::find()->contentContainer($contCont)->orderBy(['name' => SORT_ASC])->all();
    }


    

}
