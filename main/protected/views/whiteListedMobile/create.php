<?php
/* @var $this WhiteListedMobileController */
/* @var $model WhiteListedMobile */

$this->breadcrumbs=array(
	'White Listed Mobiles'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WhiteListedMobile', 'url'=>array('index')),
	array('label'=>'Manage WhiteListedMobile', 'url'=>array('admin')),
);
?>

<h1>Create WhiteListedMobile</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>