<?php
/* @var $this BlackListedMobileController */
/* @var $model BlackListedMobile */

$this->breadcrumbs=array(
	'Black Listed Mobiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BlackListedMobile', 'url'=>array('index')),
	array('label'=>'Manage BlackListedMobile', 'url'=>array('admin')),
);
?>

<h1>Create BlackListedMobile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>