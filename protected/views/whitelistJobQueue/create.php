<?php
/* @var $this WhitelistJobQueueController */
/* @var $model WhitelistJobQueue */

$this->breadcrumbs=array(
	'Whitelist Job Queues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WhitelistJobQueue', 'url'=>array('index')),
	array('label'=>'Manage WhitelistJobQueue', 'url'=>array('admin')),
);
?>

<h1>Create WhitelistJobQueue</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>