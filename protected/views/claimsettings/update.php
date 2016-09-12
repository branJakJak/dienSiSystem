<?php
/* @var $this ClaimsettingsController */
/* @var $model Claimsettings */

$this->breadcrumbs=array(
	'Claimsettings'=>array('index'),
	$model->settings_id=>array('view','id'=>$model->settings_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Claimsettings', 'url'=>array('index')),
	array('label'=>'Create Claimsettings', 'url'=>array('create')),
	array('label'=>'View Claimsettings', 'url'=>array('view', 'id'=>$model->settings_id)),
	array('label'=>'Manage Claimsettings', 'url'=>array('admin')),
);
?>

<h1>Update Claimsettings <?php echo $model->settings_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>