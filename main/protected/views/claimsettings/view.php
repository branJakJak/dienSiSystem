<?php
/* @var $this ClaimsettingsController */
/* @var $model Claimsettings */

$this->breadcrumbs=array(
	'Claimsettings'=>array('index'),
	$model->settings_id,
);

$this->menu=array(
	array('label'=>'List Claimsettings', 'url'=>array('index')),
	array('label'=>'Create Claimsettings', 'url'=>array('create')),
	array('label'=>'Update Claimsettings', 'url'=>array('update', 'id'=>$model->settings_id)),
	array('label'=>'Delete Claimsettings', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->settings_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Claimsettings', 'url'=>array('admin')),
);
?>

<h1>View Claimsettings #<?php echo $model->settings_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'settings_id',
		'settings_key',
		'settings_val',
		'date_created',
		'date_updated',
		'settings_owner',
	),
)); ?>
