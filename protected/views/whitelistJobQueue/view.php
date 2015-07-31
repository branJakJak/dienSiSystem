<?php
/* @var $this WhitelistJobQueueController */
/* @var $model WhitelistJobQueue */

$this->breadcrumbs=array(
	'Whitelist Job Queues'=>array('index'),
	$model->queue_id,
);

$this->menu=array(
	array('label'=>'List WhitelistJobQueue', 'url'=>array('index')),
	array('label'=>'Create WhitelistJobQueue', 'url'=>array('create')),
	array('label'=>'Update WhitelistJobQueue', 'url'=>array('update', 'id'=>$model->queue_id)),
	array('label'=>'Delete WhitelistJobQueue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->queue_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WhitelistJobQueue', 'url'=>array('admin')),
);
?>

<h1>View WhitelistJobQueue #<?php echo $model->queue_id; ?></h1>

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
