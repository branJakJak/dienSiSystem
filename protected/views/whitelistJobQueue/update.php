<?php
/* @var $this WhitelistJobQueueController */
/* @var $model WhitelistJobQueue */

$this->breadcrumbs=array(
	'Whitelist Job Queues'=>array('index'),
	$model->queue_id=>array('view','id'=>$model->queue_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WhitelistJobQueue', 'url'=>array('index')),
	array('label'=>'Create WhitelistJobQueue', 'url'=>array('create')),
	array('label'=>'View WhitelistJobQueue', 'url'=>array('view', 'id'=>$model->queue_id)),
	array('label'=>'Manage WhitelistJobQueue', 'url'=>array('admin')),
);
?>

<h1>Update WhitelistJobQueue <?php echo $model->queue_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>