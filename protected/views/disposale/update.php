<?php
/* @var $this DisposaleController */
/* @var $model Disposale */

$this->breadcrumbs=array(
	'Disposales'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Disposale', 'url'=>array('index')),
	array('label'=>'Create Disposale', 'url'=>array('create')),
	array('label'=>'View Disposale', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Disposale', 'url'=>array('admin')),
);
?>

<h1>Update Disposale <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>