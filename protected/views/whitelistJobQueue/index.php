<?php
/* @var $this WhitelistJobQueueController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Whitelist Job Queues',
);

$this->menu=array(
	array('label'=>'Create WhitelistJobQueue', 'url'=>array('create')),
	array('label'=>'Manage WhitelistJobQueue', 'url'=>array('admin')),
);
?>

<h1>Whitelist Job Queues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
