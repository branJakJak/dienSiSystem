<?php
/* @var $this JobQueueController */
/* @var $model JobQueue */

$this->breadcrumbs=array(
	'Job Queues'=>array('index'),
	$model->queue_id,
);

$this->menu=array(
	array('label'=>'List JobQueue', 'url'=>array('index')),
	array('label'=>'Create JobQueue', 'url'=>array('create')),
	array('label'=>'Update JobQueue', 'url'=>array('update', 'id'=>$model->queue_id)),
	array('label'=>'Delete JobQueue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->queue_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage JobQueue', 'url'=>array('admin')),
);
?>

<h1>View JobQueue #<?php echo $model->queue_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'queue_id',
		'queue_name',
		'status',
		'total_records',
		'processed_record',
		'filename',
		'date_done',
		'date_created',
		'date_updated',
	),
)); ?>
