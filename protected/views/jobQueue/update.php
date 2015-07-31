<?php
/* @var $this JobQueueController */
/* @var $model JobQueue */

$this->breadcrumbs=array(
	'Job Queues'=>array('index'),
	$model->queue_id=>array('view','id'=>$model->queue_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List JobQueue', 'url'=>array('index')),
	array('label'=>'Create JobQueue', 'url'=>array('create')),
	array('label'=>'View JobQueue', 'url'=>array('view', 'id'=>$model->queue_id)),
	array('label'=>'Manage JobQueue', 'url'=>array('admin')),
);
?>

<h1>Update JobQueue <?php echo $model->queue_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>