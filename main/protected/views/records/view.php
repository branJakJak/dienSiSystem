<?php
/* @var $this RecordsController */
/* @var $model Records */

$this->breadcrumbs=array(
	'Records'=>array('index'),
	$model->record_id,
);

$this->menu=array(
	array('label'=>'List Records', 'url'=>array('index')),
	array('label'=>'Create Records', 'url'=>array('create')),
	array('label'=>'Update Records', 'url'=>array('update', 'id'=>$model->record_id)),
	array('label'=>'Delete Records', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->record_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Records', 'url'=>array('admin')),
);
?>

<h1>View Records #<?php echo $model->record_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'record_id',
		'account_id',
		'claimData',
		'ip_address',
		'other_information',
		'date_created',
		'date_updated',
	),
)); ?>
