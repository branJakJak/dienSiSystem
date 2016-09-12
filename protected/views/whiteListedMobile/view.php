<?php
/* @var $this WhiteListedMobileController */
/* @var $model WhiteListedMobile */

$this->breadcrumbs=array(
	'White Listed Mobiles'=>array('index'),
	$model->rec_id,
);

$this->menu=array(
	array('label'=>'List WhiteListedMobile', 'url'=>array('index')),
	array('label'=>'Create WhiteListedMobile', 'url'=>array('create')),
	array('label'=>'Update WhiteListedMobile', 'url'=>array('update', 'id'=>$model->rec_id)),
	array('label'=>'Delete WhiteListedMobile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->rec_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WhiteListedMobile', 'url'=>array('admin')),
);
?>

<h1>View WhiteListedMobile #<?php echo $model->rec_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rec_id',
		'queue_id',
		'mobile_number',
		'status',
		'date_created',
		'date_updated',
	),
)); ?>
