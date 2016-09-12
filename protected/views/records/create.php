<?php
/* @var $this RecordsController */
/* @var $model Records */

$this->breadcrumbs=array(
	'Records'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Records', 'url'=>array('index')),
	array('label'=>'Manage Records', 'url'=>array('admin')),
);
?>

<h1>Create Records</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>