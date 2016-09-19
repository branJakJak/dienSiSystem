<?php
/* @var $this BlackListedMobileController */
/* @var $model BlackListedMobile */

$this->breadcrumbs=array(
	'Black Listed Mobiles'=>array('index'),
	$model->rec_id=>array('view','id'=>$model->rec_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BlackListedMobile', 'url'=>array('index')),
	array('label'=>'Create BlackListedMobile', 'url'=>array('create')),
	array('label'=>'View BlackListedMobile', 'url'=>array('view', 'id'=>$model->rec_id)),
	array('label'=>'Manage BlackListedMobile', 'url'=>array('admin')),
);
?>

<h1>Update BlackListedMobile <?php echo $model->rec_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>