<?php
/* @var $this BlackListedMobileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Black Listed Mobiles',
);

$this->menu=array(
	array('label'=>'Create BlackListedMobile', 'url'=>array('create')),
	array('label'=>'Manage BlackListedMobile', 'url'=>array('admin')),
);
?>

<h1>Black Listed Mobiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
