<?php
/* @var $this WhiteListedMobileController */
/* @var $model WhiteListedMobile */

$this->breadcrumbs=array(
	'White Listed Mobiles'=>array('index'),
	$model->rec_id=>array('view','id'=>$model->rec_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WhiteListedMobile', 'url'=>array('index')),
	array('label'=>'Create WhiteListedMobile', 'url'=>array('create')),
	array('label'=>'View WhiteListedMobile', 'url'=>array('view', 'id'=>$model->rec_id)),
	array('label'=>'Manage WhiteListedMobile', 'url'=>array('admin')),
);
?>

<h1>Update WhiteListedMobile <?php echo $model->rec_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>