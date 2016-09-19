<?php
/* @var $this MessageBoardController */
/* @var $model MessageBoard */

$this->breadcrumbs=array(
	'Message Boards'=>array('index'),
	$model->rec_id,
);

$this->menu=array(
	array('label'=>'List MessageBoard', 'url'=>array('index')),
	array('label'=>'Create MessageBoard', 'url'=>array('create')),
	array('label'=>'Update MessageBoard', 'url'=>array('update', 'id'=>$model->rec_id)),
	array('label'=>'Delete MessageBoard', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->rec_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MessageBoard', 'url'=>array('admin')),
);
?>

<h1>View MessageBoard #<?php echo $model->rec_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rec_id',
		'messageType',
		'messageStatus',
		'fullMessage',
	),
)); ?>
