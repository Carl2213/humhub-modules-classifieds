<?php

use yii\helpers\Html;
use humhub\widgets\RichtextField;

humhub\modules\classifieds\Assets::register($this);
?>
<style>

.fallos-field-description-rep{
    padding-top: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #efeeee;
    border-top: 1px solid #efeeee;
    font-size: .9em;
    font-style: oblique;
	    margin-bottom: 10px;
	}

.fallos-title-category-rep{
    margin-left: 10px;
    text-decoration: underline;
    text-align: right;
	}

.fallos-field-title-rep:first-letter {
    text-transform: capitalize;
}



.fallos-field-title-rep{
	
	display: block;
    padding: 5px;
    border-left: 5px solid;
    font-weight: 600;
    font-size: 1.2em;
	margin-bottom: 15px;
	
}

.fallos-title-num-rep{
	display:none;
}
.fallos-field-num-rep{
    font-size: 3em;
    display: block;
    float: right;
}

</style>

<?php echo Html::beginForm(); ?> 


<!--//this will be the content of the stream
//e.g.:
//echo "description: ".[WallEntry object]->description."<br/>";
//of course, you will need to customize the data view to arrange the layout you need
//below fields are auto generated based on th tables available into the system, but data are really rough -->

<?php //echo Html::encode($classifieds->category->categoryName); ?>
<?php
          
		//  echo "<div class='fallos-title-category-rep'>".$classifieds->category."</div>";
         echo "<div class='price'>";
			 
			 Yii::$app->formatter->locale = 'en-US';
			 echo Yii::$app->formatter->asCurrency($classifieds->price, 'USD');
			 
			 echo "</div>";
          
          echo "<div class='fallos-field-title-rep'>".$classifieds->name."</div>";
          
          echo "<div class='fallos-title-description-rep'>Description:</div><div class='fallos-field-description-rep'>".$classifieds->description."</div>"; 
		  		  
		

?>          
          
<?php echo Html::endForm(); ?>

