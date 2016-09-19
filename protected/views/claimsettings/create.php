<?php
/* @var $this ClaimsettingsController */
/* @var $model Claimsettings */

$this->breadcrumbs=array(
	'Claimsettings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Claimsettings', 'url'=>array('index')),
	array('label'=>'Manage Claimsettings', 'url'=>array('admin')),
);
?>

<h1>Create Claimsettings</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>