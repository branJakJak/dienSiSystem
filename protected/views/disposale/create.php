<?php
/* @var $this DisposaleController */
/* @var $model Disposale */

$this->breadcrumbs=array(
	'Disposales'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Disposale', 'url'=>array('index')),
	array('label'=>'Manage Disposale', 'url'=>array('admin')),
);
?>

<h1>Create Disposale</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>