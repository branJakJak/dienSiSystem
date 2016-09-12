<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kevin
 * Date: 3/10/15
 * Time: 1:09 AM
 * To change this template use File | Settings | File Templates.
 */

$this->breadcrumbs=array(
     'Update Message Board',
);


?>

<h1>Update MessageBoard</h1>


<?php 

$this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
	    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
	    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
	    'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
)); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
