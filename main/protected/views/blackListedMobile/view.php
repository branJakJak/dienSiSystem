<?php
/* @var $this BlackListedMobileController */
/* @var $model BlackListedMobile */

$this->breadcrumbs=array(
	'Black Listed Mobiles'=>array('index'),
	$model->rec_id,
);

$this->menu=array(
	array('label'=>'List BlackListedMobile', 'url'=>array('index')),
	array('label'=>'Create BlackListedMobile', 'url'=>array('create')),
	array('label'=>'Update BlackListedMobile', 'url'=>array('update', 'id'=>$model->rec_id)),
	array('label'=>'Delete BlackListedMobile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->rec_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BlackListedMobile', 'url'=>array('admin')),
);
?>

<h1>View BlackListedMobile #<?php echo $model->rec_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rec_id',
		'queue_id',
		'mobile_number',
		'date_created',
		'date_updated',
	),
)); ?>
