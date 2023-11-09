<?php


namespace humhub\modules\classifieds\controllers;


use humhub\modules\user\models\Profile;
use Yii;
use yii\web\HttpException;
use humhub\modules\user\models\User;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\content\models\Content;
use humhub\modules\space\behaviors\SpaceController;
use humhub\modules\classifieds\models\SharedObject;
use humhub\modules\classifieds\models\Category;
use humhub\modules\file\models\File;
use yii\helpers\Url;



/**
 * Description of classifiedsController.
 *
 * @package humhub.modules.classifieds.controllers
 */
class ClassifiedsController extends ContentContainerController
{
	
	public function actions()
    {
        return array(
            'stream' => array(
                'class' => \humhub\modules\classifieds\components\StreamAction::className(),
				'includes' => SharedObject::className(),
                'mode' => \humhub\modules\classifieds\components\StreamAction::MODE_NORMAL,
                'contentContainer' => $this->contentContainer
            ),
        );
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($this->contentContainer instanceof Space && !$this->contentContainer->isMember()) {
                throw new HttpException(403, 'You have to be a member of this space to perform this action.');
            }
			
	   
            return true;
        }

        return false;
    }


    public function actionIndex()
    {
         //We get the post parameters
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();

        if(isset($post['SearchForm'])){
            $get=$post;
        }

      if(isset($get['SearchForm'])){
            if(isset($get['SearchForm']['terms'])) {
                $terms = $get['SearchForm']['terms'];
            }
          else {
              $terms="";
          }
            $category=$get['SearchForm']['category'];

            $objects=SharedObject::search($this->contentContainer,$category,$terms);

            return $this->render('index', [
                'contentContainer' => $this->contentContainer,
                'objects' => $objects,
                'categories'=> Category::getAll($this->contentContainer),
                'categoryId'=>$category,
                'terms'=>$terms,
            ]);
        }
        return $this->render('index', [
            'contentContainer' => $this->contentContainer,
            'categories'=> Category::getAll($this->contentContainer)
        ]);


    }


    /* OBJECTS */

    public function actionAddObject()
    {
        if (!$this->canCreateObject()) {
            throw new HttpException(404, "You do not have permission to perform this action.");
        }
		
		  
		
		

        $object_id = (int)Yii::$app->request->get('object_id');
        $object = SharedObject::find()->contentContainer($this->contentContainer)->where(array('classifieds_object.id' => $object_id))->one();

        //No object in parameters : we are creating an object
        if ($object == null) {
            $object = new SharedObject();
            $object->user=null;
            $object->content->container = $this->contentContainer;
					
        }
		
		
		
        else{ //Otherwise we are editing an object and we must check if the user is allowed to do that
            if(!Yii::$app->user->id==$object->user && !$this->canCreateCategory()){
                throw new HttpException(404, "You do not have permission to perform this action.");
            }
			
			
        }
		
		
		

        //We get the post parameters
        $post = Yii::$app->request->post();

        //If we do have an Object, we check it and save it, then redirection to index
        if (isset($post['SharedObject'])) {
            $object->name = $post["SharedObject"]['name'];
            $object->description = $post["SharedObject"]['description'];
            $object->category = $post["SharedObject"]['category'];
            $object->location=$post["SharedObject"]['location'];
            $object->contact =$post["SharedObject"]['contact'];
			$object->price =$post["SharedObject"]['price'];
			
			
			
			

            //We assign the user as the current user only if it's a new object
            if($object->user==null) {
                $object->user = Yii::$app->user->id;
            }
			
			
			
			

            //Saving in database and redirection
            if ($object->validate() && $object->save()) {
                $this->redirect($this->contentContainer->createUrl('/classifieds/classifieds/object-page',['object_id'=>$object->id]));
            }
			
						

        }
		
		

        return $this->render('addObject', array(
            'object' => $object,
            'categories' => Category::getAll($this->contentContainer),
            'contentContainer'=>$this->contentContainer
        ));
		
		
    }
	
	
	
	
	

    public function actionObjectPage()
    {
        $get=Yii::$app->request->get();

        //Id of the object to display
        $objId = (int)Yii::$app->request->get('object_id');

        //handling previous research
        if(isset($get['searchCategory'])){
            $searchCategory=$get['searchCategory'];
        }
        $searchTerms= (string)Yii::$app->request->get('searchTerms');
        //var_dump(Yii::$app->request->get());


        $object = SharedObject::find()->contentContainer($this->contentContainer)->where(array('classifieds_object.id' => $objId))->one();
        $category = Category::find()->contentContainer($this->contentContainer)->where(array('classifieds_category.id' => $object->category))->one();
        $user = User::find()->where(['id' => $object->user])->one();
        $profile = Profile::find()->where(['user_id' => $object->user])->one();

        if(!isset($searchCategory)){
            $searchCategory=$category->id;
            $searchTerms=null;
        }

        //ar_dump($searchCategory);
        return $this->render('objectPage', [
            'contentContainer' => $this->contentContainer,
            'object' => $object,
            'category' => $category,
            'profile'=> $profile,
            'user'=>$user,
            'searchCategory'=>$searchCategory,
            'searchTerms'=>$searchTerms
        ]);
    }

    public function actionAllObjects()
    {
        //We get the post parameters
        $post = Yii::$app->request->post();
        $get = Yii::$app->request->get();


        if (isset($post['Object'])) {
            $cat = $post['Object']['category'];
        } else if (isset($get['category'])) {
            $cat = $get['category'];
        } else {
            return $this->render('allObjects', [
                'contentContainer' => $this->contentContainer,
                'categories' => Category::getAll($this->contentContainer)
            ]);
        }

        return $this->render('allObjects', [
            'contentContainer' => $this->contentContainer,
            'categories' => Category::getAll($this->contentContainer),
            'categoryId' => $cat,
            'objects' => SharedObject::fromCategory($this->contentContainer, $cat)
        ]);

    }

    public function actionObjectsOfUser(){
        $userId=Yii::$app->request->get('userId');
        $user = User::find()->where(['id' => $userId])->one();
        $profil = Profile::find()->where(['user_id' => $userId])->one();
        return $this->render('objectsOfUser', [
            'contentContainer' => $this->contentContainer,
            'objects' => SharedObject::fromUser($this->contentContainer,$userId),
            'user' => $user,
            'profil'=>$profil
        ]);
    }

    
    /**
     * Action that deletes a givenobject.<br />
     * The request has to provide the id of the object to delete in the url parameter 'objectid'.
     * @throws HttpException 404, if the logged in User misses the rights to access this view.
     */
    public function actionDeleteObject()
    {
        $object_id = (int)Yii::$app->request->get('object_id');
        $object = (Object)SharedObject::find()->contentContainer($this->contentContainer)->where(array('classifieds_object.id' => $object_id))->one();

        $cat=$object->category;

        if ($object == null) {
            throw new HttpException(404, "The requested object can not b found.");
        }

        if (!$this->canCreateCategory()&&!Yii::$app->user->id==$object->user) {
            throw new HttpException(404, "You do not have permission to perform this action.");
        }

        $object->delete();

        $this->redirect($this->contentContainer->createUrl('/classifieds/classifieds/index',['SearchForm' => ['category'=>$cat]]));
    }



    /* END OBJECTS */

    /* CATEGORIES */

    /**
     * Action that deletes a given category.<br />
     * The request has to provide the id of the category to delete in the url parameter 'category_id'.
     * @throws HttpException 404, if the logged in User misses the rights to access this view.
     */
    public function actionDeleteCategory()
    {
        if (!$this->canCreateCategory()) {
            throw new HttpException(404, "You do not have permission to perform this action.");
        }

        $category_id = (int)Yii::$app->request->get('category_id');
        $category = Category::find()->contentContainer($this->contentContainer)->where(array('classifieds_category.id' => $category_id))->one();

        if ($category == null) {
            throw new HttpException(404, "The requested category can not be found.");
        }

        $objects = SharedObject::fromCategory($this->contentContainer,$category_id);
        foreach($objects as $obj){
            $obj->delete();
        }

        $category->delete();



        $this->redirect($this->contentContainer->createUrl('/classifieds/classifieds/edit-categories'));
    }


    /**
     * Action that renders the view to add or edut a category.<br />
     * The request has to provide the id of the category to edit in the url parameter 'category_id'.
     * @see views/classifieds/addCategory.php
     * @throws HttpException 404, if the logged in User misses the rights to access this view.
     */
    public function actionAddCategory()
    {

        if (!$this->canCreateCategory()) {
            throw new HttpException(404, "You do not have permission to perform this action.");
        }

        $category_id = (int)Yii::$app->request->get('category_id');
        $category = Category::find()->contentContainer($this->contentContainer)->where(array('classifieds_category.id' => $category_id))->one();

        if ($category == null) {
            $category = new Category;
            $category->content->container = $this->contentContainer;
        }

        //We get the post parameters
        $post = Yii::$app->request->post();

        //If we do have a Category, we check it and save it, then redirection to index
        if (isset($post['Category'])) {
            $category->name = $post["Category"]['name'];
            if ($category->validate() && $category->save()) {
                $this->redirect($this->contentContainer->createUrl('/classifieds/classifieds/edit-categories'));
            }
        }

        return $this->render('addCategory', array(
            'category' => $category,
        ));
    }

    /**
     * Group's creator option : see all the categories for editing
     * @return string
     */
    public function actionEditCategories()
    {
        return $this->render('editCategories', [
            'contentContainer' => $this->contentContainer,
            'categories' => Category::getAll($this->contentContainer)
        ]);
    }

    /*END CATEGORIES */

    /* PERMISSIONS */
    /**
     * @return boolean can manage categories?
     */
    public function canCreateCategory()
    {
        return $this->contentContainer->permissionManager->can(new \humhub\modules\classifieds\permissions\CreateCategory());
    }

    /**
     * @return boolean can add object?
     */
    public function canCreateObject()
    {
        return $this->contentContainer->permissionManager->can(new \humhub\modules\classifieds\permissions\CreateObject());
    }


}

?>
