<?php
/* @var $this WhiteListedMobileController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'White Listed Mobiles',
);

$this->menu=array(
	array('label'=>'Create WhiteListedMobile', 'url'=>array('create')),
	array('label'=>'Manage WhiteListedMobile', 'url'=>array('admin')),
);
?>

<h1>White Listed Mobiles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
