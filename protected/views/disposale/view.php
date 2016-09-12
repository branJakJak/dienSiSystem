<?php
/* @var $this DisposaleController */
/* @var $model Disposale */

$this->breadcrumbs=array(
	'Disposales'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Disposale', 'url'=>array('index')),
	array('label'=>'Create Disposale', 'url'=>array('create')),
	array('label'=>'Update Disposale', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Disposale', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Disposale', 'url'=>array('admin')),
);
?>

<h1>View Disposale #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'dispo_name',
		'phone_number',
		'posted_data',
		'date_created',
		'date_updated',
	),
)); ?>
